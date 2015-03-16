<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Predstavlja autora knjige
 *
 */
class Author {


	/**
	 * Identifikator autora
	 *
	 * @var int
	 */
	private $id;

	/**
	 * Dohvaca identifikator autora
	 *
	 * @return int
	 */
	public function GetId(){
		return $this->id;
	}

	/**
	 * Postavlja identifikator autora
	 *
	 * @param int $authorId - identifikator autora
	 */
	public function SetId($authorId){
		$this->id = $authorId;
	}


	/**
	 * Ime autora
	 *
	 * @var String
	 */
	private $name;

	/**
	 * Dohvaca ime autora
	 *
	 * @return String
	 */
	public function GetName(){
		return $this->name;
	}

	/**
	 * Postavlja ime autora
	 *
	 * @param String $authorName - ime autora
	 */
	public function SetName($authorName){
		$this->name = $authorName;
	}


	/**
	 * Prezime autora
	 *
	 * @var String
	 */
	private $surname;


	/**
	 * Dohvaca prezime autora
	 *
	 * @return String
	 */
	public function GetSurname(){
		return $this->surname;
	}

	/**
	 * Postavlja prezime autora
	 *
	 * @param String $authorSurname - prezime autora
	 */
	public function SetSurname($authorSurname){
		$this->surname = $authorSurname;
	}


	/**
	 * Dohvaca ime i prezime autora
	 *
	 * @return String
	 */
	public function GetFullName(){
		$fullName = "";
		$name = $this->GetName();
		if(!empty($name)){
			$fullName = $name;
		}
		
		$surname = $this->GetSurname(); 
		if(!empty($surname)){
			if(empty($fullName)){
				$fullName = $surname;
			} else {
				$fullName .= " " . $surname;
			}
		}
		
		return $fullName;
		
	}


	/**
	 * Informacije o autoru
	 *
	 * @var String
	 */
	private $info;

	/**
	 * Dohvaca informacie o autoru
	 *
	 * @return String
	 */
	public function GetInfo(){
		return $this->info;
	}

	/**
	 * Postavlja informacije o autoru
	 *
	 * @param String $authorInfo - informacije o autoru
	 */
	public function SetInfo($authorInfo){
		$this->info = $authorInfo;
	}


	/**
	 * URI na stranicu sa informacijama
	 *
	 * @var String
	 */
	private $infoUri;

	/**
	 * Dohvaca uri na stanicu sa informacijama
	 *
	 * @return String
	 */
	public function GetInfoUri(){
		return $this->infoUri;
	}

	/**
	 * Postavlja URI na stranicu sa informacijama o autoru
	 *
	 * @param String $authorInfoUri
	 */
	public function SetInfoUri($authorInfoUri){
		$this->infoUri = $authorInfoUri;
	}



	/**
	 * Konstruktor
	 *
	 * @param String $authorName - ime autora
	 * @param String $authorSurname - prezime autora
	 */
	public function __construct($authorName, $authorSurname){
		$this->name = $authorName;
		$this->surname = $authorSurname;

		$this->id = 0;
		$this->info = null;
		$this->hrWikiUri = null;
	}



}


?>