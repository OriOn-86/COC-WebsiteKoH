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
		<h1>Knights of Hell</h1>
	</header>
	<nav><!-- Menu -->
		<ul>
<?php 
	// include db.conf and open $db
	include("include/db.conf.php");
	try {
		$db = new PDO($dsn, $user, $password);
	} catch(PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}
	
	$List = scandir("modules");
	foreach($List as $key => $value) {
		$test = strpos($value, ".php");
		if (($test > 0) and $value!="index.php") {
			$MenuItem = substr($value, 0, -4);
			echo " 
			<li><a href='index.php?op=$MenuItem'>" . strtoupper($MenuItem) . "</a></li>";
		}
	}
?>			
		</ul>
	</nav>
	<section>
		<?php
		// op list
		$ops = ['daily', 'logs' ,'playerprofile', 'weekly'];

		if (isset($_GET['op'])) {
			if (in_array($_GET['op'], $ops)) {
				include("modules/" . $_GET['op'] . ".php");
			}
		} else {
			include("modules/logs.php");
		}
		?>
	</section>
	<footer>
	</footer>
</body>
</html>
