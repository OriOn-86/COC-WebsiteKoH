<?php
class War {
// properties
	private $_id;
	private $_datewar;
	private $_result;
	private $_state;
	private $_team_size;
	private $_exp_earned;
	private $_koh_badgeUrl;
	private $_koh_clanLevel;
	private $_koh_stars;
	private $_koh_attacks;
	private $_koh_destructionPercentage;
	private $_opponent_tag;
	private $_opponent_name;
	private $_opponent_badgeUrl;
	private $_opponent_clanLevel;
	private $_opponent_stars;
	private $_opponent_attacks;
	private $_opponent_destructionPercentage;

// methods
	// getters
	public function id() {return $this->_id;}
	public function datewar() {return $this->_datewar;}
	public function result() {return $this->_result;}
	public function state() {return $this->_state;}
	public function team_size() {return $this->_team_size;}
	public function exp_earned() {return $this->_exp_earned;}
	public function koh_badgeUrl() {return $this->_koh_badgeUrl;}
	public function koh_clanLevel() {return $this->_koh_clanLevel;}
	public function koh_stars() {return $this->_koh_stars;}
	public function koh_attacks() {return $this->_koh_attacks;}
	public function koh_destructionPercentage() {return $this->_koh_destructionPercentage;}
	public function opponent_tag() {return $this->_opponent_tag;}
	public function opponent_name() {return $this->_opponent_name;}
	public function opponent_badgeUrl() {return $this->_opponent_badgeUrl;}
	public function opponent_clanLevel() {return $this->_opponent_clanLevel;}
	public function opponent_stars() {return $this->_opponent_stars;}
	public function opponent_attacks() {return $this->_opponent_attacks;}
	public function opponent_destructionPercentage() {return $this->_opponent_destructionPercentage;}
	// setters
	public function setId($Number) {if (is_numeric($Number)) {$this->_id = $Number;}}
	public function setDatewar($String) {if (is_string($String)) {$this->_datewar = $String;}}
	public function setResult($String) {if (is_string($String)) {$this->_result = $String;}}
	public function setState($String) {if (is_string($String)) {$this->_state = $String;}}
	public function setTeam_size($Number) {if (is_numeric($Number)) {$this->_team_size = $Number;}}
	public function setExp_earned($Number) {if (is_numeric($Number)) {$this->_exp_earned = $Number;}}
	public function setKoh_badgeUrl($String) {if (is_string($String)) {$this->_koh_badgeUrl= $String;}}
	public function setKoh_clanLevel($Number) {if (is_numeric($Number)) {$this->_koh_clanLevel = $Number;}}
	public function setKoh_stars($Number) {if (is_numeric($Number)) {$this->_koh_stars = $Number;}}
	public function setKoh_attacks($Number) {if (is_numeric($Number)) {$this->_koh_attacks = $Number;}}
	public function setKoh_destructionPercentage($Number) {if (is_numeric($Number)) {$this->_koh_destructionPercentage = $Number;}}
	public function setOpponent_tag($String) {if (is_string($String)) {$this->_opponent_tag = $String;}}
	public function setOpponent_name($String) {if (is_string($String)) {$this->_opponent_name = $String;}}
	public function setOpponent_badgeUrl($String) {if (is_string($String)) {$this->_opponent_badgeUrl = $String;}}
	public function setOpponent_clanLevel($Number) {if (is_numeric($Number)) {$this->_opponent_clanLevel = $Number;}}
	public function setOpponent_stars($Number) {if (is_numeric($Number)) {$this->_opponent_stars = $Number;}}
	public function setOpponent_attacks($Number) {if (is_numeric($Number)) {$this->_opponent_attacks = $Number;}}
	public function setOpponent_destructionPercentage($Number) {if (is_numeric($Number)) {$this->_opponent_destructionPercentage = $Number;}}
	// hydrate
	public function hydrate(array $data) {
		foreach ($data as $key => $value) {
			$method = 'set' . $key;
			if (method_exists($this, $method)) {$this->$method($value);}
		}
		unset($value);
	}
	// construct
	public function __construct (array $data) {$this->hydrate($data);}
}

class WarManager {
// property
	private $_db;
// methods
	// construct
	public function __construct ($db) {$this->_db = $db;}

	/**
	 * Insert a war into the coc_wars table
	 * @param War $War
	 * @param string $callingProc optional ("currentwar" if ommited)
	 * @return boolean True on success / False on failure
	 */
	public function addWarToDb(War $War, $callingProc = "currentwar") {
		switch ($callingProc) {
			case "currentwar":
				$qry = $this->_db->prepare("INSERT INTO `coc_wars` (`datewar`, `state`, `team_size`, ".
					"`koh_badgeUrl`, `koh_clanLevel`, `koh_stars`, `koh_attacks`, `koh_destructionPercentage`, " .
					"`opponent_tag`, `opponent_name`, `opponent_badgeUrl`, `opponent_clanLevel`, `opponent_attacks`, " .
					"`opponent_stars`, `opponent_destructionPercentage`) VALUES (:datewar, :state, :team_size, " .
					":koh_badgeUrl,  :koh_clanLevel, :koh_stars, :koh_attacks, :koh_destructionPercentage, " .
					":opponent_tag, :opponent_name, :opponent_badgeUrl, :opponent_clanLevel, :opponent_stars, " .
					":opponent_attacks, :opponent_destructionPercentage);");
				$qry->bindValue(':datewar', $War->datewar());
				$qry->bindValue(':state', $War->state());
				$qry->bindValue(':team_size', $War->team_size());
				$qry->bindValue(':koh_badgeUrl', $War->koh_badgeUrl());
				$qry->bindValue(':koh_clanLevel', $War->koh_clanLevel());
				$qry->bindValue(':koh_stars', $War->koh_stars());
				$qry->bindValue(':koh_attacks', $War->koh_attacks());
				$qry->bindValue(':koh_destructionPercentage', $War->koh_destructionPercentage());
				$qry->bindValue(':opponent_tag', $War->opponent_tag());
				$qry->bindValue(':opponent_name', $War->opponent_name());
				$qry->bindValue(':opponent_badgeUrl', $War->opponent_badgeUrl());
				$qry->bindValue(':opponent_clanLevel', $War->opponent_clanLevel());
				$qry->bindValue(':opponent_stars', $War->opponent_stars());
				$qry->bindValue(':opponent_attacks', $War->opponent_attacks());
				$qry->bindValue(':opponent_destructionPercentage', $War->opponent_destructionPercentage());
				break;
			
			case "warlog":
				$qry = $this->_db->prepare("UPDATE `coc_wars` SET `result` = :result, `exp_earned` = :exp_earned WHERE `id` = :id");
				$qry->bindValue(':result', $War->result());
				$qry->bindValue(':exp_earned', $War->exp_earned());
				$qry->bindValue(':id', $War->id());
				break;
		}
		return $qry->execute();
	}

	/**
	 * Checks if a War Exists in the database 
	 * @param string $datewar End date of war
	 * @return mixed id of war if exists / False if not
	 */
	public function Exists($datewar) {
		$sql = "SELECT `id` FROM `coc_wars` WHERE `datewar`= '$datewar'";
		$qry = $this->_db->query($sql);
		return $qry->fetchColumn();
	}
	
	/**
	 * Update database record on specific war
	 * @param War $War a War object containing data to update the database with 
	 * @return boolean success update
	 */
	public function UpdateWar(War $War) {
	// update war with defined information
		$qry = $this->_db->prepare("UPDATE `coc_wars` SET `state`=:state, `koh_stars`=:koh_stars, `koh_attacks`=:koh_attacks, `koh_destructionPercentage`=:koh_destructionPercentage, `opponent_stars`=:opponent_stars, `opponent_attacks`=:opponent_attacks, `opponent_destructionPercentage`=:opponent_destructionPercentage WHERE `id`=:id");
		$qry->bindValue(':state', $War->state());
		$qry->bindValue(':koh_stars', $War->koh_stars());
		$qry->bindValue(':koh_attacks', $War->koh_attacks());
		$qry->bindValue(':koh_destructionPercentage', $War->koh_destructionPercentage());
		$qry->bindValue(':opponent_stars', $War->opponent_stars());
		$qry->bindValue(':opponent_attacks', $War->opponent_attacks());
		$qry->bindValue(':opponent_destructionPercentage', $War->opponent_destructionPercentage());
		$qry->bindValue(':id', $War->id());
		
		return $qry->execute();

	}

	/**
	 * Returns the latest war from database
	 * @return War
	 */
	public function getLastWarFromDb() {
		$sql = "SELECT * FROM `coc_wars` ORDER BY `datewar` DESC LIMIT 1;";
		$data = $this->_db->query($sql)->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new War($data);
		} else {
			return new War([]);
		}
	}

	/**
	 * getWarFromID returns a war from its ID 
	 * @param integer $warid
	 * @return War
	 */
	public function getWarFromID($warid) {
		$sql = "SELECT * FROM `coc_wars` WHERE `id` = $warid";
		$data = $this->_db->query($sql)->fetch(PDO::FETCH_ASSOC);
		return new War($data);
	}

	/**
	 * Using the WAR API (/clans/{clanTag}/warlog),
	 * transforms the json responce into a war object
	 * @param string $json_array
	 * @return War
	 */
	public function getWarFromJSON($json_array) {
		// format time
		$endTime = $json_array->items[0]->endTime;
		$endTime = substr_replace(substr_replace(substr($endTime, 0, 8), "-", 6, 0), "-", 4, 0);
		// create War object
		$LastWar = new War([]);
		$LastWar->setDatewar($endTime);
		$LastWar->setResult($json_array->items[0]->result);
		$LastWar->setTeam_size($json_array->items[0]->teamSize);
		$LastWar->setExp_earned($json_array->items[0]->clan->expEarned);
		$LastWar->setKoh_stars($json_array->items[0]->clan->stars);
		$LastWar->setKoh_attacks($json_array->items[0]->clan->attacks);
		$LastWar->setKoh_clanLevel($json_array->items[0]->clan->clanLevel);
		$LastWar->setKoh_destructionPercentage($json_array->items[0]->clan->destructionPercentage);
		$LastWar->setOpponent_tag($json_array->items[0]->opponent->tag);
		$LastWar->setOpponent_name($json_array->items[0]->opponent->name);
		$LastWar->setOpponent_clanLevel($json_array->items[0]->opponent->clanLevel);
		$LastWar->setOpponent_stars($json_array->items[0]->opponent->stars);
		//$LastWar->setOpponent_attacks($json_array->items[0]->opponent->attacks);
		$LastWar->setOpponent_destructionPercentage($json_array->items[0]->opponent->destructionPercentage);
		return $LastWar;
	}

	/**
	 * generic getter for multiple purposes
	 * @param array $specifics array defining the SQL query to filter, order, limit the coc_wars table from it's columns and their values
	 * @return War[] array of War satisfying specifics
	 */
	public function getWarsBySpecific(array $specifics) {
		$allowedItems = ["id", "datewar", "result", "team_size", "exp_earned", "koh_clanLevel", "koh_stars", "koh_attacks", "koh_destructionPercentage", "opponent_tag", "opponent_name", "opponent_clanLevel", "opponent_stars", "opponent_attacks", "opponent_destructionPercentage"];
		$Wars = [];
		$sql = "SELECT * FROM `coc_wars` ";
		//$sql = "SELECT * FROM `coc_currentwar` ";
		if (isset($specifics['filter'])) {
			$filter = $specifics['filter'];
			$pos = strpos($filter, " ");
			if ($pos) {
				$Item = substr($filter, 0, $pos);
				if (in_array($Item, $allowedItems)) {
					$sql .= "WHERE $filter ";
				}
			}
		}
		if (isset($specifics['orderBy'])) {
			$orderBy = $specifics['orderBy'];
			$pos = strpos($orderBy, " ");
			if ($pos) {
				$Item = substr($orderBy, 0, $pos);
				if (in_array($Item, $allowedItems)) {
					$sql .= "ORDER BY $orderBy ";
				}
			}
		}
		if (isset($specifics['limit'])) {
			$limit = $specifics['limit'];
			$sql .= "LIMIT $limit ";
		}
		$sql .= ";";
		$qry = $this->_db->query($sql);
		while ($data = $qry->fetch(PDO::FETCH_ASSOC)) {
			$Wars[] = new War($data);
		}
		return $Wars;
	}

	/**
	 * Lookup through Wars instead of requerying the database.
	 * @param string $Element getter from the War Class
	 * @param integer $warid Id of the war of interest
	 * @param array $Wars Array of war supposed to contain the war of interest
	 * @return mixed string or integer depending on the getter requested
	 */
	public function LookupthroughWars($Element, $warid, array $Wars){
		foreach ($Wars as $War) {
			if ($War->id() == $warid) {
				if (method_exists($War, $Element)){
					return $War->$Element();
				}
			}
		}
	}
}
?>