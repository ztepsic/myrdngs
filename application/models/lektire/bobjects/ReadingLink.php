<?php

class ReadingLink {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	/**
	 * Identifikator linka
	 * 
	 * @var int
	 */
	private $id;
	
	/**
	 * Postavlja identifikator linka
	 * @param $id the $id to set
	 */
	public function SetId ($id) {
		$this->id = $id;
	}

	/**
	 * Dohvaca identifikator linka
	 * 
	 * @return the $id
	 */
	public function GetId () {
		return $this->id;
	}
	
	
	/**
	 * URL adresa linka na online lektiru
	 * 
	 * @var string
	 */
	private $url;
	
	/**
	 * Postavlja URL adresu linka na online lektiru
	 * 
	 * @param $url the $url to set
	 */
	public function SetUrl ($url) {
		$this->url = $url;
	}

	/**
	 * Dohvaca URL adresu linka na online lektiru
	 * 
	 * @return the $url
	 */
	public function GetUrl () {
		return $this->url;
	}
	
	
	/**
	 * Identifikator knjige
	 * @var int
	 */
	private $bookId;
	
	/**
	 * Postavlja identifikator knjige
	 * 
	 * @param $bookId the $bookId to set
	 */
	public function SetBookId ($bookId) {
		$this->bookId = $bookId;
	}

	/**
	 * Dohvaca identifikator knjige
	 * 
	 * @return the $bookId
	 */
	public function GetBookId () {
		return $this->bookId;
	}
	
	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################
	
	
	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################
	
	public function __construct ($id = 0, $url, $bookId) {
		$this->id = $id;
		$this->url = $url;
		$this->bookId = $bookId;
	}

	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
	
	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################
	
	/**
	 * Dohvaca host originalnog URL-a
	 * @return string
	 */
	public function GetHost(){
		$parsedReadingLinkUrlArray = parse_url("http://" . $this->url);
		return $parsedReadingLinkUrlArray["host"];
	}
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
	
			
}

?>