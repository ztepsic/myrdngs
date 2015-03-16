<?php

class RssChannelItem {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	/**
	 * Naziv elementa
	 *
	 * @var string
	 */
	private $title;
	
	/**
	 * Dohvaca naziv elementa
	 * 
	 * @return string
	 */
	public function GetTitle () {
		return (string) $this->title;
	}
	
	/**
	 * Postavlja naziv elementa
	 * 
	 * @param string $title - naziv elementa
	 */
	public function SetTitle ($title) {
		$this->title = (string) $title;
	}
	
	
	/**
	 * URL adresa elementa
	 *
	 * @var string
	 */
	private $link;
	
	/**
	 * Dohvaca URL adresu elementa
	 * 
	 * @return string
	 */
	public function GetLink () {
		return (string) $this->link;
	}
	
	/**
	 * Postavlja URL adresu elementa
	 * 
	 * @param string $link - URL adresa elementa
	 */
	public function SetLink ($link) {
		$this->link = (string) $link;
	}
	
	
	/**
	 * Opis elementa
	 *
	 * @var string
	 */
	private $description;
	
	/**
	 * Dostavlja opis elementa
	 * 
	 * @return string
	 */
	public function GetDescription () {
		return (string) $this->description;
	}
	
	/**
	 * Postavlja opis elementa
	 * 
	 * @param string $description - opis elementa
	 */
	public function SetDescription ($description) {
		$this->description = (string) $description;
	}
	
	
	/**
	 * Email adresa autora sadrzaja elementa
	 *
	 * @var string
	 */
	private $author;
	
	/**
	 * Dohvaca email adresu autora sadrzaja elementa
	 * 
	 * @return string
	 */
	public function GetAuthor () {
		return (string) $this->author;
	}
	
	/**
	 * Postavlja email adresu autora sadrzaja elementa
	 * 
	 * @param string $author - email adresa autora
	 */
	public function SetAuthor ($author) {
		$this->author = (string) $author;
	}
	
	
	/**
	 * Kategorija elementa
	 *
	 * @var string
	 */
	private $category;
	
	/**
	 * Dohvaca kategoriju elementa
	 * 
	 * @return string
	 */
	public function GetCategory () {
		return (string) $this->category;
	}
	
	/**
	 * Postavlja kategoriju elementa
	 * 
	 * @param string $category - kategorija elementa
	 */
	public function SetCategory ($category) {
		$this->category = (string) $category;
	}
	
	
	/**
	 * URL adresa stranice koja sadrzi relevantne komentare za
	 * trenutni element
	 *
	 * @var string
	 */
	private $comments;
	
	/**
	 * Dohvaca URL adresu relevantnih komentara
	 * 
	 * @return string
	 */
	public function GetComments () {
		return (string) $this->comments;
	}
	
	/**
	 * Postavlja URL adresu relevantnih komentara
	 * 
	 * @param string $comments - URL adresa
	 */
	public function SetComments ($comments) {
		$this->comments = (string) $comments;
	}
	
	
	/**
	 * Opisuje media objekt koji je pridruzen elementu.
	 * U znakovnom polju nalaze se indeksi: url, length, type
	 *
	 * @var RssChannelItemEnclosure
	 */
	private $enclosure;
	
	/**
	 * Dohvaca opise media objekta
	 * 
	 * @return RssChannelItemEnclosure
	 */
	public function GetEnclosure () {
		return $this->enclosure;
	}
	
	/**
	 * Postavlja opis media objekta
	 * @param RssChannelItemEnclosure
	 */
	public function SetEnclosure (RssChannelItemEnclosure $enclosure) {
		$this->enclosure = $enclosure;
	}
	
	
	/**
	 * String koji jedinstveno identificira element
	 *
	 * @var string
	 */
	private $guid;
	
	/**
	 * Dohvaca string koji jedinstveno identificira element
	 * 
	 * @return string
	 */
	public function GetGuid () {
		return (string) $this->guid;
	}
	
	/**
	 * Postavlja string koji jedinstveno identificira element
	 * 
	 * @param string $guid
	 */
	public function SetGuid ($guid) {
		$this->guid = (string) $guid;
	}
	
	
	/**
	 * Datum i vrijeme objavljivanja sadrzaja elementa
	 *
	 * @var string
	 */
	private $pubDate;
	
	/**
	 * Postavlja datum i vrijeme
	 * 
	 * @return string
	 */
	public function GetPubDate () {
		return $this->pubDate;
	}
	
	/**
	 * Postavlja datum i vrijeme
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
	 * RSS channel(izvor) iz kojeg je dosao element.
	 * Najcesce URL
	 *
	 * @var string
	 */
	private $source;
	
	/**
	 * Dohvaca izvor iz kojeg je dosao element
	 * 
	 * @return string
	 */
	public function GetSource () {
		return (string) $this->source;
	}
	
	/**
	 * Postavlja izvor iz kojeg je dosao element
	 * 
	 * @param string $source
	 */
	public function SetSource ($source) {
		$this->source = (string) $source;
	}
		
	
	private $contentEncoded;
	
	/**
	 * Postavlja
	 * 
	 * @param $contentEncoded the $contentEncoded to set
	 */
	public function SetContentEncoded ($contentEncoded) {
		$this->contentEncoded = $contentEncoded;
	}

	/**
	 * Dohvaca
	 * 
	 * @return the $contentEncoded
	 */
	public function GetContentEncoded () {
		return $this->contentEncoded;
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