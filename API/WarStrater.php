<?php
/**
 * Version 1
 * List all participant of current war 
 * collect their war stats
 * calculate optimal dispatch
 * Feed strat table
 */ 
require '../include/conf.db.php';
require '../include/class_War.php';
require '../include/class_Attacks.php';

class Knight {
	public $Player_ID;
	public $MapRank;
	
	public $Strength = 0;
	
	public $calc_warCount = 0;
	public $calc_atkCount = 0;
	public $arr_wars = [];
	
	static function cmp_obj($a, $b)
	{
		if ($a->Strength == $b->Strength) {
			return 0;
		}
		return ($a->Strength> $b->Strength) ? +1 : -1;
	}

}

// db connect
try {
	$db = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
	exit ('Connection failed: ' . $e->getMessage());
}

// managers
$WarManager = new WarManager($db);
$AttackManager = new AttackManager($db);


// CurrentWar (warid, warsize)
$CurrentWar = $WarManager->getLastWarFromDb();

// player list and positions
$CurrentWarParticipants = $AttackManager->getAttacks($CurrentWar->id());

$Knights = [];
foreach($CurrentWarParticipants as $Participant) {
	if (intval($Participant->MapRank()) > 0) {
		$Knight = new Knight;
		$Knight->Player_ID= $Participant->Player_ID();
		$Knight->MapRank = $Participant->MapRank();
		
		$Knights[] = $Knight;
	}
}

// cellect strater settings
$Settings = [];
$sql = "SELECT `parameter`, `value` FROM `coc_settings` WHERE `cathegory` = 'strater'";
$qry = $db->query($sql);
while ($res = $qry->fetch(PDO::FETCH_ASSOC)) {
	$Settings[$res["parameter"]] = $res["value"];
}

// define oldest war
$DateOldestWar = (new DateTime())->sub(new DateInterval('P' . $Settings["timeframe"] . 'D'));
$specifics=["filter" => "datewar < '" . $DateOldestWar->format("Y-m-d") . "'", "orderBy" => "datewar DESC", "limit" => 1];
$idOldestWar = $WarManager->getWarsBySpecific($specifics)[0]->id();

// get previous attacks details to create their strength
foreach ($Knights as $Knight) {
	$warCount = 0;
	$warid = $CurrentWar->id() - 1;
	while ($warCount < $Settings["nbwars"] && $warid >= $idOldestWar) {
		if($Attacks = $AttackManager->getPlayerAttacksDuringWar($Knight->Player_ID, $warid)) {
			// get all attacks of the war
			$WarAtks = $AttackManager->getAttacks($warid);
			
			$Knight->arr_wars[] = $warid;
			$Knight->calc_warCount += 1;
			
			if ($Attacks->Attack_1_Rank() > 0) {
				$Knight->calc_atkCount += 1;
				$oppTH = $AttackManager->OpponentAtPosition($WarAtks, $Attacks->Attack_1_Rank())->Player_TH();
				if ($Attacks->Attack_1_Star() == 3) {
					$score = 3;
				} else {
					$score = $Attacks->Attack_1_Star() + ($Attacks->Attack_1_Percentage() / 100);
				}
				
				$Knight->Strength = ($Knight->Strength * ($Knight->calc_warCount - 1) + $score * 
					(1 + ($Attacks->MapRank() - $Attacks->Attack_1_Rank()) / ($Settings["posCoef"] * (count($WarAtks)/2))) *
					(1 + ($oppTH - $Attacks->Player_TH()) / $Settings["THCoef"]) *
					(1 + ($warid - $CurrentWar->id()) / $Settings["warCoef"])) / $Knight->calc_warCount;
				
			}
			
			if ($Attacks->Attack_2_Rank() > 0) {
				$Knight->calc_atkCount += 1;
				$oppTH = $AttackManager->OpponentAtPosition($WarAtks, $Attacks->Attack_2_Rank())->Player_TH();
				
				if ($Attacks->Attack_2_Star() == 3) {
					$score = 3;
				} else {
					$score = $Attacks->Attack_2_Star() + ($Attacks->Attack_2_Percentage() / 100);
				}
				
				$Knight->Strength = ($Knight->Strength * ($Knight->calc_warCount - 1) + $score *
						(1 + ($Attacks->MapRank() - $Attacks->Attack_2_Rank()) / ($Settings["posCoef"] * (count($WarAtks)/2))) *
						(1 + ($oppTH - $Attacks->Player_TH()) / $Settings["THCoef"]) *
						(1 + ($warid - $CurrentWar->id()) / $Settings["warCoef"])) / $Knight->calc_warCount;
						
			}
			// Increase war counter
			$warCount += 1;
		}
		// check previous war
		$warid -= 1;
	}
}

// Apply Map Rating
foreach ($Knights as $Knight) {$Knight->Strength *= (1 + count($Knights) - $Knight->MapRank) / count($Knights);}
// Sorting
usort($Knights, array("Knight", "cmp_obj"));
// Applying Strat
$x = count($Knights);
$sql = "";
foreach ($Knights as $Knight) {
	$sql .= "Update `coc_currentwar_strat` SET `target` = '" . $x . "' WHERE `id` = '". $Knight->MapRank. "-1'; ";
	$x -= 1;
}
$qry = $db->exec($sql);

?>
