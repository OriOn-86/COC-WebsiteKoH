<?php
// configuraiton files
require ("/var/www/html/include/conf.db.php");
require ("/var/www/html/include/conf.api.php");
// object files
require ("/var/www/html/include/class_Member.php");
require ("/var/www/html/include/class_War.php");

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
function activeMember() {
// return array of active member.
	global $db;
	$sql = "SELECT `player_tag` FROM `coc_dailydata` WHERE `date`='$daterecord';";
	$qry = $db->query($sql);
	while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {
		$activeMembers[] = $row['player_tag'];
	}
	return $activeMembers;
}

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
		$clanLevel = $ClanData->clanLevel;
		$clanPoints = $ClanData->clanPoints;
		$clanMembers = $ClanData->members;
		$id = array();
		$name = array();
		$role = array();
		$expLevel = array();
		$league = array();
		$trophies = array();
		$clanRank = array();
		$donations = array();
		$donationsReceived = array();
		for ($i = 0; $i < count($ClanData->memberList); $i++) {
			array_push($id, substr($ClanData->memberList[$i]->tag, 1)); // removes the #
			array_push($name, $ClanData->memberList[$i]->name);
			array_push($role, $ClanData->memberList[$i]->role);
			array_push($expLevel, $ClanData->memberList[$i]->expLevel);
			array_push($league, $ClanData->memberList[$i]->league->name);
			array_push($trophies, $ClanData->memberList[$i]->trophies);
			array_push($clanRank, $ClanData->memberList[$i]->clanRank);
			array_push($donations, $ClanData->memberList[$i]->donations);
			array_push($donationsReceived, $ClanData->memberList[$i]->donationsReceived);
		}
		// log Clan data
		$sql = 'INSERT INTO `coc_dailyclandata` (`daterecord`, `clanlevel`, `clanmembers`, `clanpoints`) VALUES ("' . $daterecord . '", ' . $clanLevel . ', ' . $clanMembers . ', ' . $clanPoints . '); ';
		// log members data
		foreach($name as $a => $b) {
			$sql = $sql . 'INSERT INTO `coc_dailydata` (`date`, `player_tag`, `name`, `role`, `expLevel`, `league`, `trophies`, `clanRank`, `donations`, `donationsReceived`) ' .
				'VALUES ("' . $daterecord . '", "' . $id[$a] . '", "' . $name[$a] . '", "' . $role[$a] . '", ' . $expLevel[$a] . ', "' . $league[$a] . '", ' . $trophies[$a] . ', ' . $clanRank[$a] . ', ' .
				$donations[$a] . ', ' . $donationsReceived[$a] . '); ';
		}
		// log entry
		$sql = $sql . 'INSERT INTO `coc_logs` (`date`, `log`) VALUES ("' . $daterecord . '", "Daily record from API.");';
		$db->exec($sql);
	}
	sleep(1); // sleep a sec for API query cooldown
}

function memberCheck () {
// look for new members compared to the previous day
	global $db, $date, $daterecord;
	$newMembers=[];
	$date->sub(new DateInterval('P1D'));
	$previousDate = $date->format('Y-m-d');
	$sql = "SELECT `player_tag` FROM `coc_dailydata` WHERE `date`='$daterecord';";
	$sql2 = "SELECT `player_tag` FROM `coc_dailydata` WHERE `date`='$previousDate' AND `player_tag`=:player_tag";
	$qry = $db->query($sql);
	$sth = $db->prepare($sql2);
	while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {
		$sth->execute(array($row['player_tag']));
		$OldMember = $sth->fetchall();
		if (count($OldMember) == 0) {
			$newMembers[] = $row['player_tag'];
		}
	}
	return $newMembers;
}

function minimaChecks($MemberTag) {
// Check if member fullfills clan donations requirements
	// initial values	
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
		$DBLastWar = $WarManager->getLastWarFromDb();
		if ($APILastWar->datewar() <> $DBLastWar->datewar()) {
			$WarManager->addWarToDb($APILastWar);
		}
	}
	sleep(1); // cooldown
}

function Screen ($MemberTag) {
	// API query on player_tag
	global $ch, $daterecord, $db, $urlMember, $MemberManager;
	curl_setopt($ch, CURLOPT_URL, $urlMember . urlencode($MemberTag));
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



// Main script
//// Perform daily tasks
dailyRecord();
newWarCheck();
//// Check for new members
$newMembers = memberCheck();
//// (If any) screen new members
if (count($newMembers) > 0) {
	foreach ($newMembers as $newMember) {
		Screen($NewMember);
	}
}
//// Check Day
////// Mondays check for new seasons
////// Sundays Screen all members
Switch (date("w", strtotime($daterecord))) {
	Case 1: // Mondays
		// increase week counter of the season.
		$sql = "SELECT `id`, `season_week` FROM `coc_seasons` ORDER BY `season_start` DESC LIMIT 1; ";
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
		sleep(1); // cooldown
		break;

	Case 0: // Sundays
		$activeMembers = activeMembers();
		foreach ($activeMembers as $activeMember) {
			Screen($activeMember);
			minimaChecks($activeMember);
		}
		$sql = "INSERT INTO `coc_logs`(`date`, `log`) VALUES ('$daterecord', 'Weekly records');";
		$db->exec($sql);
		sleep(1); // cooldown
		break;
}
// That's about it.
curl_close($ch);
?>

