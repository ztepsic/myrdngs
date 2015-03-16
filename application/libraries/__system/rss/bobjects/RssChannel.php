<?php

require_once ('RssChannelImage.php');
require_once ('RssChannelItem.php');

class RssChannel {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	const DEFAULT_TTL = 180;
	
	/**
	 * Naziv channela. Najcesce je naziv slican nazivu
	 * web stranice
	 *
	 * @var string
	 */
	private $title;
	
	/**
	 * Dohvaca naziv channela
	 * @return string
	 */
	public function GetTitle () {
		return (string) $this->title;
	}
	
	/**
	 * Postavlja naziv channela
	 * @param string $title - naziv channela
	 */
	public function SetTitle ($title) {
		$this->title = (string) $title;
	}
	
	
	/**
	 * URL adresa na web site ciji se sadrzaj prikazuje u channelu
	 *
	 * @var string
	 */
	private $link;
	
	/**
	 * Dohvaca URL adresu web site-a
	 * 
	 * @return string
	 */
	public function GetLink () {
		return (string) $this->link;
	}
	
	/**
	 * Postavlja URL adresu web site-a
	 * 
	 * @param string $link - web adresa site-a
	 */
	public function SetLink ($link) {
		$this->link = (string) $link;
	}
	
	
	/**
	 * Opis channela
	 *
	 * @var string
	 */
	private $description;
	
	/**
	 * Dohvaca opis channela
	 * 
	 * @return string
	 */
	public function GetDescription () {
		return (string) $this->description;
	}
	
	/**
	 * Postavlja opis channela
	 * 
	 * @param string $description - opis channela
	 */
	public function SetDescription ($description) {
		$this->description = (string) $description;
	}
	
	
	/**
	 * Naziv kategorije
	 *
	 * @var string
	 */
	private $category;
	
	/**
	 * Dohvaca naziv kategorije
	 * 
	 * @return string
	 */
	public function GetCategory () {
		return (string) $this->category;
	}
	
	/**
	 * Postavlja naziv kategorije
	 * 
	 * @param string $category
	 */
	public function SetCategory ($category) {
		$this->category = (string) $category;
	}

	
	
	/**
	 * Datum publikacije kanala.
	 * Zapis je u formatu RFC 822
	 *
	 * @var string
	 */
	private $pubDate;
	
	/**
	 * Dohvaca datum publikacije kanala.
	 * 
	 * @return string
	 */
	public function GetPubDate () {
		return $this->pubDate;
	}
	
	/**
	 * Postavlja datum publikacije kanala
	 * 
	 * @param string $pubDate
	 */
	public function SetPubDate ($pubDate) {
		if(is_object($pubDate) || is_string($pubDate)){
			$this->pubDate = strtotime($pubDate);
		} else {
			$this->pubDate = (int) $pubDate;
		}
	}
	
	
	/**
	 * Zadnji datum i vrijeme promjene na kanalu
	 *
	 * @var string
	 */
	private $lastBuildDate;
	
	/**
	 * Dohvaca zadnji datum i vrijeme promjene na kanalu
	 * 
	 * @return string
	 */
	public function GetLastBuildDate () {
		return $this->lastBuildDate;
	}
	
	/**
	 * Postavlja zadnji datum i vrijeme promjene na kanalu
	 * 
	 * @param string $lastBuildDate
	 */
	public function SetLastBuildDate ($lastBuildDate) {
		$this->lastBuildDate = $lastBuildDate;
	}
	
	
	/**
	 * Time to live. Broj u minutama koji indicira kolko
	 * dugo se kanal moze cached prije novog osvjezavanja
	 *
	 * @var int
	 */
	private $ttl;
	
	/**
	 * Dohvaca ttl
	 * 
	 * @return int
	 */
	public function GetTtl () {
		return (int) $this->ttl;
	}
	
	/**
	 * Postavlja ttl
	 * 
	 * @param int $ttl
	 */
	public function SetTtl ($ttl) {
		if($ttl == 0){
			$ttl = RssChannel::DEFAULT_TTL;
		}
		
		$this->ttl = (int) $ttl;
	}

	
	
	/**
	 * Naziv programa koji je zaduzen za generiranje kanala
	 *
	 * @var string
	 */
	private $generator;
	
	/**
	 * Dohvaca naziv generatora
	 * 
	 * @return string
	 */
	public function GetGenerator () {
		return (string) $this->generator;
	}
	
	/**
	 * Postavlja naziv generatora
	 * 
	 * @param string $generator
	 */
	public function SetGenerator ($generator) {
		$this->generator = (string) $generator;
	}
	
	
	/**
	 * URL adresa dokumentacije za format koji se koristi u RSS datoteci.
	 *
	 * @var string
	 */
	private $docs;
	
	/**
	 * Dohvaca URL adresu dokumentacije
	 * 
	 * @return string
	 */
	public function GetDocs () {
		return (string) $this->docs;
	}
	
	/**
	 * Postavlja URL adresu dokumentacije
	 * 
	 * @param string $docs
	 */
	public function SetDocs ($docs) {
		$this->docs = (string) $docs;
	}
	
	
	/**
	 * Jezik na kojemu je napisan sadrzaj kanala
	 *
	 * @example en-us
	 * @var string
	 */
	private $language;
	
	/**
	 * Dohvaca jezik kanala.
	 *  
	 * @example en-us
	 * @return string
	 */
	public function GetLanguage () {
		return (string) $this->language;
	}
	
	/**
	 * Postavlja jezik kanala
	 * 
	 * @example en-us
	 * @param string $language
	 */
	public function SetLanguage ($language) {
		$this->language = (string) $language;
	}
	
	
	/**
	 * Copyright text
	 *
	 * @var string
	 */
	private $copyright;
	
	/**
	 * Dohvaca copyright
	 * 
	 * @return string
	 */
	public function GetCopyright () {
		return (string) $this->copyright;
	}
	
	/**
	 * Postavlja copyright
	 * 
	 * @param string $copyright
	 */
	public function SetCopyright ($copyright) {
		$this->copyright = (string) $copyright;
	}
	
	
	/**
	 * Email adresa osobe odgovorne za sadrzaj kanala
	 *
	 * @var string
	 */
	private $managingEditor;
	
	/**
	 * Dohvaca email adresu osobe odgovorne za sadrzaj kanala
	 * 
	 * @return string
	 */
	public function getManagingEditor () {
		return (string) $this->managingEditor;
	}
	
	/**
	 * Postavlja email adresu osobe odgovorne za sadrzaj kanala
	 * 
	 * @param string $managingEditor
	 */
	public function SetManagingEditor ($managingEditor) {
		$this->managingEditor = (string) $managingEditor;
	}
	
	
	/**
	 * Email adresa osobe odgovorne za tehnicka pitanja
	 *
	 * @var string
	 */
	private $webMaster;
	
	/**
	 * Dohvaca email osobe odgovorne za tehnicka pitanja
	 * 
	 * @return string
	 */
	public function GetWebMaster () {
		return (string) $this->webMaster;
	}
	
	/**
	 * Postavlje email osobe odgovorne za tehnicka pitanja
	 * 
	 * @param string $webMaster
	 */
	public function SetWebMaster ($webMaster) {
		$this->webMaster = (string) $webMaster;
	}


	/**
	 * Slika koja predstavlja kanal
	 *
	 * @var RssChannelImage
	 */
	private $image;
	
	/**
	 * Dohvaca sliku kanala
	 * 
	 * @return RssChannelImage
	 */
	public function GetImage () {
		return $this->image;
	}
	
	/**
	 * Postavlja sliku kanala
	 * 
	 * @param RssChannelImage $image
	 */
	public function SetImage ($image) {
		$this->image = $image;
	}
	
	
	/**
	 * Elementi kanala
	 *
	 * @var array<RssChannelItem>
	 */
	private $items;
	
	/**
	 * Dohvaca elemente kanala
	 * 
	 * @return array<RssChannelItem>
	 */
	public function GetItems () {
		return $this->items;
	}
	
	/**
	 * Postavlja elemente kanala
	 * 
	 * @param array<RssChannelItem> $items
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
	
	
	function __construct () {
	
	}
	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
}

?>