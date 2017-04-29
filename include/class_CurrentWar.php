<?php
class CurrentWar {
	// properties
	private $_id;
	private $_datewar;
	private $_state;
	private $_team_size;
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
	public function state() {return $this->_state;}
	public function team_size() {return $this->_team_size;}
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
	public function setState($String) {if (is_string($String)) {$this->_state = $String;}}
	public function setTeam_size($Number) {if (is_numeric($Number)) {$this->_team_size = $Number;}}
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

class CurrentWarManager {
	// property
	private $_db;
	
	// construct
	public function __construct ($db) {$this->_db = $db;}
	
	// methods
	public function AddWarToDb(CurrentWar $CurrentWar) {
		$qry = $this->_db->prepare("INSERT INTO `coc_currentwar` (`datewar`, `state`, `team_size`, `koh_badgeUrl`, `koh_clanLevel`, `koh_stars`, `koh_attacks`, `koh_destructionPercentage`, `opponent_tag`, `opponent_name`, `opponent_badgeUrl`, `opponent_clanLevel`, `opponent_stars`, `opponent_attacks`, `opponent_destructionPercentage`) VALUES (:datewar, :state, :team_size, :koh_badgeUrl, :koh_clanLevel, :koh_stars, :koh_attacks, :koh_destructionPercentage, :opponent_tag, :opponent_name, :opponent_badgeUrl, :opponent_clanLevel, :opponent_stars, :opponent_attacks, :opponent_destructionPercentage);");
		$qry->bindValue(':datewar', $CurrentWar->datewar());
		$qry->bindValue(':state', $CurrentWar->state());
		$qry->bindValue(':team_size', $CurrentWar->team_size());
		$qry->bindValue(':koh_badgeUrl', $CurrentWar->koh_badgeUrl());
		$qry->bindValue(':koh_clanLevel', $CurrentWar->koh_clanLevel());
		$qry->bindValue(':koh_stars', $CurrentWar->koh_stars());
		$qry->bindValue(':koh_attacks', $CurrentWar->koh_attacks());
		$qry->bindValue(':koh_destructionPercentage', $CurrentWar->koh_destructionPercentage());
		$qry->bindValue(':opponent_tag', $CurrentWar->opponent_tag());
		$qry->bindValue(':opponent_name', $CurrentWar->opponent_name());
		$qry->bindValue(':opponent_badgeUrl', $CurrentWar->opponent_badgeUrl());
		$qry->bindValue(':opponent_clanLevel', $CurrentWar->opponent_clanLevel());
		$qry->bindValue(':opponent_stars', $CurrentWar->opponent_stars());
		$qry->bindValue(':opponent_attacks', $CurrentWar->opponent_attacks());
		$qry->bindValue(':opponent_destructionPercentage', $CurrentWar->opponent_destructionPercentage());
		$qry->execute();
	}
	
	public function UpdateDb(CurrentWar $CurrentWar) {
		$qry = $this->_db->prepare("UPDATE `coc_currentwar` SET `state`=:state,`koh_stars`=:koh_stars,`koh_attacks`=:koh_attacks,`koh_destructionPercentage`=:koh_destructionPercentage,`opponent_stars`=:opponent_stars,`opponent_attacks`=:opponent_attacks,`opponent_destructionPercentage`=:opponent_destructionPercentage WHERE `id`=:id");
		$qry->bindValue(':id', $CurrentWar->id());
		$qry->bindValue(':state', $CurrentWar->result());
		$qry->bindValue(':koh_stars', $CurrentWar->koh_stars());
		$qry->bindValue(':koh_attacks', $CurrentWar->koh_attacks());
		$qry->bindValue(':koh_destructionPercentage', $CurrentWar->koh_destructionPercentage());
		$qry->bindValue(':opponent_stars', $CurrentWar->opponent_stars());
		$qry->bindValue(':opponent_attacks', $CurrentWar->opponent_attacks());
		$qry->bindValue(':opponent_destructionPercentage', $CurrentWar->opponent_destructionPercentage());
		$qry->execute();
	}
	
	public function getLastWarFromDb() {
		$sql = "SELECT * FROM `coc_currentwar` ORDER BY `id` DESC LIMIT 1;";
		$data = $this->_db->query($sql)->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new CurrentWar($data);
		} else {
			return new CurrentWar([]);
		}
	}
}
?>