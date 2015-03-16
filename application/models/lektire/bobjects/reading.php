<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Predstavlja lektiru
 *
 */
class Reading {

	/**
	 * Identifikator lektire
	 *
	 * @var int
	 */
	private $id;

	/**
	 * Dohvaca identifikator lektire
	 *
	 * @return int
	 */
	public function GetId(){
		return $this->id;
	}

	/**
	 * Postavlja identifikator lektire
	 *
	 * @param int $readingId - identifikator lektire
	 */
	public function SetId($readingId){
		$this->id = $readingId;
	}


	/**
	 * Naziv datoteke lektire
	 *
	 * @var String
	 */
	private $fileName;

	/**
	 * Dohvaca naziv datoteke lektire
	 *
	 * @return String
	 */
	public function GetFileName(){
		return $this->fileName;
	}

	/**
	 * Postavlja naziv datoteke lektire
	 *
	 * @param String $readingFileName - naziv datoteke lektire
	 */
	public function SetFileName($readingFileName){
		$this->fileName = $readingFileName;
	}


	/**
	 * Datum i vrijeme dodavanja lektire - timestamp
	 *
	 * @var int
	 */
	private $dateTimeAdded;

	/**
	 * Dohvaca datum i vrijeme dodavanja lektire - timestamp
	 *
	 * @return int
	 */
	public function GetDateTimeAdded(){
		return $this->dateTimeAdded;
	}

	/**
	 * Postavlja datum i vrijeme dodavanja lektire
	 *
	 * @param int $dateTimeAdded - datum i vrijeme dodavanja lektire - timestamp
	 */
	public function SetDateTimeAdded($dateTimeAdded){
		if(is_object($dateTimeAdded) || is_string($dateTimeAdded)){
			$this->dateTimeAdded = strtotime($dateTimeAdded);
		} else {
			$this->dateTimeAdded = (int) $dateTimeAdded;
		}
	}
	
	
	/**
	 * Autor napisane lektire
	 * @var string
	 */
	private $readingAuthorName;
	
	/**
	 * Dohvaca autora napisane lektire
	 * @return string
	 */
	public function GetReadingAuthorName(){
		return (string) $this->readingAuthorName;
	}
	
	/**
	 * Postavlja autora napisane lektire
	 * @param string $readingAuthor
	 */
	public function SetReadingAuthorName($readingAuthorName){
		$this->readingAuthorName = (string) $readingAuthorName;
	}
	
	/**
	 * Internetska stranica autora
	 * @var string
	 */
	private $readingAuthorWebsite;
	
	/**
	 * Dohvaca website autora napisane lektire
	 * @return string
	 */
	public function GetReadingAuthorWebsite(){
		return (string) $this->readingAuthorWebsite;
	}
	
	/**
	 * Postavlja website autora napisane lektire
	 * @param string $readingAuthor
	 */
	public function SetReadingAuthorWebsite($readingAuthorWebsite){
		$this->readingAuthorWebsite = (string) $readingAuthorWebsite;
	}
	
	/**
	 * Info o autoru
	 * @var string
	 */
	private $readingAuthorInfo;
	
	/**
	 * Dohvaca info autora napisane lektire
	 * @return string
	 */
	public function GetReadingAuthorInfo(){
		return (string) $this->readingAuthorInfo;
	}
	
	/**
	 * Postavlja website autora napisane lektire
	 * @param string $readingAuthor
	 */
	public function SetReadingAuthorInfo($readingAuthorInfo){
		$this->readingAuthorInfo = (string) $readingAuthorInfo;
	}
	
	/**
	 * Email autoru
	 * @var string
	 */
	private $readingAuthorEmail;
	
	/**
	 * Dohvaca email autora napisane lektire
	 * @return string
	 */
	public function GetReadingAuthorEmail(){
		return (string) $this->readingAuthorEmail;
	}
	
	/**
	 * Postavlja email autora napisane lektire
	 * @param string $readingAuthor
	 */
	public function SetReadingAuthorEmail($readingAuthorEmail){
		$this->readingAuthorEmail = (string) $readingAuthorEmail;
	}


	/**
	 * Broj preuzimanja lektire
	 *
	 * @var int
	 */
	private $downloadCount;

	/**
	 * Dohvaca broj preuzimanja lektire
	 *
	 * @return int
	 */
	public function GetDownloadCount(){
		return $this->downloadCount;
	}


	/**
	 * Postavlja broj preuzimanja lektire
	 *
	 * @param int $readingDownloadCount - broj preuzimanja lektire
	 */
	public function SetDownloadCount($readingDownloadCount){
		$this->downloadCount = $readingDownloadCount;
	}


	/**
	 * Konstruktor
	 *
	 * @param String $readingFileName - naziv datoteke lektire
	 */
	public function __construct($readingFileName){
		$this->fileName = $readingFileName;

		$this->id = 0;
		$this->dateTimeAdded = 0;
		$this->downloadCount = 0;
	}


	/**
	 * Povecava za jedan broj preuzimanja datoteke
	 *
	 */
	public function IncrementDownloadCount(){
		$this->downloadCount++;
	}

}

?>