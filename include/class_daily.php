<?php
class Daily{
	// VARIABLES
	private $_ID;
	private $_date;
	private $_player_tag;
	private $_name;
	private $_role;
	private $_expLevel;
	private $_league;
	private $_trophies;
	private $_versusTrophies;
	private $_clanRank;
	private $_donations;
	private $_donationsReceived;
	// GETTERS
	public function ID() {return $this->_ID;}
	public function date() {return $this->_date;}
	public function player_tag() {return $this->_player_tag;}
	public function name() {return $this->_name;}
	public function role() {return $this->_role;}
	public function expLevel() {return $this->_expLevel;}
	public function league() {return $this->_league;}
	public function trophies() {return $this->_trophies;}
	public function versusTrophies() {return $this->_versusTrophies;}
	public function clanRank() {return $this->_clanRank;}
	public function donations() {return $this->_donations;}
	public function donationsReceived() {return $this->_donationsReceived;}
	// SETTERS
	public function setID($Number) {if (is_numeric($Number)) { $this->_ID = $Number;}}
	public function setdate($String) {if (is_string($String)) {$this->_date = $String;}}
	public function setplayer_tag($String) {if (is_string($String)) { $this->_player_tag = $String;}}
	public function setname($String) {if (is_string($String)) { $this->_name = $String;}}
	public function setrole($String) {if (is_string($String)) { $this->_role = $String;}}
	public function setexpLevel($Number) {if (is_numeric($Number)) { $this->_expLevel = $Number;}}
	public function setleague($String) {if (is_string($String)) { $this->_league = $String;}}
	public function settrophies($Number) {if (is_numeric($Number)) { $this->_trophies = $Number;}}
	public function setversusTrophies($Number) {if (is_numeric($Number)) { $this->_versusTrophies = $Number;}}
	public function setclanRank($Number) {if (is_numeric($Number)) { $this->_clanRank = $Number;}}
	public function setdonations($Number) {if (is_numeric($Number)) { $this->_donations = $Number;}}
	public function setdonationsReceived($Number) {if (is_numeric($Number)) { $this->_donationsReceived = $Number;}}
	// HYDRATE
	public function hydrate(array $data) {
		foreach ($data as $key => $value) {
			$method = 'set' . $key;
			if (method_exists($this, $method)) {$this->$method($value);}
		}
		unset($value);
	}
	// CONSTRUCT
	public function __construct (array $data) {$this->hydrate($data);}
}

class DailyManager {
	private $_db;
	
	/**
	 * constructor
	 * @param PDO $db
	 */
	public function __construct($db){$this->_db = $db;}
	
	/**
	 * 
	 * @param string $PlayerTag player ID without the #
	 * @param number $rowLimit default to 1, maximum number of row to return
	 * @return Daily[]
	 */
	public function getPlayerData($PlayerTag, $rowLimit = 1){
		$dailyItems = [];
		if (is_string($PlayerTag) && is_numeric($rowLimit)) {
			$qry = $this->_db->prepare("SELECT `date`, `expLevel`, `league`, `trophies`, `versusTrophies`, `clanRank`, `previousClanRank`, `donations`, `donationsReceived` " .
					"FROM `coc_dailydata` WHERE player_tag= :player_tag ORDER BY `date` DESC LIMIT $rowLimit");
			$qry->execute(array(':player_tag' => $PlayerTag));
			while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {
				$dailyItems[] = new Daily($row);
			}
		}
		return $dailyItems;
	}

	/**
	 * get the last record's date from database
	 * @return string
	 */
	public function getLastDailyRecordDate(){
		$sql = "SELECT * FROM `coc_dailydata` ORDER BY `id` DESC LIMIT 1";
		$data= $this->_db->query($sql)->fetch(PDO::FETCH_ASSOC);
		$Daily = new Daily($data);
		return $Daily->date();
	}
	
	/**
	 * 
	 * @param string $daterecord date of interest
	 * @return Daily[] array containing all members' dailty records for the date of interest
	 */
	public function getDailyFromDate($daterecord) {
		$Dailies = [];
		$sql = "SELECT * FROM `coc_dailydata` WHERE `date`='$daterecord' ORDER BY `clanRank` LIMIT 50";
		$qry = $this->_db->query($sql);
		while ($data = $qry->fetch(PDO::FETCH_ASSOC)) {
			$Dailies[] = new Daily($data);
		}
		return $Dailies;
	}
	
	/**
	 * Returns either the clan rank of the player of interest at the date of interest
	 * or False is the player was not in the clan at that date. 
	 * @param string $daterecord date of interest
	 * @param string $Player_Tag player tag of interest
	 * @return mixed clanRank when existing, False if record not found
	 */
	public function getPlayerPosition($daterecord, $Player_Tag){
		$sql = "SELECT `clanRank` FROM `coc_dailydata` WHERE `date`='$daterecord' AND `player_tag`='$Player_Tag';";
		$data = $this->_db->query($sql)->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return $data["clanRank"];
		} else {
			return False;
		}
	}
	
	/**
	 * Returns the top 3 donators of the date of interest
	 * @param string $daterecord date of interest
	 * @return Daily[]
	 */
	public function getTopDonators($daterecord) { 
		$TopDonators = [];
		$sql = "SELECT * FROM `coc_dailydata` WHERE `date`='$daterecord' ORDER BY `donations` DESC LIMIT 3";
		$qry = $this->_db->query($sql);
		while ($data = $qry->fetch(PDO::FETCH_ASSOC)) {
			$TopDonators[] = new Daily($data);
		}
		return $TopDonators;
	}
	
	
}
