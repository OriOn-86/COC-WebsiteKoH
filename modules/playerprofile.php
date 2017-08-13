<?php
// functions
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

// select player form
echo "
	<form method='post' action='index.php?op=playerprofile'>
	<select name='PlayerTag'>
		<option value='0'> --- Select a Player --- </option>
";
$sth = $db->prepare('SELECT `player_tag`, `name` FROM `coc_dailydata` WHERE `date`=(SELECT `date` FROM `coc_dailydata` ORDER BY `date` DESC LIMIT 1)');
$sth->execute();
while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
	$tag = $row['player_tag'];
	$name = $row['name'];
	echo "		<option value=\"$tag\">$name</option>
";
}
echo "
</select>
<input type='submit' value='OK' />
</form>
</section>
";
// player data 
if (isset($_POST['PlayerTag']) or isset($_GET['PlayerTag'])) {
	if (isset($_POST['PlayerTag'])) {
		$PlayerTag = $_POST['PlayerTag'];
	} else { 
		$PlayerTag = $_GET['PlayerTag'];
	}
	try {
		// trophies data for chart
		$sth = $db->prepare('SELECT `date`, `trophies` FROM `coc_dailydata` WHERE `player_tag`=:tag ORDER BY `date` DESC LIMIT 0, 50');
		$sth->execute(array(':tag' => $PlayerTag));
		while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
			$date = $row['date'];
			$trophies = $row['trophies'];
			$timestamp = (strtotime($date)+60*60) * 1000;
			$data1[] = "[$timestamp, $trophies]";
		}
		// General stats from API data
		$sth = $db->prepare('SELECT * FROM `coc_dailydata` WHERE `player_tag`=:tag AND `date`=(SELECT `date` FROM `coc_dailydata` ORDER BY `date` DESC LIMIT 1)');
		$sth->execute(array(':tag' => $PlayerTag));
		while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
			$PlayerName = $row['name'];
			$Donated = $row['donations'];
			$Received = $row['donationsReceived'];
			$ExpLevel = $row['expLevel'];
			$clanRank = $row['clanRank'];
		}
		// $SeasonStart
		$qry = $db->query('SELECT `season_start` FROM `coc_seasons` ORDER BY `season_start` DESC LIMIT 1');
		$qry->execute();
		while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {
			$SeasonStart = $row['season_start'];
		}
		// Min / Max of the season
		$sth = $db->prepare('SELECT `trophies` FROM `coc_dailydata` WHERE `date`>= :BeginSeason AND `player_tag`= :tag');
		$sth->execute(array(':BeginSeason' => $SeasonStart, ':tag' => $PlayerTag));
		$TULimit = 0;
		$TLLimit = 0;
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
			if ($TULimit == 0) {
				$TULimit = $row['trophies'];
				$TLLimit = $row['trophies'];
			} else {
				if ($row['trophies'] > $TULimit) { $TULimit = $row['trophies']; }
				if ($row['trophies'] < $TLLimit) { $TLLimit = $row['trophies']; }
			}
		}
		
		// Wars
		include("include/class_Attacks.php");
		include("include/class_War.php");
		$AttackManager = new AttackManager($db);
		$WarManager = new WarManager($db);
		
		// last war from player
		$LastWarID = $AttackManager->getLastWarOfPlayer("#" . $PlayerTag);
		$LastWar = ($LastWarID != -1) ? $WarManager->getWarFromID($LastWarID)->datewar() : "0000-00-00";
		
		// wars statistics
		$LastWars = [];
		$PlayerWars = [];
		$DateLatestWar = (new DateTime())->sub(new DateInterval('P30D'));
		$Specifics = ["filter"=>"datewar > '" . $DateLatestWar->format("Y-m-d") . "'", "orderBy"=> "datewar DESC"];
		$LastWars = $WarManager->getWarsBySpecific($Specifics);
		
		foreach ($LastWars as $War) {
			$Attacks = $AttackManager->getPlayerAttacksDuringWar("#" . $PlayerTag, $War->id());
			if ($Attacks !== NULL) {
				$PlayerWars[] = $Attacks;
			}
		}
		
		$NbWars = count($PlayerWars);
		$AVGDest = 0.0;
		$AVGStar = 0.0;
		$NBMissedAtk = 0;
		
		if ($NbWars > 0) {
			$Deltas = [];
			$Stars = [];
			$data2 = [];
			$x = 0;
			foreach ($PlayerWars as $PlayerWar) {
				if ($PlayerWar->Attack_1_Rank() > 0) {
					$AVGDest += $PlayerWar->Attack_1_Percentage();
					$AVGStar += $PlayerWar->Attack_1_Star();
					// graph data
					$Deltas[$x] = $PlayerWar->MapRank() - $PlayerWar->Attack_1_Rank();
					$Stars[$x] = intval($PlayerWar->Attack_1_Star());
					$data2[$x] = array($Deltas[$x], $Stars[$x]);
					$x++;
				} else {
					$NBMissedAtk += 1;
				}
				if ($PlayerWar->Attack_2_Rank() > 0) {
					$AVGDest += $PlayerWar->Attack_2_Percentage();
					$AVGStar += $PlayerWar->Attack_2_Star();
					// graph data
					$Deltas[$x] = $PlayerWar->MapRank() - $PlayerWar->Attack_2_Rank();
					$Stars[$x] = intval($PlayerWar->Attack_2_Star());
					$data2[$x] = array($Deltas[$x], $Stars[$x]);
					$x++;
				} else {
					$NBMissedAtk += 1;
				}
			}
			$AVGDest /= ($NbWars * 2 - $NBMissedAtk);
			$AVGStar /= ($NbWars * 2 - $NBMissedAtk);
		
			// graph: stars / delta pos
			array_multisort($Deltas, SORT_ASC, $Stars, SORT_DESC, $data2);
			$GraphDeltas = [];
			$GraphStars = [];
			$xMax = count($data2);
			
			$y = 1;
			$GraphDeltas[0] = $data2[0][0];
			$GraphStars[0] = $data2[0][1];
			for ($x=1; $x<$xMax; $x++) {
				if ($data2[$x][0] === end($GraphDeltas)) {
					$pos = count($GraphDeltas) - 1;
					$GraphStars[$pos] = ($GraphStars[$pos] * $y + $data2[$x][1]) / ($y + 1);
					$y++;
				} else {
					$y = 1;
					while ((end($GraphDeltas) + 1) < $data2[$x][0]) {
						$GraphDeltas[] = end($GraphDeltas) + 1;
						$GraphStars[] = -1;
					}
					$GraphDeltas[] = $data2[$x][0];
					$GraphStars[] = $data2[$x][1];
				}
			}
			
			$data2 = [];
			for ($x=0; $x < count($GraphDeltas); $x++)  {
				$data2[] = "[" . $GraphDeltas[$x] . ", " . $GraphStars[$x] ."]";
			}
		}
		
	} catch(PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}

	// PLAYER PROFILE
	include ("include/class_Member.php");
	$ProfileManager = new MemberManager($db);
	$Profile = $ProfileManager->get($PlayerTag);
	$Troops = ["Barbarian", "Archer", "Goblin", "Giant", "Wall_Breaker", "Balloon", "Wizard", "Healer", "Dragon", "PEKKA", "Baby_Dragon", "Miner", "Minion", "Hog_Rider", "Valkyrie", "Golem", "Witch", "Lava_Hound", "Bowler"];
	$Heroes = ["Barbarian_King", "Archer_Queen", "Grand_Warden"];
	$Spells = ["Lightning_Spell", "Healing_Spell", "Rage_Spell", "Jump_Spell", "Freeze_Spell", "Clone_Spell", "Poison_Spell", "Earthquake_Spell", "Haste_Spell", "Skeleton_Spell"];
	$max_level = [];
	$sql = "SELECT * FROM `coc_itemmaxlevel`";
	$qry = $db->query($sql);
	while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {
		$max_level[$row['name']] = $row['maximum_level'];
	}
	// PLAYER NAME
	echo "<section>
		<div id='level'>$ExpLevel</div>
		<div id='playername'>$PlayerName</div>
		<div id='HDV'><img src='images/profile/TownHall/TownHall_" . $Profile->townHallLevel() . ".png' /></div>
	</section>
	<section>
	<div id='items'>
		";
	foreach ($Troops as $Troop) {
		if ($Profile->$Troop() == 0) {
			echo "<div class='Troop'><img src='images/profile/Troops/grayscale/$Troop.jpg' /></div>
		";
		} elseif ($Profile->$Troop() == $max_level[$Troop]) {
			echo "<div class='Troop' data-item='max'><img src='images/profile/Troops/$Troop.jpg' /><p>" . $Profile->$Troop() . "</p></div>
		";
		} else {
			echo "<div class='Troop' data-item='normal'><img src='images/profile/Troops/$Troop.jpg' /><p>" . $Profile->$Troop() . "</p></div>
		";
		}
	}
	echo "</div>
	</section>
	<section>
	<div id='items'>
		";
	foreach ($Spells as $Spell) {
		if ($Profile->$Spell() == 0) {
			echo "<div class='Spell'><img src='images/profile/Spells/grayscale/$Spell.jpg' /></div>
		";
		} elseif ($Profile->$Spell() == $max_level[$Spell]) {
			echo "<div class='Spell' data-item='max'><img src='images/profile/Spells/$Spell.jpg' /><p>" . $Profile->$Spell() . "</p></div>
		";
		} else {
			echo "<div class='Spell' data-item='normal'><img src='images/profile/Spells/$Spell.jpg' /><p>" . $Profile->$Spell() . "</p></div>
		";
		}
	}
	echo "</div>
	</section>
	<section>
	<div id='items'>
		";
	foreach ($Heroes as $Heroe) {
		if ($Profile->$Heroe() == 0) {
			echo "<div class='Heroe'><img src='images/profile/Heroes/grayscale/$Heroe.jpg' /></div>
		";
		} elseif ($Profile->$Heroe() == $max_level[$Heroe]) {
			echo "<div class='Heroe' data-item='max'><img src='images/profile/Heroes/$Heroe.jpg' /><p>" . $Profile->$Heroe() . "</p></div>
		";
		} else {
			echo "<div class='Heroe' data-item='normal'><img src='images/profile/Heroes/$Heroe.jpg' /><p>" . $Profile->$Heroe() . "</p></div>
		";
		}
	}
	echo "</div>
	</section>
	<section>
	<div id='lastupdate'><i>Dernière mise à jour du profil le " . $Profile->daterecord() . "</i></div>
	</section>
	";
	// GENERAL STATS
	echo "<section>
	<div class='General'>
		<div class='banner'><img src='images/general.jpg'/></div>
		<div class='FullHighChartsGraph' id='GraphTrophy'></div>
	</div>
	<script>
		var chart1 = new Highcharts.Chart({
			title: {text: ''},
			chart: {backgroundColor: '', renderTo: 'GraphTrophy'},
			xAxis: {type: 'datetime', tickInterval: 24 * 36e5},
			yAxis: {title: {text: 'Trophies'}},
			legend: {enabled: false},
			series: [{name: 'Trophies', data: [", join($data1, ',') ,"]}]
		});
	</script>
	</section>
	<section>
		<div id='Daily'>";
	require 'include/class_daily.php';
	$dailyItemManager = new DailyManager($db);
	// collect up to the 50 latest records from the current member
	$dailyItems = $dailyItemManager->getPlayerData($PlayerTag, 50);
	
	foreach ($dailyItems as $row) {
		echo "
		<div class='memberList'>
			<div class='daterecord'>" . $row->date() . "</div>
			<div class='league'><img src='images/leagues/" . str_replace(' ', '_', $row->league()) . "-S.png' /></div>
			<div class='level'>" . $row->expLevel() . "</div>
			<div class='PlayerName'><p>" . $row->name() . "</p></div>
			<div class='position'>" . $row->clanRank() . "</div>
			<div class='trophies'><p>" . $row->trophies() . "</p><img src='images/trophies.png' /></div>
			<div class='trophies'><p>" . $row->versusTrophies(). "</p><img src='images/versusTrophies.png' /></div>
			<div class='troops'>" . $row->donations() . "</div>
			<div class='troops'>" . $row->donationsReceived() . "</div>
			<div class='ratio' data-ratio='";
		if ($row->donationsReceived() == 0) {
			$ratio = 0; 
		} else {
			$ratio = $row->donations() / $row->donationsReceived();
		}
		if ($ratio < 0.5) { echo "bad"; } else { echo "good"; }
		echo "'>" . number_format($ratio, 2, '.', ',') . "</div>
		</div>";
	}
	echo "
		</div>
	</section>";
	
	// WAR STATS
	echo "<section>
	<div class='War'>
		<div class='banner'><img src='images/war.jpg'/></div>
		<div class='WarInfo'>Date de la dernière guerre: $LastWar</div>
		<div class='WarInfo'>Nb de guerres ces 30 derniers jours: $NbWars / " . count($LastWars) . "</div>
		<div class='WarInfo'>Moyenne de destruction par attaque: " . number_format($AVGDest, 2) . "</div>
		<div class='WarInfo'>Moyenne d'étoiles par attaque: " . number_format($AVGStar, 2) . "</div>
		<div class='WarInfo'>Nb d'attaques non jouées: $NBMissedAtk</div>
	</div>
	</section>
	<section>
		<div class='HalfHighChartsGraph' id='GraphWar1'></div>
	</section>
	<section>
	<div class='warHistory'>";

	foreach ($PlayerWars as $PlayerWar) {
		$WarResult = $WarManager->LookupthroughWars("result", $PlayerWar->warid(), $LastWars);
		echo "
	<a class='war' href='index.php?op=EndedClanWar&warid=" . $PlayerWar->warid() . "' data-item='$WarResult'>
		<div class='warid'>" . $PlayerWar->warid() . "</div>
		<div class='position'>" . $PlayerWar->MapRank() . "</div>
		<div class='TH-Destruction'><img class='TH' src='images/profile/TownHall/TownHall_" . $PlayerWar->Player_TH() . ".png' /></div>
		<div class='vertical-separator'></div>
		<div class='EBA'>" . AtkResult($PlayerWar->EBA_Star(), $PlayerWar->EBA_Destruction()) . "</div>
		<div class='EBA'> par le (" . $PlayerWar->EBA_AttackerRank() . ")</div>
		<div class='vertical-separator'></div>
		<div class='defense'>Nombre de fois attaqué : " . $PlayerWar->Attacked() . "</div>
		<div class='vertical-separator'></div>
		<div class='attacks'>attaques durant la guerre : </div>";
		if ($PlayerWar->Attack_1_Rank() > 0) {
			echo "
		<div class='Attack'><div class='target'><img src='images/target.png' /><p>". $PlayerWar->Attack_1_Rank() ."</p></div>" . AtkResult($PlayerWar->Attack_1_Star(), $PlayerWar->Attack_1_Percentage()) . "</div>";
		} else {
			echo "
		<div class='NotUsed'>Non jouée</div>";
		}
		if ($PlayerWar->Attack_2_Rank() > 0) {
			echo "
		<div class='Attack'><div class='target'><img src='images/target.png' /><p>". $PlayerWar->Attack_2_Rank() . "</p></div>" . AtkResult($PlayerWar->Attack_2_Star(), $PlayerWar->Attack_2_Percentage()) . "</div>";
		} else {
			echo "
		<div class='NotUsed'>Non jouée</div>";
		}
		echo "
	</a>";
	}
	
	echo "
	</div>";

	if ($NbWars> 0) {
		echo "
	<script>
		var chart2 = new Highcharts.Chart({
			title: {text: ''},
			chart: {type: 'column', backgroundColor: '', renderTo: 'GraphWar1'},
			xAxis: {title: {text: 'cible (par rapport à position)'}},
			yAxis: {title: {text: 'Moyenne d\'étoiles'}, min: -1, max: 3},
			legend: {enabled: false},
			series: [{name: 'Stars', data: [", join($data2, ',') ,"]}]
		});
	</script>";
	}
}
?>
