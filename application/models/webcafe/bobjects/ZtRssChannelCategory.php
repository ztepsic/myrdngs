<?php


class ZtRssChannelCategory {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	/**
	 * Identifikator grupe rss kanala
	 * @var int
	 */
	private $id;
	
	/**
	 * Postavlja identifikator grupe rss kanala
	 * 
	 * @param $id the $id to set
	 */
	public function SetId ($id) {
		$this->id = $id;
	}

	/**
	 * Dohvaca identifikator grupe rss kanala
	 * 
	 * @return the $id
	 */
	public function GetId () {
		return $this->id;
	}
	
	
	
	/**
	 * Naziv grupe rss kanala
	 * @var string
	 */
	private $name;
	
	/**
	 * Postavlja naziv grupe rss kanala
	 * 
	 * @param $name the $name to set
	 */
	public function SetName ($name) {
		$this->name = $name;
	}


	/**
	 * Dohvaca naziv grupe rss kanala
	 * 
	 * @return the $name
	 */
	public function GetName () {
		return $this->name;
	}

	
	
	/**
	 * Opis grupe rss kanala
	 * @var string
	 */
	private $description;
	
	/**
	 * Postavlja opis grupe rss kanala
	 * 
	 * @param $description the $description to set
	 */
	public function SetDescription ($description) {
		$this->description = $description;
	}

	/**
	 * Dohvaca opis grupe rss kanala
	 * 
	 * @return the $description
	 */
	public function GetDescription () {
		return $this->description;
	}

	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################
	

	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################
	
	
	/**
	 * Konstrukor
	 * @param $id - identifikator grupe rss kanala
	 * @param $name - naziv grupe rss kanala
	 * @param $description - opis grupe rss kanala
	 */
	function __construct ($id = 0, $name, $description) {
		$this->id = $id;
		$this->name = $name;
		$this->description = $description;
	}


	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
}

?>