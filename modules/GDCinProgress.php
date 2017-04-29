<?php
// GDCinProgress.php
// GDC table for strategy dev and adjustments.

// db connect
try {
	$db = new PDO($dsn, $user, $password);
} catch(PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
}

// import classes
require("include/class_CurrentWar.php");
require("include/class_Attacks.php");

// function 
function Nz($variable, $default) {
	return isset($variable)?$variable:$default;
}

// create objects
$CWManager = new CurrentWarManager($db);
$AManager = new AttackManager($db);

$currentWar = $CWManager->getLastWarFromDb();
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
		<div id='ClanScore'>" . Nz($currentWar->koh_stars(), 0) . " / " . $currentWar->team_size() * 3 . " Stars</div>
		<div class='CWHRmiddle' id='RemainingTime'>" . "</div>
		<div id='OpponentScore'>" . Nz($currentWar->opponent_stars(), 0) . " / " . $currentWar->team_size() * 3 . " Stars</div>
	</div>
	
	<div class='CWHrow'>
		<div id='ClanAtkCount'>" . Nz($currentWar->koh_attacks(), 0) . " / " . $currentWar->team_size() * 2 . "</div>
		<div class='CWHRmiddle' id='CWstate'>" . $currentWar->state() . "</div>
		<div id='OpponentAtkCount'>" . Nz($currentWar->opponent_attacks(), 0) . " / " . $currentWar->team_size() * 2 . "</div>
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
	$Member = $AManager->MemberAtPosition($Fighters, $x, $WarSize);
	echo "
	<div class='CWTRow'>
		<div class='member'>
			<div class='position'>$x</div>
			<div class='TH-Destruction'><img class='TH' src='images/profile/TownHall/TownHall_" . $Member->Player_TH() . ".png' /></div>
			<div class='playerName'><p>" . $Member->Player_Name() . "</p><a href=\"index.php?op=playerprofile&PlayerTag=" . substr($Member->Player_ID(), 1) . "\"><img src='images/burger.png'/></a></div>
			<div class='RequestedTargets'><input type='text' name='$x-1' /><input type='text' name='$x-2' /></div>
			<div class='Attack'>"; 
	$target = $Member->Attack_1_Rank();
	if ($target!=0) {
		echo $target;
	} else {
		echo "Pas encore";
	}
	echo "</div>
			<div class='Attack'>";
	$target = $Member->Attack_2_Rank();
	if ($target!=0) {
		echo $target;
	} else {
		echo "Pas encore";
	}
	echo "</div>
		</div>";
	
	$Opponent = $AManager->OpponentAtPosition($Fighters, $x, $WarSize);
	echo "
		<div class='opponent'>
			<div class='position'>$x</div>
			<div class='TH-Destruction'><img class='TH' src='images/profile/TownHall/TownHall_" . $Opponent->Player_TH() . ".png' />" . $Opponent->EBA_Star() . "</div>
		</div>
	</div>";
}
echo "
</div>
";




?>