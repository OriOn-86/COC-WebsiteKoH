<?php 
class MinChecker {
	// Characteristics
	private $_Player_tag;
	private $_Name;
	private $_Donated;
	private $_Received;
	private $_Weekdonated;
	private $_Weekreceived;
	// Getters
	public function Player_tag() {return $this->_Player_tag;}
	public function Name() {return $this->_Name;}
	public function Donated() {return $this->_Donated;}
	public function Received() {return $this->_Received;}
	public function Weekdonated() {return $this->_Weekdonated;}
	public function Weekreceived() {return $this->_Weekreceived;}
	//Setters
	public function setPlayer_tag($String) {
		if (is_string($String)) {
			$this->_Player_tag = $String;
		}
	}
	public function setName($String) {
		if (is_string($String)) {
			$this->_Name = $String;
		}
	}
	public function setDonations($Number) {
		if (is_numeric($Number)){
			$this->_Donated = $Number;
		}
	}
	public function setDonationsreceived($Number) {
		if (is_numeric($Number)){
			$this->_Received = $Number;
		}
	}
	public function setWeekreceived($Number) {
		if (is_numeric($Number)){
			$this->_Weekreceived = $Number;
		}
	}
	public function setWeekdonated($Number) {
		if (is_numeric($Number)){
			$this->_Weekdonated = $Number;
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
		$this->setWeekdonated(0);
		$this->setWeekreceived(0);
	}
}
?>