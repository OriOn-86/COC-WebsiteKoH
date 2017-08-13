<?php
function Nz ($variable, $default) {
	return isset($variable) ? $variable : $default;
}

include ("include/class_War.php");

$WarManager = new WarManager($db);
$Wars = $WarManager->getWarsBySpecific(array("orderBy"=>"id DESC", "limit"=>"10"));

echo "
<div id='Wars'>";

foreach($Wars as $War) {
	echo "
	<a class='WarItem' href='index.php?op=EndedClanWar&warid=" . $War->id() . "' data-item='" . $War->result() . "'>
		<div class='Team Home'>
			<div class='Name'>Knights of Hell</div>
			<div class='Score'>
				<div class='Exp'><p>+" . $War->exp_earned() . "</p></div>
				<div class='Destruction'><p>" . number_format($War->koh_destructionPercentage(), 2) . "%</p></div>
				<div class='TotalStars'><img src='images/starON.png' /><p>" . $War->koh_stars() . "</p></div>
			</div>
		</div>
		<div class='badges'>
			<div class='ClanBadge'><img src='https://api-assets.clashofclans.com/badges/200/" . $War->koh_badgeUrl() . "'/><p>" . $War->koh_clanLevel() . "</p></div>
			<div class='versus'><p>" . $War->team_size() . " contre " . $War->team_size() . "</p></div>
			<div class='ClanBadge'><img src='https://api-assets.clashofclans.com/badges/200/" . $War->opponent_badgeUrl() . "'/><p>" . $War->opponent_clanLevel() . "</p></div>
		</div>
		<div class='Team Visitor'>
			<div class='Name'>" . $War->opponent_name() . "</div>
			<div class='Score'>
				<div class='TotalStars'><img src='images/starON.png' /><p>" . $War->opponent_stars() . "</p></div>
				<div class='Destruction'><p>" . number_format($War->opponent_destructionPercentage(), 2) . "%</p></div>
			</div>
		</div>
	</a>";
}

echo "
</div>";
?>
