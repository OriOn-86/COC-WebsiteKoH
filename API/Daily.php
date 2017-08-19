<?php
// configuraiton files
require (__DIR__ . "/../include/conf.db.php");
require (__DIR__ . "/../include/conf.api.php");
// object files
require (__DIR__ . "/../include/class_Member.php");
require (__DIR__ . "/../include/class_War.php");

// db connect
try {
	$db = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
	exit ('Connection failed: ' . $e->getMessage());
}
// init managers
$MemberManager = new MemberManager($db);
$WarManager = new WarManager($db);

// date
$date = (new DateTime(strftime('%Y-%m-%d')))->sub(new DateInterval('P1D'));
$daterecord = $date->format('Y-m-d');

// functions
function dailyRecord () {
	global $ch, $db, $urlClan, $daterecord;
	// query api
	curl_setopt($ch, CURLOPT_URL, $urlClan);
	$res = curl_exec($ch);
	if (curl_errno($ch)) {
		$sql = 'INSERT INTO `coc_logs` (`date`, `log`) VALUES ("' . $daterecord . '", "[dailyRecord].API_Error: "' . curl_error($ch) . ');';
		$db->exec($sql);
	} else {
		$ClanData = (json_decode($res));
		// TODO create dailymanager function for the following >> END To DO
		// $DailyManager->getDailyFromJSON($daterecord, $json_array);
		$clanLevel = $ClanData->clanLevel;
		$clanPoints = $ClanData->clanPoints;
		$clanMembers = $ClanData->members;
		$clanVersusPoints = $ClanData->clanVersusPoints;
		$id = [];
		$name = [];
		$role = [];
		$expLevel = [];
		$league = [];
		$trophies = [];
		$versusTrophies = [];
		$clanRank = [];
		$donations = [];
		$donationsReceived = [];

		for ($i = 0; $i < count($ClanData->memberList); $i++) {
			$id[] = substr($ClanData->memberList[$i]->tag, 1); // removes the #
			$name[] = $ClanData->memberList[$i]->name;
			$role[] = $ClanData->memberList[$i]->role;
			$expLevel[] = $ClanData->memberList[$i]->expLevel;
			$league[] = $ClanData->memberList[$i]->league->name;
			$trophies[] = $ClanData->memberList[$i]->trophies;
			$versusTrophies[] = $ClanData->memberList[$i]->versusTrophies;
			$clanRank[] = $ClanData->memberList[$i]->clanRank;
			$donations[] = $ClanData->memberList[$i]->donations;
			$donationsReceived[] = $ClanData->memberList[$i]->donationsReceived;
		}
		// log Clan data
		$sql = 'INSERT INTO `coc_dailyclandata` (`daterecord`, `clanlevel`, `clanmembers`, `clanpoints`, `clanVersusPoints`) VALUES ("' . $daterecord . '", ' . $clanLevel . ', ' . $clanMembers . ', ' . $clanPoints . ', ' . $clanVersusPoints . '); ';
		// log members data
		foreach($name as $a => $b) {
			$sql = $sql . 'INSERT INTO `coc_dailydata` (`date`, `player_tag`, `name`, `role`, `expLevel`, `league`, `trophies`, `versusTrophies`, `clanRank`, `donations`, `donationsReceived`) ' .
					'VALUES ("' . $daterecord . '", "' . $id[$a] . '", "' . $name[$a] . '", "' . $role[$a] . '", ' . $expLevel[$a] . ', "' . $league[$a] . '", ' . $trophies[$a] . ', ' . $versusTrophies[$a] . ', ' . $clanRank[$a] . ', ' .
					$donations[$a] . ', ' . $donationsReceived[$a] . '); ';
		}
		// log entry
		$sql = $sql . 'INSERT INTO `coc_logs` (`date`, `log`) VALUES ("' . $daterecord . '", "Daily record from API.");';
		$db->exec($sql);
		// << END To DO 
	}
	sleep(1); // sleep a sec for API query cooldown
	return $id; // active members' id
}

function minimaChecks($MemberTag) {
	// Check if member fullfills clan donations requirements
	// initial values
	global $db, $daterecord;
	$MinThreshold = 100; // parameter adjustable in the future.
	
	$date = (new DateTime($daterecord))->sub(new DateInterval('P7D'));
	$D_Count = 0;
	$R_Count = 0;
	// check season status
	$sql = "SELECT `season_week` FROM `coc_seasons` ORDER BY `id` DESC LIMIT 1";
	$qry = $db->query($sql);
	$res = $qry->fetch(PDO::FETCH_ASSOC);
	if ($res > 0) {
		$sql = "SELECT `donations`, `donationsReceived` FROM `coc_dailydata` WHERE `date` = \"" . $date->format('Y-m-d') . "\" AND `player_tag`='$MemberTag'";
		if ($qry = $db->query($sql)) {
			while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {
				$D_Initial = $row['donations'];
				$R_Initial = $row['donationsReceived'];
			}
		} else {
			// player wasn't present last week therefore weekly check does not apply.
			return;
		}
	} else {
		$D_Initial = 0;
		$R_Initial = 0;
	}
	$D_Final = $D_Initial;
	$R_Final = $R_Initial;
	// loop over the week
	$date = (new DateTime($daterecord))->add(new DateInterval('P1D'));
	while ($date <= $daterecord) {
		$sql = "SELECT `donations`, `donationsReceived` FROM `coc_dailydata` WHERE `date` = \"" . $date->format('Y-m-d') . "\" AND `player_tag`='$MemberTag'";
		if ($qry = $db->query($sql)) {
			while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {
				if ($R_Final <= $row['donationsReceived']) { // expected
					// increment counters
					$D_Count += $row['donations'] - $D_Final;
					$R_Count += $row['donationsReceived'] - $R_Final;
				} else { // player was out of the clan since the previous day's log
					// increment counters
					$D_Count += $row['donations'];
					$R_Count += $row['donationsReceived'];
				}
				// update initial values
				$D_Final = $row['donations'];
				$R_Final = $row['donationsReceived'];
			}
		} else {
			// player was missing more than a day. weekly check cannot be verified.
			return;
		}
		$date->add(new DateInterval('P1D'));
	}
	// compare week results with requirements and log infractions.
	$infraction = 0;
	if ($D_Count < $MinThreshold) {
		$infraction += 1;
	}
	if ($R_Count < $MinThreshold) {
		$infraction += 2;
	}
	if ($infraction > 0) {
		$sql = "INSERT INTO `coc_weeklyanalysis` (`date`, `player_tag`, `infraction`, `D_Initial`, `D_Final`, `R_Initial`, `R_Final`) VALUES ('$daterecord', '$MemberTag', $infraction, $D_Initial, $D_Final, $R_Initial, $R_Final);";
		$db->exec($sql);
		sleep(1); // cooldown
	}
}

function newWarCheck() {
	// Check if new war to record.
	global $ch, $daterecord, $db, $urlWar, $WarManager;
	curl_setopt($ch, CURLOPT_URL, $urlWar);
	$res = curl_exec($ch);
	if (curl_errno($ch)) {
		$sql = 'INSERT INTO `coc_logs` (`date`, `log`) VALUES ("' . $daterecord . '", "[newWarCheck].API_Error: "' . curl_error($ch) . ');';
		$db->exec($sql);
	} else {
		$json_array = (json_decode($res));
		$APILastWar = $WarManager->getWarFromJSON($json_array);
		if ($WarManager->Exists($APILastWar->datewar())>0){
			$WarManager->addWarToDb($APILastWar, "warlog");
		}
	}
	sleep(1); // cooldown
}

function Screen ($MemberTag) {
	// API query on player_tag
	global $ch, $daterecord, $db, $urlMember, $MemberManager;
	curl_setopt($ch, CURLOPT_URL, $urlMember . urlencode('#' . $MemberTag));
	$res=curl_exec($ch);
	if (curl_errno($ch)) {
		$sql = 'INSERT INTO `coc_logs` (`date`, `log`) VALUES ("' . $daterecord . '", "API_Error: "' . curl_error($ch) . ');';
		$db->exec($sql);
	} else {
		$json_array = (json_decode($res));
		$Knight = $MemberManager->getFromJSON($daterecord, $json_array);
		$MemberManager->add($Knight);
	}
	sleep(1); // sleep a sec for API query cooldown
}

function ScreenNewMembers ($Members) {
	// look for new members compared to the previous day
	global $db;
	foreach ($Members as $Member) {
		$sql = "SELECT COUNT(*) FROM `coc_weeklydata` WHERE `player_tag`='" . $Member ."';";
		if ($db->query($sql)->fetchcolumn()==0) {
			Screen($Member);
		}
	}
}
// Main script
// - Perform daily tasks
$activeMembers = dailyRecord();
newWarCheck();
// - Check Day
Switch (date("w", strtotime($daterecord))) {
	Case 1: // Mondays: check for new seasons and screen new members
		// increase week counter of the season.
		/* $sql = "SELECT `id`, `season_week` FROM `coc_seasons` ORDER BY `season_start` DESC LIMIT 1; ";
		$qry = $db->exec($sql);
		while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {
			$idSeason = $row['id'];
			$nbWeek = $row['season_week'];
		}
		$nbWeek += 1;
		$sql = "UPDATE `coc_seasons` SET `season_week`=$nbWeek WHERE `id`=$idSeason; ";

		if (date("j", $daterecord) < 7) {
			// New season:
			$sql .= "INSERT INTO `coc_seasons` (`season_start`, `season_week`) VALUES ('$daterecord', 0); ";
			$sql .= "INSERT INTO `coc_logs`(`date`, `log`) VALUES ('$daterecord', 'New Season'); ";
		}
		$db->exec($sql);
		sleep(1); // cooldown */
		
		ScreenNewMembers($activeMembers);
		break;

	Case 0: // Sundays: screen all members
		foreach ($activeMembers as $activeMember) {
			Screen($activeMember);
			minimaChecks($activeMember);
		}
		$sql = "INSERT INTO `coc_logs`(`date`, `log`) VALUES ('$daterecord', 'Weekly records');";
		$db->exec($sql);
		sleep(1); // cooldown
		break;

	default: // other days: screen new members
		ScreenNewMembers($activeMembers);
		break;
		
}
// That's about it.
curl_close($ch);
?>

