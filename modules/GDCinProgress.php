<?php
// GDCinProgress.php
// GDC table for strategy dev and adjustments.

// db connect
try {
	$db = new PDO($dsn, $user, $password);
} catch(PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
}

// get last GDC size from db
$sql = "SELECT `Participants` FROM `coc_cw-participants` Limit 1;";
$qry = $db->query($sql);

while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {
	$Participants = $row['Participants'];
}

// select the number of participants
echo "
<form method='get' action='index.php'>
	<input type='hidden' name='op' value='GDCinProgress'>
	<p>Nombre de participants
	<select name='Participants'>
		";
	for ($x=10;$x<=50;$x+=5) {
		echo "<option value='$x'";
		if (isset($_GET['Participants'])) {
			if ($_GET['Participants'] == $x) {
				echo " selected";
				// store new participants number.
				$sql = "UPDATE `coc_cw-participants` SET `Participants`=$x WHERE 1;";
				$qry = $db->prepare($sql);
				$qry->execute();
				// set Participants var 
				$Participants = $x;
			}
		}else {
			if ($Participants == $x) {
				echo " selected";
			}
		}
		echo ">$x</option>
		";
	}
echo "
	</select>	
	<input type='submit' value='OK' />	
	</p>
</form>
</section>
";

// update player list 



// diplay the sheet
echo "
<section>
<iframe src='https://docs.google.com/spreadsheets/d/1bzvtmHDoYUx4qdTkuZTG2ZCW6LjnZ0jyS_VuByCRMiQ/edit?usp=sharing' width='700' height='1200' frameborder='0'></iframe>";




?>