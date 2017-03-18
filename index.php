<!DOCTYPE html>
<html>
<head>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type"></meta>
	<meta content="utf-8" http-equiv="encoding"></meta>
	<link rel="stylesheet" href="include/style.css"></link>
	<title>Clash of Clans</title>
	<script src="js/highcharts.js"></script>
</head>
<body>
	<header>
	<nav><!-- Menu -->
		<h1>Clash of Clans</h1>
		<ul>
			<li><a href="http://knightsofhell.free.fr">Accueil</a></li>
			<li><a href="http://knightsofhell.free.fr/index.php?file=Forum">Forum</a></li>
			<li><a href="http://knightsofhell.free.fr/index.php?file=Wars">Guerres</a></li>
			<li>
				<div class="dropdown"><a href="#">Clasher</a>
				<div class="dropdown-content">

<?php
	// include db.conf and open $db
	include("include/db.conf.php");
	try {
		$db = new PDO($dsn, $user, $password);
	} catch(PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}
	// op list
	$ops = ['clan', 'daily', 'logs' ,'playerprofile', 'weekly'];
	$List = scandir("modules");
	foreach($List as $key => $value) {
		$test = strpos($value, ".php");
		if (($test > 0) and $value!="index.php") {
			$MenuItem = substr($value, 0, -4);
			if (in_array($MenuItem, $ops)) {
				echo " 
				<a href='index.php?op=$MenuItem'>" . str_replace("_", " ", strtoupper($MenuItem)) . "</a>";
			}
		}
	}
?>
				</div>
				</div></li>
			<li><a href="http://knightsofhell.free.fr/index.php?file=Team">L'équipe</a></li>
		</ul>
	</nav>
	</header>
	<article>
	<section>
		<?php
		if (isset($_GET['op'])) {
			if (in_array($_GET['op'], $ops)) {
				include("modules/" . $_GET['op'] . ".php");
			}
		} else {
			include("modules/clan.php");
		}
		?>
	</section>
	</article>
	<div class="footer_article"></div>
	<footer>
		<div class="content">
			<div class="footerBlock">
				<h1>RAPPORTS JOURNALIERS</h1>
				<?php 
					$sql = "SELECT `date` FROM `coc_dailyData` GROUP BY `date` ORDER BY `date` DESC LIMIT 3;";
					$qry = $db->query($sql);
					while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {
						echo "
				<div class='breaker'></div>
				<h2>Rapport du " . date("d-m-Y", strtotime($row['date'])) . "</h2>
				<a href='?op=daily&day=" . $row['date'] . "'>Voir le rapport</a>";
					}
				?>
			</div>
			<div class="footerBlock">
				<h1>RAPPORTS HEBDOMADAIRES</h1>
				<?php 
					$sql = "SELECT `date` FROM `coc_weeklyAnalysis` GROUP BY `date` ORDER BY `date` DESC LIMIT 3;";
					$qry = $db->query($sql);
					while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {
						echo "
				<div class='breaker'></div>
				<h2>Rapport de la semaine " . date("W", strtotime($row['date'])) . "</h2>
				<a href='?op=weekly&day=" . $row['date'] . "'>Voir le rapport</a>";
					}
				?>
			</div>
			<div class="footerBlock">
				<h1>RAPPORTS DE GUERRES</h1>
				<?php 
					$sql = "SELECT * FROM `coc_wars` ORDER BY `datewar` DESC LIMIT 3;";
					$qry = $db->query($sql);
					while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {
						echo "
				<div class='breaker'></div>
				<h2>" . $row['opponent_name'] . "<span> le " . date("d-m-Y", strtotime($row['datewar'])) . "</span></h2>
				<a href='?op=daily&day=" . $row['datewar'] . "'>Voir le rapport</a>";
					}
				?>
			</div>
		</div>
	</footer>
</body>
</html>
