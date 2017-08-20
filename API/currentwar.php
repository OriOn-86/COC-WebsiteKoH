<?php 
require (__DIR__ . "/../include/class_War.php");
require (__DIR__ . "/../include/class_Attacks.php");
require (__DIR__ . "/../include/conf.db.php");
require (__DIR__ . "/../include/conf.api.php");

// db connect
try {
	$db = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
	exit ('Connection failed: ' . $e->getMessage());
}

// init managers
$AttackManager = new AttackManager($db);
$CurrentWarManager = new WarManager($db);

// php functions
function shortBadgeUrl($badgeUrl) {
// removes 47 characters "https://api-assets.clashofclans.com/badges/200/" from medium sized clan badge
	if (is_string($badgeUrl)) {
		return substr($badgeUrl, 47);
	} else {
		return "";
	}
}
function Nz($variable, $default) {
// Nz return $default value if NULL
	return isset($variable)?$variable:$default;
}

//
// currentwar API
//
curl_setopt($ch, CURLOPT_URL, $urlCurrentWar);
$res = curl_exec($ch);
if (curl_errno($ch)) {
	$sql = 'INSERT INTO `coc_logs` (`date`, `log`) VALUES ("' . $daterecord . '", "[qryAPICurrentWar].API_Error: "' . curl_error($ch) . ');';
	$db->exec($sql);
} else {
	$CurrentWar = (json_decode($res));
	// check last war(id) from db
	$dbLastWar = $CurrentWarManager->getLastWarFromDb();
	$WarID = $dbLastWar->id();
	$dbLastWarOpponent = $dbLastWar->opponent_tag();
	$CurrentWarOpponent = $CurrentWar->opponent->tag;
	$FirstEntry = ($dbLastWarOpponent <> $CurrentWarOpponent) ? True : False;
	// update new warid if FirstEntry
	if ($FirstEntry) {$WarID += 1;}
	// check war status
	$warState = $CurrentWar->state;
	// split currentwar[] into coc_wars[] and coc_wars_current[]
	$war = new War([]);
	$Attacks = [];
	// $war
	$war->setid($WarID);
	$war->setState($CurrentWar->state);
	$endTime = $CurrentWar->endTime;
	$endTime = substr_replace(substr_replace(substr($endTime, 0, 8), "-", 6, 0), "-", 4, 0);
	$war->setDatewar($endTime);
	$war->setTeam_size($CurrentWar->teamSize);
	$war->setKoh_badgeUrl(shortBadgeUrl($CurrentWar->clan->badgeUrls->medium));
	$war->setKoh_clanLevel($CurrentWar->clan->clanLevel);
	$war->setKoh_stars($CurrentWar->clan->stars);
	$war->setKoh_attacks($CurrentWar->clan->attacks);
	$war->setKoh_destructionPercentage($CurrentWar->clan->destructionPercentage);
	$war->setOpponent_tag($CurrentWar->opponent->tag);
	$war->setOpponent_name($CurrentWar->opponent->name);
	$war->setOpponent_badgeUrl(shortBadgeUrl($CurrentWar->opponent->badgeUrls->medium));
	$war->setOpponent_clanLevel($CurrentWar->opponent->clanLevel);
	$war->setOpponent_stars($CurrentWar->opponent->stars);
	$war->setOpponent_attacks($CurrentWar->opponent->attacks);
	$war->setOpponent_destructionPercentage($CurrentWar->opponent->destructionPercentage);
	// clan members attacks/defenses.
	foreach ($CurrentWar->clan->members as $Member) {
		$Attack = new Attacks([]);
		$Attack->setWarid($WarID);
		$Attack->setMapRank($Member->mapPosition);
		$Attack->setPlayer_ID($Member->tag);
		$Attack->setPlayer_TH($Member->townhallLevel);
		$Attack->setAttacked($Member->opponentAttacks);
		// def
		if ($Member->opponentAttacks > 0) {
			// lookup best oppenent position in a previous record of the database
			$position = $AttackManager->getMapPosition($WarID, $Member->bestOpponentAttack->attackerTag);
			$Attack->setEBA_AttackerRank(abs($position));
			$Attack->setEBA_Destruction($Member->bestOpponentAttack->destructionPercentage);
			$Attack->setEBA_Star($Member->bestOpponentAttack->stars);
		}
		// atk
		if (isset($Member->attacks)) {
			$atkCount = count($Member->attacks);
			// atk1
			$position = $AttackManager->getMapPosition($WarID, $Member->attacks[0]->defenderTag);
			$Attack->setAttack_1_Rank(abs($position));
			$Attack->setAttack_1_Percentage($Member->attacks[0]->destructionPercentage);
			$Attack->setAttack_1_Star($Member->attacks[0]->stars);
			$Attack->setAttack_1_Order($Member->attacks[0]->order);
			if ($atkCount > 1) {
				// atk2
				$position = $AttackManager->getMapPosition($WarID, $Member->attacks[1]->defenderTag);
				$Attack->setAttack_2_Rank(abs($position));
				$Attack->setAttack_2_Percentage($Member->attacks[1]->destructionPercentage);
				$Attack->setAttack_2_Star($Member->attacks[1]->stars);
				$Attack->setAttack_2_Order($Member->attacks[1]->order);
			}
		}
		$Attacks[] = $Attack;
	}
	// opponents attacks/defenses.
	foreach ($CurrentWar->opponent->members as $Member) {
		$Attack = new Attacks([]);
		$Attack->setWarid($WarID);
		$Attack->setMapRank(-$Member->mapPosition);
		$Attack->setPlayer_ID($Member->tag);
		$Attack->setPlayer_TH($Member->townhallLevel);
		$Attack->setAttacked($Member->opponentAttacks);
		// def
		if ($Member->opponentAttacks > 0) {
			// lookup best oppenent position in a previous record of the database
			$position = $AttackManager->getMapPosition($WarID, $Member->bestOpponentAttack->attackerTag);
			$Attack->setEBA_AttackerRank(abs($position));
			$Attack->setEBA_Destruction($Member->bestOpponentAttack->destructionPercentage);
			$Attack->setEBA_Star($Member->bestOpponentAttack->stars);
		}
		// atk
		if (isset($Member->attacks)) {
			$atkCount = count($Member->attacks);
			// atk1
			$position = $AttackManager->getMapPosition($WarID, $Member->attacks[0]->defenderTag);
			$Attack->setAttack_1_Rank(abs($position));
			$Attack->setAttack_1_Percentage($Member->attacks[0]->destructionPercentage);
			$Attack->setAttack_1_Star($Member->attacks[0]->stars);
			if ($atkCount > 1) {
				// atk2
				$position = $AttackManager->getMapPosition($WarID, $Member->attacks[1]->defenderTag);
				$Attack->setAttack_2_Rank(abs($position));
				$Attack->setAttack_2_Percentage($Member->attacks[1]->destructionPercentage);
				$Attack->setAttack_2_Star($Member->attacks[1]->stars);
			}	
		}
		$Attacks[] = $Attack;
	}
	if ($FirstEntry) {
		// cleanup target cells from previous war.
		$sql = "UPDATE `coc_currentwar_strat` SET `target`='' WHERE 1;";
		$db->exec($sql);
		// store new values
		$CurrentWarManager->AddWarToDb($war);
		$AttackManager->AddWarAttacks($Attacks);
		// launch botstrater
		include_once __DIR__ . 'WarStrater.php';
	} elseif (($warState == "inWar") OR ($warState == "warEnded")) {
		// update war and attacks with newer information
		$CurrentWarManager->UpdateWar($war);
		$AttackManager->UpdateWarAttacks($Attacks);
	}
	// calculate effective stars (star points earned by player during the war)
	if ($warState == "warEnded") {
		$AttackManager->CalculateEffectiveStar($WarID);
	}
	// update log
	//$sql = "UPDATE `coc_logs` SET `date`=:date, `time`=:time WHERE `log`='Last currentwar update'"
}


?>
