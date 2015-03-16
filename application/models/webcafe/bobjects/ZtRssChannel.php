<?php

require_once (LIBPATH . SYSPATH . "rss/bobjects/RssChannel.php");
require_once ('ZtRssChannelCategory.php');

class ZtRssChannel extends RssChannel {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	/**
	 * Identifikator rss kanala
	 * 
	 * @var int
	 */
	private $id;
	
	/**
	 * Postavlja identifikator rss kanala
	 * 
	 * @param $id the $id to set
	 */
	public function SetId ($id) {
		$this->id = $id;
	}

	/**
	 * Dohvaca identifikator rss kanala
	 * 
	 * @return the $id - identifikator rss kanala
	 */
	public function GetId () {
		return $this->id;
	}

	
	
	/**
	 * Vrijeme poslijednjeg preuzimanja sadrzaja kanala
	 * 
	 * @var datetime
	 */
	private $latestDownload;
	
	/**
	 * Postavlja vrijeme poslijednjeg preuzimanja sadrzaja rss kanala
	 * 
	 * @param $latestDownload the $latestDownload to set
	 */
	public function SetLatestDownload ($latestDownload) {
		if(is_object($latestDownload) || is_string($latestDownload)){
			$this->latestDownload = strtotime($latestDownload);
		} else {
			$this->latestDownload = (int) $latestDownload;
		}
	}

	/**
	 * Dohvaca vrijeme poslijednjeg preuzimanja sadrzaja rss kanala
	 * 
	 * @return the $latestDownload
	 */
	public function GetLatestDownload () {
		return $this->latestDownload;
	}

	
	/**
	 * Kategorija rss kanala
	 * @var RssChannelCateogry
	 */
	private $category;
	
	/**
	 * Postavlja kategoriju rss kanala
	 * 
	 * @param $category the $category to set
	 */
	public function SetCategory ($category) {
		$this->category = $category;
	}

	/**
	 * Dohvaca kategoriju rss kanala
	 * 
	 * @return the $category
	 */
	public function GetCategory () {
		return $this->category;
	}

	
	/**
	 * Url adresa dohvata rss sadrzaja
	 * 
	 * @var string
	 */
	private $sourceUrl;
	
	/**
	 * Postavlja url adresu dohvata rss sadrzaja
	 * 
	 * @param $sourceUrl the $sourceUrl to set
	 */
	public function SetSourceUrl ($sourceUrl) {
		$this->sourceUrl = $sourceUrl;
	}

	/**
	 * Dohvaca url adresu dohvata rss sadrzaja
	 * 
	 * @return the $sourceUrl
	 */
	public function GetSourceUrl () {
		return $this->sourceUrl;
	}
	
	
	/**
	 * Dohvaca elemente kanala
	 * 
	 * @return array<ZtRssChannelItem>
	 */
	public function GetItems () {
		return $this->items;
	}
	
	/**
	 * Postavlja elemente kanala
	 * 
	 * @param array<ZtRssChannelItem> $items
	 */
	public function SetItems ($items) {
		$this->items = $items;
	}
	

	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################
	

	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################
	
	
	/**
	 * Konstruktor
	 */
	function __construct () {
		parent::__construct();
		
	}
	

	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
}

?>