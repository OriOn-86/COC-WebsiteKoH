<?php

class Feed {

	private $_title;
	private $_guid;
	private $_description;
	private $_pubDate;
	
	public function title() {return $this->_title;}
	public function guid() {return $this->_guid;}
	public function description() {return $this->_description;}
	public function pubDate() {return $this->_pubDate;}
	
	public function settitle() {if (is_string($String)) {$this->_title = $String;}}
	public function setguid() {if (is_numeric($Number)) {$this->_guid = $Number;}}
	public function setdescription() {if (is_string($String)) {$this->_description = $String;}}
	public function setpubDate() {if (is_numeric($Number)) {$this->_pubDate = $Number;}}
	
	public function hydrate(array $data) {
		foreach ($data as $key => $value) {
			$method = 'set' . $key;
			if (method_exists($this, $method)) {$this->$method($value);}
		}
		unset($value);
	}
	
	public function __construct (array $data) {$this->hydrate($data);}
}

class FeedManager {

	private $_db;
	
	public function __construct ($db) {$this->_db = $db;}
	
	public function create_feed($Channel, $feeds) {
		$rssFile = fopen("RSS/currentwar.xml", "w");
		
		$xml  = '<?xml version="1.0" encoding="utf-8"?>' . "\n";
		$xml .= '<rss version="2.0">' . "\n";
		$xml .= '<channel>' . "\n";
		$xml .= '<title>' . $Channel["title"] . '</title>' . "\n";
		$xml .= '<link>' . $Channel["link"] . '</link>' . "\n";
		$xml .= '<description>' . $Channel["description"] . '</description>' . "\n";
		$xml .= '<image>' . "\n";
		$xml .= '<title>' . $Channel["image_title"] . '</title>' . "\n";
		$xml .= '<link>' . $Channel["image_link"] . '</link>' . "\n";
		$xml .= '<url>' . $Channel["image_url"] . '</url>' . "\n";
		$xml .= '</image>' . "\n";
	
		foreach ($feeds as $feed) {
			$xml .= '<item>' . "\n";
			$xml .= '<title>' . $feed->title() . '</title>' . "\n";
			$xml .= '<guid>' . $feed->guid() . '</guid>' . "\n";
			$xml .= '<link>knightsofhell.homenet.org/index.php?op=CurrentClanWar</link>' . "\n"; 
			$xml .= '<description>' . $feed->description() . '</description>' . "\n";
			$xml .= '<pubDate>' . $feed->pubDate() . '</pubDate>' . "\n";
			$xml .= '</item>' . "\n";
		}
		
		$xml .= '</channel>' . "\n";
		$xml .= '</rss>';
		
		fwrite($rssFile, $xml);
		fclose($rssFile);
	}
	
	public function read_recent_feed() {
		$sql = "SELECT * FROM `coc_feed` ORDER BY `guid` DESC LIMIT 10";
		$qry = $this->_db->query($sql);
		while ($data = $qry->fetch(PDO::FETCH_ASSOC)) {
			$feeds[] = new feed($data);
		}
		return $feeds;
	}
	
	public function store_new_feed($feed) {
		$sql = "INSERT INTO `coc_feed`(`title`, `description`, `pubDate`) VALUES (:title, :description, :pubDate)";
		$qry = $this->_db->prepare($sql);
		$qry->bindValue(':title', $feed->title());
		$qry->bindValue(':description', $feed->description());
		$qry->bindValue(':pubDate', $feed->pubDate());
		$qry->execute();
	}
}


?>