<?php
// CWStrater.php
// record strategy input into database
if (isset($_GET["Attack"]) && (isset($_GET["Target"]))) {

	require("../include/conf.db.php");
	$Attack = $_GET["Attack"];
	$Target = $_GET["Target"];
	
	
	if ((strlen($Attack)>4) || (strlen($Target)>20)) {
		echo "no more than 20 characters.";
		exit();
	}
	
	// db connect
	try {
		$db = new PDO($dsn, $user, $password);
	} catch(PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}
	
	$sql = "UPDATE `coc_currentwar_strat` SET `target`='$Target' WHERE `id`='$Attack';";
	$qry = $db->prepare($sql);
	$qry->execute();
	
}

?>