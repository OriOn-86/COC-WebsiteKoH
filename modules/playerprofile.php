<?php
// select player form
echo "
	<form method='post' action='index.php?op=playerprofile'>
	<select name='PlayerTag'>
		<option value='0'> --- Select a Player --- </option>
";
$sth = $db->prepare('SELECT `player_tag`, `name` FROM `coc_dailyData` WHERE `date`=(SELECT `date` FROM `coc_dailyData` ORDER BY `date` DESC LIMIT 1)');
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
		$sth = $db->prepare('SELECT `date`, `trophies` FROM `coc_dailyData` WHERE `player_tag`=:tag ORDER BY `date` DESC LIMIT 0, 50');
		$sth->execute(array(':tag' => $PlayerTag));
		while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
			$date = $row['date'];
			$trophies = $row['trophies'];
			$timestamp = (strtotime($date)+60*60) * 1000;
			$data1[] = "[$timestamp, $trophies]";
		}
		// General stats from API data
		$sth = $db->prepare('SELECT * FROM `coc_dailyData` WHERE `player_tag`=:tag AND `date`=(SELECT `date` FROM `coc_dailyData` ORDER BY `date` DESC LIMIT 1)');
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
		$sth = $db->prepare('SELECT `trophies` FROM `coc_dailyData` WHERE `date`>= :BeginSeason AND `player_tag`= :tag');
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
		/* // War part I
		$sth = $db->prepare('SELECT `Player_coc_ID`, `War_Count`, `Last_War_Date` FROM `coc_members` WHERE `Player_Name`= :name');
		$sth->execute(array(':name' => $PlayerName));
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
			$LastWar = $row['Last_War_Date'];
			$NbWars = $row['War_Count'];
			$COCID = $row['Player_coc_ID'];
		}
		// War part II
		$sth = $db->prepare('SELECT * FROM `coc_match_detail` WHERE `Player_ID` = :cocID');
		$sth->execute(array(':cocID' => $COCID));
		$AVGDest = 0;
		$AVGStar = 0;
		$NBMissedAtk = 0;
		$DeltaAtk = array();
		
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
			if ($row['Attack_1_Rank'] <> 0) {
				
			} else { $NBMissedAtk += 1; }
		} */
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
	$sql = "SELECT * FROM `coc_itemMaxLevel`";
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
	<table width='910px'>
	<!-- General stats -->
	<tr>
		<td colspan='3'><img src='images/general.jpg'/></td>
	</tr>
	<tr>
		<td>XP Level: $ExpLevel</td>
		<td rowspan='8' colspan='2' id='GraphTrophy' width='70%'></td>
	</tr>
	<tr>
		<td>Position in the clan: $clanRank</td>
	</tr>
	<tr>
		<td><h3>Troops</h3></td>
	</tr>
	<tr>
		<td>Donated: $Donated</td>
	</tr>
	<tr>
		<td>Received: $Received</td>
	</tr>
	<tr>
		<td><h3>Trophy range</h3></td>
	</tr>
	<tr>
		<td>Upper limit: $TULimit</td>
	</tr>
	<tr>
		<td>Lower limit: $TLLimit</td>
	</tr>
	<tr>
	</table>
	</section>
	<section>
	<table width='910px'>
	<tr>
		<th>Date</th>
		<th>Level</th>
		<th>League</th>
		<th>Rank</th>
		<th>donations</th>
		<th>Received</th>
	</tr>";
	// last 50 daily records
	$sth = $db->prepare('SELECT `date`, `expLevel`, `league`, `clanRank`, `donations`, `donationsReceived`  FROM `coc_dailyData` WHERE name= :name ORDER BY `date` DESC LIMIT 0, 50');
	$sth->execute(array(':name' => $PlayerName));
	while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
		echo "
				<tr>
					<td>" . $row['date'] . "</td>
					<td>" . $row['expLevel'] . "</td>
					<td>" . $row['league'] . "</td>
					<td>" . $row['clanRank'] . "</td>
					<td>" . $row['donations'] . "</td>
					<td>" . $row['donationsReceived'] . "</td>
				</tr>";
	}
	
	
	echo "</td>
	</tr>
	</table>
	</section>
	";
	
	// WAR STATS
/* 	echo "<section>
	<table width='910px'>
	<!-- War stats -->
	<tr>
		<td colspan='3'><img src='images/war.jpg'/></td>
	</tr>
	<tr>
		<td>Last war record: $LastWar</td>
		<td rowspan='5' id='GraphWar1'></td>
		<td rowspan='5' id='GraphWar2'></td>
	</tr>
	<tr>
		<td>Number of war recorded: $NbWars</td>
	</tr>
	<tr>
		<td>Average Destruction / Attack: $AVGDest</td>
	</tr>
	<tr>
		<td>Average Star / Attack: $AVGStar</td>
	</tr>
	<tr>
		<td>Number of attack not played: $NBMissedAtk</td>
	</tr>
	<!-- Footer -->
	
</table> */
echo "
<script>
var chart1 = new Highcharts.Chart({
	title: {text: ''},
	chart: {renderTo: 'GraphTrophy'},
	xAxis: {type: 'datetime', tickInterval: 24 * 36e5},
	yAxis: {title: {text: 'Trophies'}},
	legend: {enabled: false},
	series: [{name: 'Trophies', data: [", join($data1, ',') ,"]}]
	});
</script>";
}
?>