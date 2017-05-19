<?php 
class Member {
// VARIABLES
	private $_daterecord;
	private $_player_tag;
	private $_name;
	private $_townHallLevel;
	private $_bestTrophies;
	private $_warStars;
	private $_attackWins;
	private $_defenseWins;
	private $_Barbarian;
	private $_Archer;
	private $_Goblin;
	private $_Giant;
	private $_Wall_Breaker;
	private $_Balloon;
	private $_Wizard;
	private $_Healer;
	private $_Dragon;
	private $_PEKKA;
	private $_Baby_Dragon;
	private $_Miner;
	private $_Minion;
	private $_Hog_Rider;
	private $_Valkyrie;
	private $_Golem;
	private $_Witch;
	private $_Lava_Hound;
	private $_Bowler;
	private $_Barbarian_King;
	private $_Archer_Queen;
	private $_Grand_Warden;
	private $_Lightning_Spell;
	private $_Healing_Spell;
	private $_Rage_Spell;
	private $_Jump_Spell;
	private $_Freeze_Spell;
	private $_Clone_Spell;
	private $_Poison_Spell;
	private $_Earthquake_Spell;
	private $_Haste_Spell;
	private $_Skeleton_Spell;
// GETTERS
	public function daterecord() {return $this->_daterecord;}
	public function player_tag() {return $this->_player_tag;}
	public function name() {return $this->_name;}
	public function townHallLevel() {return $this->_townHallLevel;}
	public function bestTrophies() {return $this->_bestTrophies;}
	public function warStars() {return $this->_warStars;}
	public function attackWins() {return $this->_attackWins;}
	public function defenseWins() {return $this->_defenseWins;}
	public function Barbarian() {return $this->_Barbarian;}
	public function Archer() {return $this->_Archer;}
	public function Goblin() {return $this->_Goblin;}
	public function Giant() {return $this->_Giant;}
	public function Wall_Breaker() {return $this->_Wall_Breaker;}
	public function Balloon() {return $this->_Balloon;}
	public function Wizard() {return $this->_Wizard;}
	public function Healer() {return $this->_Healer;}
	public function Dragon() {return $this->_Dragon;}
	public function PEKKA() {return $this->_PEKKA;}
	public function Baby_Dragon() {return $this->_Baby_Dragon;}
	public function Miner() {return $this->_Miner;}
	public function Minion() {return $this->_Minion;}
	public function Hog_Rider() {return $this->_Hog_Rider;}
	public function Valkyrie() {return $this->_Valkyrie;}
	public function Golem() {return $this->_Golem;}
	public function Witch() {return $this->_Witch;}
	public function Lava_Hound() {return $this->_Lava_Hound;}
	public function Bowler() {return $this->_Bowler;}
	public function Barbarian_King() {return $this->_Barbarian_King;}
	public function Archer_Queen() {return $this->_Archer_Queen;}
	public function Grand_Warden() {return $this->_Grand_Warden;}
	public function Lightning_Spell() {return $this->_Lightning_Spell;}
	public function Healing_Spell() {return $this->_Healing_Spell;}
	public function Rage_Spell() {return $this->_Rage_Spell;}
	public function Jump_Spell() {return $this->_Jump_Spell;}
	public function Freeze_Spell() {return $this->_Freeze_Spell;}
	public function Clone_Spell() {return $this->_Clone_Spell;}
	public function Poison_Spell() {return $this->_Poison_Spell;}
	public function Earthquake_Spell() {return $this->_Earthquake_Spell;}
	public function Haste_Spell() {return $this->_Haste_Spell;}
	public function Skeleton_Spell() {return $this->_Skeleton_Spell;}
// SETTERS
	public function setdaterecord($String) {if (is_string($String)) {$this->_daterecord = $String;}}
	public function settag($String) {if (is_string($String)) {$this->_player_tag = $String;}}
	public function setname($String) {if (is_string($String)) {$this->_name = $String;}}
	public function settownHallLevel($Number) {if (is_numeric($Number)) {$this->_townHallLevel = $Number;}}
	public function setbestTrophies($Number) {if (is_numeric($Number)) {$this->_bestTrophies = $Number;}}
	public function setwarStars($Number) {if (is_numeric($Number)) {$this->_warStars = $Number;}}
	public function setattackWins($Number) {if (is_numeric($Number)) {$this->_attackWins = $Number;}}
	public function setdefenseWins($Number) {if (is_numeric($Number)) {$this->_defenseWins = $Number;}}
	public function setBarbarian($Number) {if (is_numeric($Number)) {$this->_Barbarian = $Number;}}
	public function setArcher($Number) {if (is_numeric($Number)) {$this->_Archer = $Number;}}
	public function setGoblin($Number) {if (is_numeric($Number)) {$this->_Goblin = $Number;}}
	public function setGiant($Number) {if (is_numeric($Number)) {$this->_Giant = $Number;}}
	public function setWall_Breaker($Number) {if (is_numeric($Number)) {$this->_Wall_Breaker = $Number;}}
	public function setBalloon($Number) {if (is_numeric($Number)) {$this->_Balloon = $Number;}}
	public function setWizard($Number) {if (is_numeric($Number)) {$this->_Wizard = $Number;}}
	public function setHealer($Number) {if (is_numeric($Number)) {$this->_Healer = $Number;}}
	public function setDragon($Number) {if (is_numeric($Number)) {$this->_Dragon = $Number;}}
	public function setPEKKA($Number) {if (is_numeric($Number)) {$this->_PEKKA = $Number;}}
	public function setBaby_Dragon($Number) {if (is_numeric($Number)) {$this->_Baby_Dragon = $Number;}}
	public function setMiner($Number) {if (is_numeric($Number)) {$this->_Miner = $Number;}}
	public function setMinion($Number) {if (is_numeric($Number)) {$this->_Minion = $Number;}}
	public function setHog_Rider($Number) {if (is_numeric($Number)) {$this->_Hog_Rider = $Number;}}
	public function setValkyrie($Number) {if (is_numeric($Number)) {$this->_Valkyrie = $Number;}}
	public function setGolem($Number) {if (is_numeric($Number)) {$this->_Golem = $Number;}}
	public function setWitch($Number) {if (is_numeric($Number)) {$this->_Witch = $Number;}}
	public function setLava_Hound($Number) {if (is_numeric($Number)) {$this->_Lava_Hound = $Number;}}
	public function setBowler($Number) {if (is_numeric($Number)) {$this->_Bowler = $Number;}}
	public function setBarbarian_King($Number) {if (is_numeric($Number)) {$this->_Barbarian_King = $Number;}}
	public function setArcher_Queen($Number) {if (is_numeric($Number)) {$this->_Archer_Queen = $Number;}}
	public function setGrand_Warden($Number) {if (is_numeric($Number)) {$this->_Grand_Warden = $Number;}}
	public function setLightning_Spell($Number) {if (is_numeric($Number)) {$this->_Lightning_Spell = $Number;}}
	public function setHealing_Spell($Number) {if (is_numeric($Number)) {$this->_Healing_Spell = $Number;}}
	public function setRage_Spell($Number) {if (is_numeric($Number)) {$this->_Rage_Spell = $Number;}}
	public function setJump_Spell($Number) {if (is_numeric($Number)) {$this->_Jump_Spell = $Number;}}
	public function setFreeze_Spell($Number) {if (is_numeric($Number)) {$this->_Freeze_Spell = $Number;}}
	public function setClone_Spell($Number) {if (is_numeric($Number)) {$this->_Clone_Spell = $Number;}}
	public function setPoison_Spell($Number) {if (is_numeric($Number)) {$this->_Poison_Spell = $Number;}}
	public function setEarthquake_Spell($Number) {if (is_numeric($Number)) {$this->_Earthquake_Spell = $Number;}}
	public function setHaste_Spell($Number) {if (is_numeric($Number)) {$this->_Haste_Spell = $Number;}}
	public function setSkeleton_Spell($Number) {if (is_numeric($Number)) {$this->_Skeleton_Spell = $Number;}}
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

class MemberManager{
	private $_db;
	public function __construct($db) {$this->_db = $db;}
	// create member from db
	public function get($tag) {
		$qry = $this->_db->query("SELECT * FROM `coc_weeklydata` WHERE `player_tag` = '$tag' ORDER BY `daterecord` DESC LIMIT 1;");
		return new Member($qry->fetch(PDO::FETCH_ASSOC));
	}
	// create members from db by date
	public function getByDate($daterecord) {
		$Knights = [];
		$qry = $this->_db->query('SELECT * FROM `coc_weeklydata` WHERE `daterecord` = ' . $daterecord);
		while ($res = $qry->fetch(PDO::FETCH_ASSOC)) {
			$Knights[] = new Member($res);
		}
		return $Knights;
	}
	// create member from json API.
	public function getFromJSON($daterecord, $json_array) {
		$Knight = new Member([]);
		// fix part
		$Knight->setdaterecord($daterecord);
		$Knight->settag(substr($json_array->tag, 1));
		$Knight->setname($json_array->name);
		$Knight->settownHallLevel($json_array->townHallLevel);
		$Knight->setbestTrophies($json_array->bestTrophies);
		$Knight->setwarStars($json_array->warStars);
		$Knight->setattackWins($json_array->attackWins);
		$Knight->setdefenseWins($json_array->defenseWins);
		// variable part
		// since barbarians are available from the begining no set check of the troop array.
		foreach ($json_array->troops as $item) {
			switch($item->name) { 
				case "Barbarian": $Knight->setBarbarian($item->level); break;
				case "Archer": $Knight->setArcher($item->level); break;
				case "Goblin": $Knight->setGoblin($item->level); break;
				case "Giant": $Knight->setGiant($item->level); break;
				case "Wall Breaker": $Knight->setWall_Breaker($item->level); break;
				case "Balloon": $Knight->setBalloon($item->level); break;
				case "Wizard": $Knight->setWizard($item->level); break;
				case "Healer": $Knight->setHealer($item->level); break;
				case "Dragon": $Knight->setDragon($item->level); break;
				case "P.E.K.K.A": $Knight->setPEKKA($item->level); break;
				case "Baby Dragon": $Knight->setBaby_Dragon($item->level); break;
				case "Miner": $Knight->setMiner($item->level); break;
				case "Minion": $Knight->setMinion($item->level); break;
				case "Hog Rider": $Knight->setHog_Rider($item->level); break;
				case "Valkyrie": $Knight->setValkyrie($item->level); break;
				case "Golem": $Knight->setGolem($item->level); break;
				case "Witch": $Knight->setWitch($item->level); break;
				case "Lava Hound": $Knight->setLava_Hound($item->level); break;
				case "Bowler": $Knight->setBowler($item->level); break;
			}
		}
		if (isset($json_array->heroes)) {
			foreach ($json_array->heroes as $item) {
				switch($item->name) {
					case "Barbarian King": $Knight->setBarbarian_King($item->level); break;
					case "Archer Queen": $Knight->setArcher_Queen($item->level); break;
					case "Grand Warden": $Knight->setGrand_Warden($item->level); break;
				}
			}
		}
		if (isset ($json_array->spells)) {
			foreach ($json_array->spells as $item) {
				switch($item->name) {
					case "Lightning Spell": $Knight->setLightning_Spell($item->level); break;
					case "Healing Spell": $Knight->setHealing_Spell($item->level); break;
					case "Rage Spell": $Knight->setRage_Spell($item->level); break;
					case "Jump Spell": $Knight->setJump_Spell($item->level); break;
					case "Freeze Spell": $Knight->setFreeze_Spell($item->level); break;
					case "Clone Spell": $Knight->setClone_Spell($item->level); break;
					case "Poison Spell": $Knight->setPoison_Spell($item->level); break;
					case "Earthquake Spell": $Knight->setEarthquake_Spell($item->level); break;
					case "Haste Spell": $Knight->setHaste_Spell($item->level); break;
					case "Skeleton Spell": $Knight->setSkeleton_Spell($item->level); break;
				}
			}
		}
		// return member
		return $Knight;
	}
	// write member into db
	public function add(Member $Knight) {
		$qry = $this->_db->prepare("INSERT INTO `coc_weeklydata`(`daterecord`, `player_tag`, `name`, `townHallLevel`, `warStars`, `attackWins`, ".
			"`defenseWins`, `Barbarian`, `Archer`, `Goblin`, `Giant`, `Wall_Breaker`, `Balloon`, `Wizard`, `Healer`, `Dragon`, `PEKKA`, `Baby_Dragon`, ".
			"`Miner`, `Minion`, `Hog_Rider`, `Valkyrie`, `Golem`, `Witch`, `Lava_Hound`, `Bowler`, `Barbarian_King`, `Archer_Queen`, `Grand_Warden`, ".
			"`Lightning_Spell`, `Healing_Spell`, `Rage_Spell`, `Jump_Spell`, `Freeze_Spell`, `Clone_Spell`, `Poison_Spell`, `Earthquake_Spell`, ".
			"`Haste_Spell`, `Skeleton_Spell`) VALUES (:daterecord, :player_tag, :name, :townHallLevel, :warStars, :attackWins, :defenseWins, :Barbarian, ".
			":Archer, :Goblin, :Giant, :Wall_Breaker, :Balloon, :Wizard, :Healer, :Dragon, :PEKKA, :Baby_Dragon, :Miner, :Minion, :Hog_Rider, :Valkyrie, ".
			":Golem, :Witch, :Lava_Hound, :Bowler, :Barbarian_King, :Archer_Queen, :Grand_Warden, :Lightning_Spell, :Healing_Spell, :Rage_Spell, :Jump_Spell, ".
			":Freeze_Spell, :Clone_Spell, :Poison_Spell, :Earthquake_Spell, :Haste_Spell, :Skeleton_Spell)");
		$qry->bindValue(':daterecord', $Knight->daterecord());
		$qry->bindValue(':player_tag', $Knight->player_tag());
		$qry->bindValue(':name', $Knight->name());
		$qry->bindValue(':townHallLevel', $Knight->townHallLevel());
		$qry->bindValue(':warStars', $Knight->warStars());
		$qry->bindValue(':attackWins', $Knight->attackWins());
		$qry->bindValue(':defenseWins', $Knight->defenseWins());
		if (is_null($Knight->Barbarian())) {
			$qry->bindValue(':Barbarian', 0);
		} else {
			$qry->bindValue(':Barbarian', $Knight->Barbarian());
		}
		if (is_null($Knight->Archer())) {
			$qry->bindValue(':Archer', 0);
		} else {
			$qry->bindValue(':Archer', $Knight->Archer());
		}
		if (is_null($Knight->Goblin())) {
			$qry->bindValue(':Goblin', 0);
		} else {
			$qry->bindValue(':Goblin', $Knight->Goblin());
		}
		if (is_null($Knight->Giant())) {
			$qry->bindValue(':Giant', 0);
		} else {
			$qry->bindValue(':Giant', $Knight->Giant());
		}
		if (is_null($Knight->Wall_Breaker())) {
			$qry->bindValue(':Wall_Breaker', 0);
		} else {
			$qry->bindValue(':Wall_Breaker', $Knight->Wall_Breaker());
		}
		if (is_null($Knight->Balloon())) {
			$qry->bindValue(':Balloon', 0);
		} else {
			$qry->bindValue(':Balloon', $Knight->Balloon());
		}
		if (is_null($Knight->Wizard())) {
			$qry->bindValue(':Wizard', 0);
		} else {
			$qry->bindValue(':Wizard', $Knight->Wizard());
		}
		if (is_null($Knight->Healer())) {
			$qry->bindValue(':Healer', 0);
		} else {
			$qry->bindValue(':Healer', $Knight->Healer());
		}
		if (is_null($Knight->Dragon())) {
			$qry->bindValue(':Dragon', 0);
		} else {
			$qry->bindValue(':Dragon', $Knight->Dragon());
		}
		if (is_null($Knight->PEKKA())) {
			$qry->bindValue(':PEKKA', 0);
		} else {
			$qry->bindValue(':PEKKA', $Knight->PEKKA());
		}
		if (is_null($Knight->Baby_Dragon())) {
			$qry->bindValue(':Baby_Dragon', 0);
		} else {
			$qry->bindValue(':Baby_Dragon', $Knight->Baby_Dragon());
		}
		if (is_null($Knight->Miner())) {
			$qry->bindValue(':Miner', 0);
		} else {
			$qry->bindValue(':Miner', $Knight->Miner());
		}
		if (is_null($Knight->Minion())) {
			$qry->bindValue(':Minion', 0);
		} else {
			$qry->bindValue(':Minion', $Knight->Minion());
		}
		if (is_null($Knight->Hog_Rider())) {
			$qry->bindValue(':Hog_Rider', 0);
		} else {
			$qry->bindValue(':Hog_Rider', $Knight->Hog_Rider());
		}
		if (is_null($Knight->Valkyrie())) {
			$qry->bindValue(':Valkyrie', 0);
		} else {
			$qry->bindValue(':Valkyrie', $Knight->Valkyrie());
		}
		if (is_null($Knight->Golem())) {
			$qry->bindValue(':Golem', 0);
		} else {
			$qry->bindValue(':Golem', $Knight->Golem());
		}
		if (is_null($Knight->Witch())) {
			$qry->bindValue(':Witch', 0);
		} else {
			$qry->bindValue(':Witch', $Knight->Witch());
		}
		if (is_null($Knight->Lava_Hound())) {
			$qry->bindValue(':Lava_Hound', 0);
		} else {
			$qry->bindValue(':Lava_Hound', $Knight->Lava_Hound());
		}
		if (is_null($Knight->Bowler())) {
			$qry->bindValue(':Bowler', 0);
		} else {
			$qry->bindValue(':Bowler', $Knight->Bowler());
		}
		if (is_null($Knight->Barbarian_King())) {
			$qry->bindValue(':Barbarian_King', 0);
		} else {
			$qry->bindValue(':Barbarian_King', $Knight->Barbarian_King());
		}
		if (is_null($Knight->Archer_Queen())) {
			$qry->bindValue(':Archer_Queen', 0);
		} else {
			$qry->bindValue(':Archer_Queen', $Knight->Archer_Queen());
		}
		if (is_null($Knight->Grand_Warden())) {
			$qry->bindValue(':Grand_Warden', 0);
		} else {
			$qry->bindValue(':Grand_Warden', $Knight->Grand_Warden());
		}
		if (is_null($Knight->Lightning_Spell())) {
			$qry->bindValue(':Lightning_Spell', 0);
		} else {
			$qry->bindValue(':Lightning_Spell', $Knight->Lightning_Spell());
		}
		if (is_null($Knight->Healing_Spell())) {
			$qry->bindValue(':Healing_Spell', 0);
		} else {
			$qry->bindValue(':Healing_Spell', $Knight->Healing_Spell());
		}
		if (is_null($Knight->Rage_Spell())) {
			$qry->bindValue(':Rage_Spell', 0);
		} else {
			$qry->bindValue(':Rage_Spell', $Knight->Rage_Spell());
		}
		if (is_null($Knight->Jump_Spell())) {
			$qry->bindValue(':Jump_Spell', 0);
		} else {
			$qry->bindValue(':Jump_Spell', $Knight->Jump_Spell());
		}
		if (is_null($Knight->Freeze_Spell())) {
			$qry->bindValue(':Freeze_Spell', 0);
		} else {
			$qry->bindValue(':Freeze_Spell', $Knight->Freeze_Spell());
		}
		if (is_null($Knight->Clone_Spell())) {
			$qry->bindValue(':Clone_Spell', 0);
		} else {
			$qry->bindValue(':Clone_Spell', $Knight->Clone_Spell());
		}
		if (is_null($Knight->Poison_Spell())) {
			$qry->bindValue(':Poison_Spell', 0);
		} else {
			$qry->bindValue(':Poison_Spell', $Knight->Poison_Spell());
		}
		if (is_null($Knight->Earthquake_Spell())) {
			$qry->bindValue(':Earthquake_Spell', 0);
		} else {
			$qry->bindValue(':Earthquake_Spell', $Knight->Earthquake_Spell());
		}
		if (is_null($Knight->Haste_Spell())) {
			$qry->bindValue(':Haste_Spell', 0);
		} else {
			$qry->bindValue(':Haste_Spell', $Knight->Haste_Spell());
		}
		if (is_null($Knight->Skeleton_Spell())) {
			$qry->bindValue(':Skeleton_Spell', 0);
		} else {
			$qry->bindValue(':Skeleton_Spell', $Knight->Skeleton_Spell());
		}
		$qry->execute();
	}
}

?>
