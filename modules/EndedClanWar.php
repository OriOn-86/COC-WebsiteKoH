<?php

/**
 * AtkResult displays attack's result
 * @param integer $Stars number to translate into images
 * @param integer $Percentage destruction percentage
 * @return string
 */
function AtkResult ($Stars, $Percentage) {
	$strResult = "	<div class='stars'>";
	for ($Star = 1; $Star <= 3; $Star++) {
		if ($Star <= $Stars) {
			$strResult .= "<img class='star' src='images/starON.png' />";
		} else {
			$strResult .= "<img class='star' src='images/starOFF.png' />";
		}
	}
	$strResult .= "</div><div class='percent'><p>" . $Percentage . " %</p></div>";
	return $strResult;
}


// import classes
require("include/class_War.php");
require("include/class_Attacks.php");
// create objects
$CWManager = new WarManager($db);
$AManager = new AttackManager($db);

if (isset($_GET["warid"])){
	if (is_numeric($_GET["warid"])) {
		$warid = $_GET["warid"];
		$currentWar = $CWManager->getWarFromID($warid);
	} else {
		$currentWar = $CWManager->getLastWarFromDb();
	}
} else {
	$currentWar = $CWManager->getLastWarFromDb();
}

$Fighters = $AManager->getAttacks($currentWar->id());

// module header
echo "
<div id='CurrentWarHeader'>
	<div class='CWHrow'>
		<div class='CWHClanName'><p>Knights of Hell</p></div>
		<div class='ClanBadge'><img src='https://api-assets.clashofclans.com/badges/200/" . $currentWar->koh_badgeUrl() . "'/><p>" . $currentWar->koh_clanLevel() . "</p></div>
		<div id='versus'><p>VS</p></div>
		<div class='ClanBadge'><img src='https://api-assets.clashofclans.com/badges/200/" . $currentWar->opponent_badgeUrl() . "'/><p> " . $currentWar->opponent_clanLevel() . "</p></div>
		<div class='CWHClanName'><p>" . $currentWar->opponent_name() . "</p></div>
	</div>
				
	<div class='CWHrow'>
		<div class='StarScore'><img src='images/starScore.png' /></div>
		<div class='Scores'>
			<div style='width:" . $currentWar->koh_stars()*100/($currentWar->team_size() * 3) . "%'>" . $currentWar->koh_stars() . " / " . $currentWar->team_size() * 3 . "</div>
		</div>
		<div class='CWHRmiddle' id='RemainingTime'>" . $currentWar->result() . "</div>
		<div class='Scores'>
			<div class='OpponentScore' style='width:" . $currentWar->opponent_stars()*100/($currentWar->team_size() * 3) . "%'>" . $currentWar->opponent_stars() . " / " . $currentWar->team_size() * 3 . "</div>
		</div>
		<div class='OpponentScore StarScore'><img src='images/starScore.png' /></div>
	</div>
					
	<div class='CWHrow'>
		<div id='ClanAtkCount'>" . $currentWar->koh_attacks() . " / " . $currentWar->team_size() * 2 . "</div>
		<div class='CWHRmiddle' id='CWstate'>" . $currentWar->state() . "</div>
		<div id='OpponentAtkCount'>" . $currentWar->opponent_attacks() . " / " . $currentWar->team_size() * 2 . "</div>
	</div>
</div>
</section>";

// module content
echo "
<section>
<div id='CurrentWarTable'>
	<div id='CWTHeader'>
		
	</div>";
$WarSize = $currentWar->team_size();
for ($x = 1; $x <= $WarSize; $x++) {
	$Member = $AManager->MemberAtPosition($Fighters, $x);
	echo "
	<div class='CWTRow'>
	<div class='member'>
	<div class='position'>$x</div>
	<div class='TH-Destruction'><img class='TH' src='images/profile/TownHall/TownHall_" . $Member->Player_TH() . ".png' /></div>
	<div class='EBA'>" . AtkResult($Member->EBA_Star(), $Member->EBA_Destruction()) . "</div>
	<div class='playerName'><p>" . $Member->Player_Name() . "</p><a href=\"index.php?op=playerprofile&PlayerTag=" . substr($Member->Player_ID(), 1) . "\"><img src='images/burger.png'/></a></div>
	<div class='Attack'>";
	if ($Member->Attack_1_Rank()!=0) {
		echo "
		<div class='target'><img src='images/target.png' /><p>". $Member->Attack_1_Rank() ."</p></div>" . 
		AtkResult($Member->Attack_1_Star(), $Member->Attack_1_Percentage());
	} else {
		echo "
		<div class='NotUsed'>Non Jouée</div>";
	}
	echo "
	</div>
	<div class='Attack'>";
	if ($Member->Attack_2_Rank()!=0) {
		echo "
		<div class='target'><img src='images/target.png' /><p>". $Member->Attack_2_Rank() ."</p></div>" .
		AtkResult($Member->Attack_2_Star(), $Member->Attack_2_Percentage());
	} else {
		echo "
		<div class='NotUsed'>Non Jouée</div>";
	}
	echo "
	</div>
	</div>";
	
	$Opponent = $AManager->OpponentAtPosition($Fighters, $x);
	echo "
	<div class='opponent'>
		<div class='position'>$x</div>
		<div class='TH-Destruction'><img class='TH' src='images/profile/TownHall/TownHall_" . $Opponent->Player_TH() . ".png' /></div>
		<div class='EBA'>" . AtkResult($Opponent->EBA_Star(), $Opponent->EBA_Destruction()) . "</div>
	</div>
	</div>";
}
echo "
</div>
</section>
";