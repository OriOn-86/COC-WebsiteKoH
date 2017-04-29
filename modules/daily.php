<?php
// obj. declaration
class Daily {
	// Characteristics
	private $_Position;
	private $_Level;
	private $_League;
	private $_Tag;
	private $_Name;
	private $_Trophies;
	private $_Donated;
	private $_Received;
	// Getters
	public function Position() {return $this->_Position;}
	public function Level() {return $this->_Level;}
	public function League() {return $this->_League;}
	public function Tag() {return $this->_Tag;}
	public function Name() {return $this->_Name;}
	public function Trophies() {return $this->_Trophies;}
	public function Donated() {return $this->_Donated;}
	public function Received() {return $this->_Received;}
	// Setters
	public function setClanrank($Number) {if (is_numeric($Number)) {$this->_Position = $Number;}}
	public function setExplevel($Number) {if (is_numeric($Number)) {$this->_Level = $Number;}}
	public function setLeague($String) {if (is_string($String)) {$this->_League = $String;}}
	public function setPlayer_tag($String) {if (is_string($String)) {$this->_Tag = $String;}}
	public function setName($String) {if (is_string($String)) {$this->_Name = $String;}}
	public function setTrophies($Number) {if (is_numeric($Number)) {$this->_Trophies = $Number;}}
	public function setDonations($Number) {if (is_numeric($Number)) {$this->_Donated = $Number;}}
	public function setDonationsreceived($Number) {if (is_numeric($Number)) {$this->_Received = $Number;}}
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
	// Construct
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
	$sql = "SELECT `date` FROM `coc_dailydata` ORDER BY `id` DESC LIMIT 0,1";
	$qry = $db->query($sql)->fetch(PDO::FETCH_ASSOC);
	$daterecord = $qry['date'];
}
// eve
$date = new DateTime(strftime($daterecord));
$date->sub(new DateInterval('P1D'));
$eve = $date->format('Y-m-d');
// Load data
$sql = "SELECT `player_tag`, `name`, `expLevel`, `league`, `trophies`, `clanRank`, `donations`, `donationsReceived` FROM `coc_dailydata` WHERE `date`=\"" . $daterecord . "\" ORDER BY `clanRank` LIMIT 0, 50";
$qry = $db->query($sql);
while ($data = $qry->fetch(PDO::FETCH_ASSOC)) {
	$Knights[] = new Daily($data);
}
// TOP donation
$sql = "SELECT `player_tag`, `name`, `expLevel`, `league`, `trophies`, `clanRank`, `donations`, `donationsReceived` FROM `coc_dailydata` WHERE `date`=\"" . $daterecord . "\" ORDER BY `donations` DESC LIMIT 3";
$qry = $db->query($sql);
while ($data = $qry->fetch(PDO::FETCH_ASSOC)) {
	$TopDonators[] = new Daily($data);
}

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
		<div class='position'>" . $row->Position() . "</div>
		<div class='evolution' "; 
		// implement data-position='up|down|equal|new'
		$previousPosition = $db->query("SELECT `clanRank` FROM `coc_dailydata` WHERE `date`=\"" . $eve . "\" AND `player_tag`=\"" . $row->Tag() . "\"")->fetchColumn();
		if ($previousPosition) {
			if ((int)$previousPosition < $row->Position()) {
				echo "data-position='down'";
			} elseif ((int)$previousPosition == $row->Position()) {
				echo "data-position='equal'";
			} else {
				echo "data-position='up'";
			}
		} else {
			echo "data-position='new'";
		}
		echo "></div>
		<div class='league'><img src='images/leagues/" . str_replace(' ', '_', $row->League()) . "-S.png' /></div>
		<div class='level'>" . $row->Level() . "</div>
		<div class='playerName'><p>" . $row->Name() . "</p><a href=\"index.php?op=playerprofile&PlayerTag=" . $row->Tag() . "\"><img src='images/burger.png' /></a></div>
		<div class='trophies'><p>" . $row->Trophies() . "</p><img src='images/trophies.png' /></div>
		<div class='troops'>" . $row->Donated() . "</div>
		<div class='troops'>" . $row->Received() . "</div>
		<div class='ratio' data-ratio='";
		if ($row->Received() == 0) {
			$ratio = 0; 
		} else {
			$ratio = $row->Donated() / $row->Received();
		}
		if ($ratio < 0.5) { echo "bad"; } else { echo "good"; }
		echo "'>" . number_format($ratio, 2, '.', ',') . "</div>
	</div>";
		
}
echo "
</div>";
?>