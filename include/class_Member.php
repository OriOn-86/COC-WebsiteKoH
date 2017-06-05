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
	private $_builderHallLevel;
	private $_bestVersusTrophies;
	private $_versusBattleWins;
	private $_versusBattleWinCount;
	
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
	private $_Raged_Barbarian;
	private $_Sneaky_Archer;
	private $_Boxer_Giant;
	private $_Beta_Minion;
	private $_Bomber;
	private $_Baby_Dragon2;
	private $_Cannon_Cart;
	private $_Night_Witch;
	private $_Drop_Ship;
	private $_Super_PEKKA;
	
	private $_Barbarian_King;
	private $_Archer_Queen;
	private $_Grand_Warden;
	private $_Battle_Machine;
	
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
	public function builderHallLevel() {return $this->_builderHallLevel;}
	public function bestVersusTrophies() {return $this->_bestVersusTrophies;}
	public function versusBattleWins() {return $this->_versusBattleWins;}
	public function versusBattleWinCount() {return $this->_versusBattleWinCount;}

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
	public function Raged_Barbarian() {return $this->_Raged_Barbarian;}
	public function Sneaky_Archer() {return $this->_Sneaky_Archer;}
	public function Boxer_Giant() {return $this->_Boxer_Giant;}
	public function Beta_Minion() {return $this->_Beta_Minion;}
	public function Bomber() {return $this->_Bomber;}
	public function Baby_Dragon2() {return $this->_Baby_Dragon2;}
	public function Cannon_Cart() {return $this->_Cannon_Cart;}
	public function Night_Witch() {return $this->_Night_Witch;}
	public function Drop_Ship() {return $this->_Drop_Ship;}
	public function Super_PEKKA() {return $this->_Super_PEKKA;}

	public function Barbarian_King() {return $this->_Barbarian_King;}
	public function Archer_Queen() {return $this->_Archer_Queen;}
	public function Grand_Warden() {return $this->_Grand_Warden;}
	public function Battle_Machine() {return $this->_Battle_Machine;}

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
	public function setbuilderHallLevel($Number) {if (is_numeric($Number)) {$this->_builderHallLevel = $Number;}}
	public function setbestVersusTrophies($Number) {if (is_numeric($Number)) {$this->_bestVersusTrophies = $Number;}}
	public function setversusBattleWins($Number) {if (is_numeric($Number)) {$this->_versusBattleWins = $Number;}}
	public function setversusBattleWinCount($Number) {if (is_numeric($Number)) {$this->_versusBattleWinCount = $Number;}}

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
	public function setRaged_Barbarian($Number) {if (is_numeric($Number)) {$this->_Raged_Barbarian = $Number;}}
	public function setSneaky_Archer($Number) {if (is_numeric($Number)) {$this->_Sneaky_Archer = $Number;}}
	public function setBoxer_Giant($Number) {if (is_numeric($Number)) {$this->_Boxer_Giant = $Number;}}
	public function setBeta_Minion($Number) {if (is_numeric($Number)) {$this->_Beta_Minion = $Number;}}
	public function setBomber($Number) {if (is_numeric($Number)) {$this->_Bomber = $Number;}}
	public function setBaby_Dragon2($Number) {if (is_numeric($Number)) {$this->_Baby_Dragon2 = $Number;}}
	public function setCannon_Cart($Number) {if (is_numeric($Number)) {$this->_Cannon_Cart = $Number;}}
	public function setNight_Witch($Number) {if (is_numeric($Number)) {$this->_Night_Witch = $Number;}}
	public function setDrop_Ship($Number) {if (is_numeric($Number)) {$this->_Drop_Ship = $Number;}}
	public function setSuper_PEKKA($Number) {if (is_numeric($Number)) {$this->_Super_PEKKA = $Number;}}

	public function setBarbarian_King($Number) {if (is_numeric($Number)) {$this->_Barbarian_King = $Number;}}
	public function setArcher_Queen($Number) {if (is_numeric($Number)) {$this->_Archer_Queen = $Number;}}
	public function setGrand_Warden($Number) {if (is_numeric($Number)) {$this->_Grand_Warden = $Number;}}
	public function setBattle_Machine($Number) {if (is_numeric($Number)) {$this->_Battle_Machine = $Number;}}

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
		$Knight->setbuilderHallLevel($json_array->builderHallLevel);
		$Knight->setbestVersusTrophies($json_array->bestVersusTrophies);
		$Knight->setversusBattleWins($json_array->versusBattleWins);
		$Knight->setversusBattleWinCount($json_array->versusBattleWinCount);
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
				case "Baby Dragon": 
					if ($item->village == "home") {
						$Knight->setBaby_Dragon($item->level);
						break;
					} else {
						$Knight->setBaby_Dragon2($item->level);
						break;
					}
				case "Miner": $Knight->setMiner($item->level); break;
				case "Minion": $Knight->setMinion($item->level); break;
				case "Hog Rider": $Knight->setHog_Rider($item->level); break;
				case "Valkyrie": $Knight->setValkyrie($item->level); break;
				case "Golem": $Knight->setGolem($item->level); break;
				case "Witch": $Knight->setWitch($item->level); break;
				case "Lava Hound": $Knight->setLava_Hound($item->level); break;
				case "Bowler": $Knight->setBowler($item->level); break;
				case "Raged Barbarian": $Knight->setRaged_Barbarian($item->level); break;
				case "Sneaky Archer": $Knight->setSneaky_Archer($item->level); break;
				case "Boxer Giant": $Knight->setBoxer_Giant($item->level); break;
				case "Beta Minion": $Knight->setBeta_Minion($item->level); break;
				case "Bomber": $Knight->setBomber($item->level); break;
				case "Cannon Cart": $Knight->setCannon_Cart($item->level); break;
				case "Night Witch": $Knight->setNight_Witch($item->level); break;
				case "Drop Ship": $Knight->setDrop_Ship($item->level); break;
				case "Super P.E.K.K.A": $Knight->setSuper_PEKKA($item->level); break;
			}
		}
		if (isset($json_array->heroes)) {
			foreach ($json_array->heroes as $item) {
				switch($item->name) {
					case "Barbarian King": $Knight->setBarbarian_King($item->level); break;
					case "Archer Queen": $Knight->setArcher_Queen($item->level); break;
					case "Grand Warden": $Knight->setGrand_Warden($item->level); break;
					case "Battle Machine": $Knight->setBattle_Machine($item->level); break;
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
		$sql = "INSERT INTO `coc_weeklydata` (`daterecord`, `player_tag`, `name`, `townHallLevel`, `warStars`, `attackWins`, `defenseWins`, `builderHallLevel`, `bestVersusTrophies`, `versusBattleWins`, `versusBattleWinCount`, " .
			"`Barbarian`, `Archer`, `Goblin`, `Giant`, `Wall_Breaker`, `Balloon`, `Wizard`, `Healer`, `Dragon`, `PEKKA`, `Baby_Dragon`, `Miner`, `Minion`, `Hog_Rider`, `Valkyrie`, `Golem`, `Witch`, `Lava_Hound`, `Bowler`, `Raged_Barbarian`, `Sneaky_Archer`, `Boxer_Giant`, `Beta_Minion`, `Bomber`, `Baby_Dragon2`, `Cannon_Cart`, `Night_Witch`, `Drop_Ship`, `Super_PEKKA`, " .
			"`Barbarian_King`, `Archer_Queen`, `Grand_Warden`, `Battle_Machine`, " .
			"`Lightning_Spell`, `Healing_Spell`, `Rage_Spell`, `Jump_Spell`, `Freeze_Spell`, `Clone_Spell`, `Poison_Spell`, `Earthquake_Spell`, `Haste_Spell`, `Skeleton_Spell`) " .
			"VALUES ('" . $Knight->daterecord() . "', '" . $Knight->player_tag() . "' , :name, " .  $Knight->townHallLevel() . ", " . $Knight->warStars() . ", " . $Knight->attackWins() . ", " .
			$Knight->defenseWins() . ", " . $Knight->builderHallLevel() . ", " . $Knight->bestVersusTrophies() . ", " . $Knight->versusBattleWins() . ", " .  $Knight->versusBattleWinCount() . ", ";
		// troops
		is_null($Knight->Barbarian()) ?			$sql .= 0 . ", " : $sql .= $Knight->Barbarian() . ", ";
		is_null($Knight->Archer()) ?			$sql .= 0 . ", " : $sql .= $Knight->Archer() . ", ";
		is_null($Knight->Goblin()) ?			$sql .= 0 . ", " : $sql .= $Knight->Goblin() . ", ";
		is_null($Knight->Giant()) ?				$sql .= 0 . ", " : $sql .= $Knight->Giant() . ", ";
		is_null($Knight->Wall_Breaker()) ?		$sql .= 0 . ", " : $sql .= $Knight->Wall_Breaker() . ", ";
		is_null($Knight->Balloon()) ?			$sql .= 0 . ", " : $sql .= $Knight->Balloon() . ", ";
		is_null($Knight->Wizard()) ?			$sql .= 0 . ", " : $sql .= $Knight->Wizard() . ", ";
		is_null($Knight->Healer()) ?			$sql .= 0 . ", " : $sql .= $Knight->Healer() . ", ";
		is_null($Knight->Dragon()) ?			$sql .= 0 . ", " : $sql .= $Knight->Dragon() . ", ";
		is_null($Knight->PEKKA()) ?				$sql .= 0 . ", " : $sql .= $Knight->PEKKA() . ", ";
		is_null($Knight->Baby_Dragon()) ?		$sql .= 0 . ", " : $sql .= $Knight->Baby_Dragon() . ", ";
		is_null($Knight->Miner()) ?				$sql .= 0 . ", " : $sql .= $Knight->Miner() . ", ";
		is_null($Knight->Minion()) ?			$sql .= 0 . ", " : $sql .= $Knight->Minion() . ", ";
		is_null($Knight->Hog_Rider()) ?			$sql .= 0 . ", " : $sql .= $Knight->Hog_Rider() . ", ";
		is_null($Knight->Valkyrie()) ?			$sql .= 0 . ", " : $sql .= $Knight->Valkyrie() . ", ";
		is_null($Knight->Golem()) ?				$sql .= 0 . ", " : $sql .= $Knight->Golem() . ", ";
		is_null($Knight->Witch()) ?				$sql .= 0 . ", " : $sql .= $Knight->Witch() . ", ";
		is_null($Knight->Lava_Hound()) ?		$sql .= 0 . ", " : $sql .= $Knight->Lava_Hound() . ", ";
		is_null($Knight->Bowler()) ?			$sql .= 0 . ", " : $sql .= $Knight->Bowler() . ", ";
		is_null($Knight->Raged_Barbarian()) ?	$sql .= 0 . ", " : $sql .= $Knight->Raged_Barbarian() . ", ";
		is_null($Knight->Sneaky_Archer()) ?		$sql .= 0 . ", " : $sql .= $Knight->Sneaky_Archer() . ", ";
		is_null($Knight->Boxer_Giant()) ?		$sql .= 0 . ", " : $sql .= $Knight->Boxer_Giant() . ", ";
		is_null($Knight->Beta_Minion()) ?		$sql .= 0 . ", " : $sql .= $Knight->Beta_Minion() . ", ";
		is_null($Knight->Bomber()) ?			$sql .= 0 . ", " : $sql .= $Knight->Bomber() . ", ";
		is_null($Knight->Baby_Dragon2()) ?		$sql .= 0 . ", " : $sql .= $Knight->Baby_Dragon2() . ", ";
		is_null($Knight->Cannon_Cart()) ?		$sql .= 0 . ", " : $sql .= $Knight->Cannon_Cart() . ", ";
		is_null($Knight->Night_Witch()) ?		$sql .= 0 . ", " : $sql .= $Knight->Night_Witch() . ", ";
		is_null($Knight->Drop_Ship()) ?			$sql .= 0 . ", " : $sql .= $Knight->Drop_Ship() . ", ";
		is_null($Knight->Super_PEKKA()) ?		$sql .= 0 . ", " : $sql .= $Knight->Super_PEKKA() . ", ";
		// heroes
		is_null($Knight->Barbarian_King()) ?	$sql .= 0 . ", " : $sql .= $Knight->Barbarian_King() . ", ";
		is_null($Knight->Archer_Queen()) ?		$sql .= 0 . ", " : $sql .= $Knight->Archer_Queen() . ", ";
		is_null($Knight->Grand_Warden()) ?		$sql .= 0 . ", " : $sql .= $Knight->Grand_Warden() . ", ";
		is_null($Knight->Battle_Machine()) ?	$sql .= 0 . ", " : $sql .= $Knight->Battle_Machine() . ", ";
		// spells
		is_null($Knight->Lightning_Spell()) ?	$sql .= 0 . ", " : $sql .= $Knight->Lightning_Spell() . ", ";
		is_null($Knight->Healing_Spell()) ?		$sql .= 0 . ", " : $sql .= $Knight->Healing_Spell() . ", ";
		is_null($Knight->Rage_Spell()) ?		$sql .= 0 . ", " : $sql .= $Knight->Rage_Spell() . ", ";
		is_null($Knight->Jump_Spell()) ?		$sql .= 0 . ", " : $sql .= $Knight->Jump_Spell() . ", ";
		is_null($Knight->Freeze_Spell()) ?		$sql .= 0 . ", " : $sql .= $Knight->Freeze_Spell() . ", ";
		is_null($Knight->Clone_Spell()) ?		$sql .= 0 . ", " : $sql .= $Knight->Clone_Spell() . ", ";
		is_null($Knight->Poison_Spell()) ?		$sql .= 0 . ", " : $sql .= $Knight->Poison_Spell() . ", ";
		is_null($Knight->Earthquake_Spell()) ?	$sql .= 0 . ", " : $sql .= $Knight->Earthquake_Spell() . ", ";
		is_null($Knight->Haste_Spell()) ?		$sql .= 0 . ", " : $sql .= $Knight->Haste_Spell() . ", ";
		is_null($Knight->Skeleton_Spell()) ?	$sql .= 0 . ");" : $sql .= $Knight->Skeleton_Spell() . ");";	
		// query
		$qry = $this->_db->prepare($sql);
		$qry->bindValue(':name', $Knight->name());
		$qry->execute();
	}
}

?>
