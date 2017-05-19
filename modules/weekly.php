<?php
// obj. declarations
class Weekly {
	// Characteristics
	private $_Name;
	private $_Infraction;
	private $_D_Initial;
	private $_D_Final;
	private $_R_Initial;
	private $_R_Final;
	// Getters
	public function Name() {return $this->_Name;}
	public function Infraction() {return $this->_Infraction;}
	public function D_Initial() {return $this->_D_Initial;}
	public function D_Final() {return $this->_D_Final;}
	public function R_Initial() {return $this->_R_Initial;}
	public function R_Final() {return $this->_R_Final;}
	//Setters
	public function setName($String) {
		if (is_string($String)) {
			$this->_Name = $String;
		}
	}
	public function setInfraction($Number) {
		if (is_numeric($Number)){
			$this->_Infraction = $Number;
		}
	}
	public function setD_initial($Number) {
		if (is_numeric($Number)){
			$this->_D_Initial = $Number;
		}
	}
	public function setD_final($Number) {
		if (is_numeric($Number)){
			$this->_D_Final = $Number;
		}
	}
	public function setR_initial($Number) {
		if (is_numeric($Number)){
			$this->_R_Initial = $Number;
		}
	}
	public function setR_final($Number) {
		if (is_numeric($Number)){
			$this->_R_Final = $Number;
		}
	}
	// Hydrate
	public function hydrate(array $data) {
		foreach ($data as $key => $value) {
			$method = 'set'.ucfirst($key);
			if (method_exists($this, $method)) {
					$this->$method($value);
			}
		}
	   unset($value);
	}
	// CONSTRUCT
	public function __construct (array $data) {
		$this->hydrate($data);
	}
}

// db connect
try {
        $db = new PDO($dsn, $user, $password);
} catch(PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
}

// date from navigation or last input
if (isset($_GET['day'])) {
	$daterecord = $_GET['day'];
} else {
	$sql = "SELECT `date` FROM `coc_weeklyanalysis` ORDER BY `id` DESC LIMIT 0,1";
	$qry = $db->query($sql)->fetch(PDO::FETCH_ASSOC);
	$daterecord = $qry['date'];
}

// Load data
$sql = "SELECT `name`, `infraction`, `D_Initial`, `D_Final`, `R_Initial`, `R_Final` FROM `coc_weeklyanalysis` WHERE `date`=\"" . $daterecord . "\" ORDER BY `name` LIMIT 0, 50";
$qry = $db->query($sql);
while ($data = $qry->fetch(PDO::FETCH_ASSOC)) {
	$Knights[] = new Weekly($data);
}

// Create table
echo "
<h2>Rapport de la Semaine " . date("W", strtotime($daterecord)) . "</h2>
</section>
<section>
<table id='weekly'>
	<tr>
		<th rowspan='2'>Joueur</th>
		<th rowspan='2'>Infraction</th>
		<th colspan='2'>Pendant la semaine</th>
		<th colspan='2'>Compteur en debut de semaine</th>
		<th colspan='2'>Compteus en fin de semaine</th>
	</tr>
	<tr>
		<th width='105px'>Données</th>
		<th width='105px'>Reçues</th>
		<th width='105px'>Données</th>
		<th width='105px'>Reçues</th>
		<th width='105px'>Données</th>
		<th width='105px'>Reçues</th>
	</tr>";
// display data
foreach($Knights as $row) {
	// check if new season
	if ($row->D_Final()<$row->D_Initial()) {
		$row->SetD_initial(0);
	}
	echo "
	<tr>
		<td>" .  $row->Name() . "</td>";
	if ($row->Infraction() == 1) {
		echo "
		<td>Mini Reçues</td>";
	} elseif ($row->Infraction() == 2) {
		echo "
		<td>Mini Données</td>";
	} else {
		echo "
		<td>Mini Données et Reçues</td>";
	}
	$deltaD = $row->D_Final() - $row->D_Initial();
	$deltaR = $row->R_Final() - $row->R_Initial();
	echo "
		<td>" . $deltaD . "</td>
		<td>" . $deltaR . "</td>
		<td>" . $row->D_Initial() . "</td>
		<td>" . $row->R_Initial() . "</td>
		<td>" . $row->D_Final() . "</td>
		<td>" . $row->R_Final() . "</td>
	</tr>";
}
echo "
</table>";
?>