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

// PHP functions 
function Nz($variable, $default) {
	return isset($variable)?$variable:$default;
}
function Stars($Number) {
	$Stars = "";
	for ($Star = 1; $Star <= 3; $Star++) {
		if ($Star <= $Number) {
			$Stars .= "<img class='star' src='images/starON.png' />";
		} else {
			$Stars .= "<img class='star' src='images/starOFF.png' />";
		}
	}
	return $Stars;
}
function StoredValueFrom($control) {
	global $db;
	$sql = "SELECT `target` FROM `coc_currentwar_strat` WHERE `id` = '$control';";
	$qry = $db->prepare($sql);
	$qry->execute();
	
	return $qry->fetch(PDO::FETCH_ASSOC)['target'];
}
// JavaScript functions
echo "
<script>
	function SaveStrat(Attack, Target) {
		
			Attack = encodeURIComponent(Attack);
			Target = encodeURIComponent(Target);
			var request = new XMLHttpRequest();
			request.open( 'GET' , 'modules/CWStrater.php?Attack=' + Attack + '&Target=' + Target, true);
			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					if (typeof (request.reponseText) !== 'undefined') {
						alert (request.responseText);
					}
				} else if (request.readyState == 4 && request.status == 500) {
					alert ('server error');
				}
				else if (request.readyState == 4 && request.status != 200 && request.status != 500 ) { 
					alert ('Something went wrong!');
				}
			}
			request.send(null);
		
		return 0;
	}
</script>";


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
			<div class='RequestedTargets'>
				<input type='text' name='$x-1' onChange='SaveStrat(this.name, this.value)' value='" . StoredValueFrom("$x-1") . "' maxlength='20'/>
				<input type='text' name='$x-2' onChange='SaveStrat(this.name, this.value)' value='" . StoredValueFrom("$x-2") . "' maxlength='20'/>
			</div>
			<div class='Attack'>"; 
	if ($Member->Attack_1_Rank()!=0) {
		echo "
				<div class='target'><img src='images/target.png' /><p>". $Member->Attack_1_Rank() ."</p></div>
				<div class='stars'>" . Stars($Member->Attack_1_Star()) ."</div>
				<div class='percent'><p>" . $Member->Attack_1_Percentage() . " %</p></div>";
	} else {
		echo "Pas encore";
	}
	echo "</div>
			<div class='Attack'>";
	if ($Member->Attack_2_Rank()!=0) {
		echo "
				<div class='target'><img src='images/target.png' /><p>". $Member->Attack_2_Rank() ."</p></div>
				<div class='stars'>" . Stars($Member->Attack_2_Star()) ."</div>
				<div class='percent'><p>" . $Member->Attack_2_Percentage() . " %</p></div>";
	} else {
		echo "
				<div class='NotUsed'>Pas encore</div>";
	}
	echo "</div>
		</div>";
	
	$Opponent = $AManager->OpponentAtPosition($Fighters, $x, $WarSize);
	echo "
		<div class='opponent'>
			<div class='position'>$x</div>
			<div class='TH-Destruction'><img class='TH' src='images/profile/TownHall/TownHall_" . $Opponent->Player_TH() . ".png' />" . Stars($Opponent->EBA_Star()) . "</div>
		</div>
	</div>";
}
echo "
</div>
";




?>