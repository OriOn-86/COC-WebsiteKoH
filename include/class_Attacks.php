<?php

class Attacks {
	// properties
	private $_id;
	private $_warid;
	private $_MapRank;
	private $_Player_ID;
	private $_Player_Name;
	private $_Player_TH;
	private $_Atk1Rank;
	private $_Atk1Percent;
	private $_Atk1Star;
	private $_Atk2Rank;
	private $_Atk2Percent;
	private $_Atk2Star;
	private $_Attacked;
	private $_EBA_Rank;
	private $_EBA_Destrution;
	private $_EBA_Star;
	
	// getters
	public function id() {return $this->_id;}
	public function warid() {return $this->_warid;}
	public function MapRank() {return $this->_MapRank;}
	public function Player_ID() {return $this->_Player_ID;}
	public function Player_Name() {return $this->_Player_Name;}
	public function Player_TH() {return $this->_Player_TH;}
	public function Attack_1_Rank() {return $this->_Atk1Rank;}
	public function Attack_1_Percentage() {return $this->_Atk1Percent;}
	public function Attack_1_Star() {return $this->_Atk1Star;}
	public function Attack_2_Rank() {return $this->_Atk2Rank;}
	public function Attack_2_Percentage() {return $this->_Atk2Percent;}
	public function Attack_2_Star() {return $this->_Atk2Star;}
	public function Attacked() {return $this->_Attacked;}
	public function EBA_AttackerRank() {return $this->_EBA_Rank;}
	public function EBA_Destruction() {return $this->_EBA_Destrution;}
	public function EBA_Star() {return $this->_EBA_Star;}
	
	// setters
	public function setId($Number) {if (is_numeric($Number)) {$this->_id = $Number;}}
	public function setWarid($Number) {if (is_numeric($Number)) {$this->_warid = $Number;}}
	public function setMapRank($Number) {if (is_numeric($Number)) {$this->_MapRank = $Number;}}
	public function setPlayer_ID($String) {if (is_string($String)) {$this->_Player_ID = $String;}}
	public function setPlayer_Name($String) {if (is_string($String)) {$this->_Player_Name = $String;}}
	public function setPlayer_TH($Number) {if (is_numeric($Number)) {$this->_Player_TH = $Number;}}
	public function setAttack_1_Rank($Number) {if (is_numeric($Number)) {$this->_Atk1Rank = $Number;}}
	public function setAttack_1_Percentage($Number) {if (is_numeric($Number)) {$this->_Atk1Percent = $Number;}}
	public function setAttack_1_Star($Number) {if (is_numeric($Number)) {$this->_Atk1Star = $Number;}}
	public function setAttack_2_Rank($Number) {if (is_numeric($Number)) {$this->_Atk2Rank = $Number;}}
	public function setAttack_2_Percentage($Number) {if (is_numeric($Number)) {$this->_Atk2Percent = $Number;}}
	public function setAttack_2_Star($Number) {if (is_numeric($Number)) {$this->_Atk2Star = $Number;}}
	public function setAttacked($Number) {if (is_numeric($Number)) {$this->_Attacked = $Number;}}
	public function setEBA_AttackerRank($Number) {if (is_numeric($Number)) {$this->_EBA_Rank = $Number;}}
	public function setEBA_Destruction($Number) {if (is_numeric($Number)) {$this->_EBA_Destrution = $Number;}}
	public function setEBA_Star($Number) {if (is_numeric($Number)) {$this->_EBA_Star = $Number;}}
	
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


class AttackManager {
	// properties
	private $_db;
	
	// CONSTRUCT
	public function __construct($db) {$this->_db = $db;}
	
	// get player map position for a war
	public function getMapPosition($warid, $tag) {
		$qry = $this->_db->prepare("SELECT `MapRank` FROM `coc_currentwar_detail` WHERE `warid`=:warid AND `Player_ID`=:Player_ID");
		$qry->bindValue(':warid', $warid);
		$qry->bindValue(':Player_ID', $tag);
		$qry->execute();
		return $qry->fetch(PDO::FETCH_ASSOC)['MapRank'];
	}
	
	// write attacks into db
	public function AddWarAttacks($warAttacks) {
		$SQL = "";
		foreach ($warAttacks as $Attack) {
			$SQL .= "INSERT INTO `coc_currentwar_detail` (`warid`, `MapRank`, `Player_ID`, `Player_TH`, `Attack_1_Rank`, `Attack_1_Percentage`, `Attack_1_Star`, `Attack_2_Rank`, `Attack_2_Percentage`, `Attack_2_Star`, `Attacked`, `EBA_AttackerRank`, `EBA_Destruction`, `EBA_Star`) VALUES (" 
				. $Attack->warid() . ", " 
				. $Attack->MapRank() . ", '" 
				. $Attack->Player_ID() . "', " 
				. $Attack->Player_TH() . ", " 
				. Nz($Attack->Attack_1_Rank(), 0) . ", " 
				. Nz($Attack->Attack_1_Percentage(), 0) . ", "	
				. Nz($Attack->Attack_1_Star(), 0) . ", " 
				. Nz($Attack->Attack_2_Rank(), 0) . ", " 
				. Nz($Attack->Attack_2_Percentage(), 0) . ", " 
				. Nz($Attack->Attack_2_Star(), 0) . ", " 
				. Nz($Attack->Attacked(), 0) . ", " 
				. Nz($Attack->EBA_AttackerRank(), 0) . ", " 
				. Nz($Attack->EBA_Destruction(), 0) . ", " 
				. Nz($Attack->EBA_Star(), 0) . "); ";
		}
		
		$qry = $this->_db->prepare($SQL);
		$qry->execute();
	}
	
	// update attacks
	public function UpdateWarAttacks($warAttacks) {
		$SQL = "";
		foreach ($warAttacks as $Attack) {
			$SQL .= "UPDATE `coc_currentwar_detail` SET  `Attacked`=" . $Attack->Attacked()
			. ", `Attack_1_Rank`=" . Nz($Attack->Attack_1_Rank(), 0)
			. ", `Attack_1_Percentage`=" . Nz($Attack->Attack_1_Percentage(), 0)
			. ", `Attack_1_Star`=" . Nz($Attack->Attack_1_Star(), 0)
			. ", `Attack_2_Rank`=" . Nz($Attack->Attack_2_Rank(), 0)
			. ", `Attack_2_Percentage`=" . Nz($Attack->Attack_2_Percentage(), 0)
			. ", `Attack_2_Star`=" . Nz($Attack->Attack_2_Star(), 0)
			. ", `EBA_AttackerRank`=" . Nz($Attack->EBA_AttackerRank(), 0)
			. ", `EBA_Destruction`=" .  Nz($Attack->EBA_Destruction(), 0)
			. ", `EBA_Star`=" . Nz($Attack->EBA_Star(), 0)
			. " WHERE (`warid`=" . $Attack->warid() 
			. " AND `Player_ID`='". $Attack->Player_ID() . "'); ";
		}
		
		$qry = $this->_db->prepare($SQL);
		$qry->execute();
	}
	
	// read attacks from db
	public function getAttacks($warid) {
		$CurrentWarAttacks = [];
		
		$sql = "SELECT * FROM `coc_currentwar_detail` WHERE `warid`=$warid ORDER BY `MapRank` ASC;";
		$qry = $this->_db->query($sql);
		while ($data = $qry->fetch(PDO::FETCH_ASSOC)) {
			$CurrentWarAttacks[] = new Attacks($data);
		}
		return $CurrentWarAttacks;
	}
	
	// select player's info from his map position
	public function MemberAtPosition($Attacks, $MapPosition, $warSize) {
		// preliminary checks
		if ((count($Attacks) == $warSize*2) && ($MapPosition <= $warSize)) {
			// navigate through array
			$Attack = $Attacks[$warSize + $MapPosition - 1];
			// lookup Name
			$qry = $this->_db->prepare("SELECT `name` FROM `coc_dailydata` WHERE `player_tag`=:player_tag ORDER BY `date` DESC LIMIT 1");
			$qry->bindValue(':player_tag', substr($Attack->Player_ID(),1));
			$qry->execute();
			$Attack->SetPlayer_Name($qry->fetch(PDO::FETCH_ASSOC)['name']);
		} else {
			$Attack = new Attacks([]);
		}
		return $Attack;
	}
	public function OpponentAtPosition($Attacks, $MapPosition, $warSize) {
		// preliminary checks
		if ((count($Attacks) == $warSize*2) && ($MapPosition <= $warSize)) {
			// navigate through array
			$Attack = $Attacks[$warSize - $MapPosition];
		} else {
			$Attack = new Attacks([]);
		}
		return $Attack;
	}

}
