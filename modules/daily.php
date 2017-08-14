<?php

require 'include/class_daily.php';

$DailyManager = new DailyManager($db);

// date from navigation or last input
if (isset($_GET['day'])) {
	$daterecord = $_GET['day'];
} else {
	$daterecord = $DailyManager->getLastDailyRecordDate();
}
// eve
$date = new DateTime(strftime($daterecord));
$date->sub(new DateInterval('P1D'));
$eve = $date->format('Y-m-d');
// Load data 
$Knights = $DailyManager->getDailyFromDate($daterecord);

// Create table
echo "
<h2>Rapport journalier du " . $daterecord . "</h2>
</section>
<section>
<div id='daily'>";
// display data
foreach($Knights as $row) {
	echo "
	<div class='memberList'>
		<div class='position'>" . $row->clanRank() . "</div>
		<div class='evolution' "; 
		// implement data-position='up|down|equal|new'
		$previousPosition = $DailyManager->getPlayerPosition($eve, $row->player_tag());
		if ($previousPosition) {
			if ((int)$previousPosition < $row->clanRank()) {
				echo "data-position='down'";
			} elseif ((int)$previousPosition == $row->clanRank()) {
				echo "data-position='equal'";
			} else {
				echo "data-position='up'";
			}
		} else {
			echo "data-position='new'";
		}
		echo "></div>
		<div class='league'><img src='images/leagues/" . str_replace(' ', '_', $row->league()) . "-S.png' /></div>
		<div class='level'>" . $row->expLevel(). "</div>
		<div class='playerName'><p>" . $row->name() . "</p><a href=\"index.php?op=playerprofile&PlayerTag=" . $row->player_tag() . "\"><img src='images/burger.png' /></a></div>
		<div class='trophies'><p>" . $row->Trophies() . "</p><img src='images/trophies.png' /></div>
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
</div>";
?>