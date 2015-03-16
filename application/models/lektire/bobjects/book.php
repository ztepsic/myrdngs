<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Predstavlja knjigu
 *
 */
class Book {


	/**
	 * Identifikator knjige
	 *
	 * @var int
	 */
	private $id;

	/**
	 * Dohvaca identifikator knjige
	 *
	 * @return int
	 */
	public function GetId(){
		return $this->id;
	}

	/**
	 * Postavlja identifikator knjige
	 *
	 * @param int $bookId - identifikator knjige
	 */
	public function SetId($bookId){
		$this->id = $bookId;
	}


	/**
	 * Naziv knjige
	 *
	 * @var String
	 */
	private $title;

	/**
	 * Dohvaca naziv knjige
	 *
	 * @return unknown
	 */
	public function GetTitle(){
		return $this->title;
	}

	/**
	 * Postavlja naziv knjige
	 *
	 * @param String $bookTitle
	 */
	public function SetTitle($bookTitle){
		$this->title = $bookTitle;
	}


	/**
	 * Opis knjige
	 *
	 * @var String
	 */
	private $description;

	/**
	 * Dohvaca opis knjige
	 *
	 * @return String
	 */
	public function GetDescription(){
		return $this->description;
	}

	/**
	 * Postavlja opis knjige
	 *
	 * @param String $bookDescription - opis knjige
	 */
	public function SetDescription($bookDescription){
		$this->description = $bookDescription;
	}

	/**
	 * Autor knjige
	 *
	 * @var Author
	 */
	private $author;

	/**
	 * Dohvaca autora knjige
	 *
	 * @return Author
	 */
	public function GetAuthor(){
		return $this->author;
	}

	/**
	 * Postavlja autora knjige
	 *
	 * @param Author $bookAuthor - autor knjige
	 */
	public function SetAuthor(Author $bookAuthor){
		$this->author = $bookAuthor;
	}


	/**
	 * Lektire
	 *
	 * @var Reading array
	 */
	private $readings = array();

	/**
	 * Dohvaca polje lektira koje su vezane na ovu knjigu
	 *
	 * @return Reading array
	 */
	public function GetReadings(){
		return $this->readings;
	}

	/**
	 * Postavlja polje sa lektirama
	 *
	 * @param Reading array $bookReadings - polje sa lektirama
	 */
	public function SetReadings($bookReadings){
		$this->readings = $bookReadings;
	}
	
	
	/**
	 * Linkovi na online lektire
	 * 
	 * @var ReadingLink array
	 */
	private $readingLinks = array();
	
	/**
	 * Postavlja polje linkova
	 * 
	 * @param $links the $links to set
	 */
	public function SetReadingLinks ($links) {
		$this->links = $links;
	}

	/**
	 * Dohvaca polje linkova
	 * 
	 * @return the $links
	 */
	public function GetReadingLinks () {
		return $this->links;
	}
	
	


	/**
	 * Konstruktor
	 *
	 * @param String $bookTile - naziv knjige
	 * @param String $bookDescription - opis knjige
	 * @param Author $bookAuthor - autor knjige
	 */
	public function __construct($bookTile, $bookDescription, Author $bookAuthor){
		$this->title = $bookTile;
		$this->description = $bookDescription;
		$this->author = $bookAuthor;

		$this->id = 0;
	}


	/**
	 * Dodaje lektiru u polje lektira
	 *
	 * @param Reading $bookReading - lektira
	 */
	public function AddReading(Reading $bookReading){
		$this->readings[] = $bookReading;
	}
	
	/**
	 * Dodaje link u polje linkova
	 *
	 * @param ReadingLink $readingLink - link
	 */
	public function AddLink(ReadingLink $readingLink){
		$this->links = $readingLink;
	}

}

?>