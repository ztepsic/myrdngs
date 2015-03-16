<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("bobjects/book.php");
require_once(LIBPATH . SYSPATH . "models/IOrmModel.php");

class Books_model extends Model implements IOrmModel {

	/**
	 * Konstruktor
	 *
	 */
	public function __construct(){
		parent::Model();

		$this->load->model("lektire/authors_model", "authorsModel");
		$this->load->model("lektire/readings_model", "readingsModel");
		$this->load->model("lektire/reading_links_model", "readingLinksModel");

	}

	// ###############################
	// ###### BOOKS ##### BEGIN ######
	// ###############################

	/**
	 * Stvara Book objekt na temelju rezultata upita
	 *
	 * @param std_class $queryRow - jedna n-torka upita
	 * @return Book
	 */
	public function CreateObject($queryRow, $includes = null){
		if(!empty($queryRow)){
			$author = $this->authorsModel->GetAuthor($queryRow->author_id);
			if($author == null){
				$author = new Author(null, null);
			}

			$book = new Book($queryRow->book_name, $queryRow->book_description, $author);
			$book->SetId($queryRow->book_id);

			$readings = $this->readingsModel->GetReadings($book->GetId());
			$book->SetReadings($readings);
			
			$readingLinks = $this->readingLinksModel->GetReadingLinksByBook($book->GetId());
			$book->SetReadingLinks($readingLinks);

			return $book;

		} else {
			return null;
		}

	}

	/**
	 * Stvara polje Book objekata na temelju rezultata upita
	 *
	 * @param std_class $queryResult - rezultati upita, vise n-torki
	 * @return Book array - polje knjiga
	 */
	public function CreateObjectArray($queryResult, $includes = null){
		if(!empty($queryResult)){
			$books = array();
			foreach ($queryResult as $queryRow){
				$books[] = $this->CreateObject($queryRow);
			}

			return $books;
		} else {
			return array();
		}

	}

	/**
	 * Dohvaca knjige za zadanog autora
	 *
	 * @param int $authorId - identifikator autora
	 * @return Book array - polje knjiga
	 */
	public function GetBooksByAuthor($authorId){
		$query = "
			SELECT
				*
			FROM
				zt_books
			WHERE
				author_id = ?
			ORDER BY
				book_name_latin ASC
		";

		$bookQueryResult = $this->db->query($query, $authorId)->result();
		return $this->CreateObjectArray($bookQueryResult);

	}


	/**
	 * Dohvaca knjigu za njezin identifikator
	 *
	 * @param int $bookId - identifikator knjige
	 * @return Book
	 */
	public function GetBook($bookId){
		$query = "
			SELECT
				*
			FROM
				zt_books
			WHERE
				book_id = ?
			LIMIT 1
		";

		$bookQueryRow = $this->db->query($query, $bookId)->row();
		return $this->CreateObject($bookQueryRow);

	}
	
	/**
	 * Dohvaca knjigu za zadanu lektiru
	 *
	 * @param int $readingId - identifikator lektire
	 * @return Book
	 */
	public function GetBookByReading($readingId){
		$query = "
			SELECT
				*
			FROM
				zt_books,
				zt_readings
			WHERE
				reading_id = ? AND
				zt_books.book_id = zt_readings.book_id
			LIMIT 1
		";

		$bookQueryRow = $this->db->query($query, $readingId)->row();
		return $this->CreateObject($bookQueryRow);
	}

	/**
	 * Dohvaca ukupan broj knjiga
	 *
	 * @param String $letter - pocetno slovo imena knjige
	 * @return int broj knjiga
	 */
	public function CountBooks($letter = null){
		if($letter == null){
			$query = "
				SELECT
					COUNT(*) AS count
				FROM
					zt_books;
			";
		} else {
			$query = "
				SELECT
					COUNT(*) AS count
				FROM
					zt_books
				WHERE
					book_name_latin LIKE '" . mysql_real_escape_string($letter) . "%'
			";
		}


		return $this->db->query($query, $letter)->row()->count;
	}

	/**
	 * Dohvaca knjige
	 *
	 * @param int $limit - maksimalni broj n-torki
	 * @param int $offset - pomak
	 * @return Book array
	 */
	public function GetBooks($limit = 0, $offset = 0){
		$query = "
			SELECT
				*
			FROM
				zt_books
			ORDER BY
				book_name_latin ASC
		";

		if(!empty($limit)){
			$query .= "LIMIT ?,? ";
			$bookQueryResult = $this->db->query($query, array($offset, $limit))->result();
		} else {
			$bookQueryResult= $this->db->query($query)->result();
		}

		return $this->CreateObjectArray($bookQueryResult);

	}

	/**
	 * Dohvaca knjige kojima nazivi zapocinju zadanim slovom
	 *
	 * @param String $letter - pocetno slovo naslova
	 * @param int $limit - maksimalni broj n-torki
	 * @param int $offset - pomak
	 * @return Book array
	 */
	public function GetBooksByLetter($letter, $limit = 0, $offset = 0){
		if($letter == "0-9"){
			$query = "
				SELECT
					*
				FROM
					zt_books
				WHERE
					book_name REGEXP '^[0-9]+.*'
				ORDER BY
					book_name_latin ASC
			";
		} else {
			$query = "
				SELECT
					*
				FROM
					zt_books
				WHERE
					book_name_latin LIKE '" . mysql_real_escape_string($letter) . "%'
				ORDER BY
					book_name_latin ASC
			";

		}

		if(!empty($limit)){
			$query .= "LIMIT ?,? ";
			$bookQueryResult = $this->db->query($query, array($offset, $limit))->result();
		} else {
			$bookQueryResult= $this->db->query($query)->result();
		}

		return $this->CreateObjectArray($bookQueryResult);

	}

	/**
	 * Broji knjige koji ce se dohvatiti prema zadanim parametrima
	 *
	 * @param String $author - ime i prezime autora
	 * @param String $bookName - naziv knjige
	 * @return int - broj knjiga
	 */
	public function CountSearchBooks($author, $bookName){
		if($author != null && $bookName != null){
			$query = "
				SELECT
					COUNT(*) AS count
				FROM
					zt_books,
					zt_authors
				WHERE
					(CONCAT(author_name, ' ', author_surname) LIKE '%" . mysql_real_escape_string($author) . "%' OR
					CONCAT(author_surname, ' ', author_name) LIKE '%" . mysql_real_escape_string($author) . "%') AND
					zt_books.author_id = zt_authors.author_id AND
					zt_books.book_name LIKE '%" . mysql_real_escape_string($bookName) . "%'
				ORDER BY
					book_name_latin ASC
			";
		} else if($author != null && $bookName == null){
			$query = "
				SELECT
					COUNT(*) AS count
				FROM
					zt_books,
					zt_authors
				WHERE
					(CONCAT(author_name, ' ', author_surname) LIKE '%" . mysql_real_escape_string($author) . "%' OR
					CONCAT(author_surname, ' ', author_name) LIKE '%" . mysql_real_escape_string($author) . "%') AND
					zt_books.author_id = zt_authors.author_id
				ORDER BY
					book_name_latin ASC
			";
		} else if($author == null && $bookName != null){
			$query = "
				SELECT
					COUNT(*) AS count
				FROM
					zt_books
				WHERE
					book_name LIKE '%" . mysql_real_escape_string($bookName) . "%'
				ORDER BY
					book_name_latin ASC
			";
 		} else {
 			throw new Exception("Search database error");
 		}

 		if(!empty($limit)){
			$query .= "LIMIT ?,? ";
			$bookQueryResult = $this->db->query($query, array($offset, $limit))->row();
		} else {
			$bookQueryResult= $this->db->query($query)->row();
		}

		return $bookQueryResult->count;


	}


	/**
	 * Dohvaca knjige prema zadanim parametrima
	 *
	 * @param String $author - ime i prezime autora
	 * @param String $bookName - naziv knjige
	 * @param int $limit - maksimalni broj n-torki
	 * @param int $offset - pomak
	 * @return Book array
	 */
	public function SearchBooks($author, $bookName, $limit = 0, $offset = 0){
		if($author != null && $bookName != null){
			$query = "
				SELECT
					*
				FROM
					zt_books,
					zt_authors
				WHERE
					(CONCAT(author_name, ' ', author_surname) LIKE '%" . mysql_real_escape_string($author) . "%' OR
					CONCAT(author_surname, ' ', author_name) LIKE '%" . mysql_real_escape_string($author) . "%') AND
					zt_books.author_id = zt_authors.author_id AND
					zt_books.book_name LIKE '%" . mysql_real_escape_string($bookName) . "%'
				ORDER BY
					book_name_latin ASC
			";
		} else if($author != null && $bookName == null){
			$query = "
				SELECT
					*
				FROM
					zt_books,
					zt_authors
				WHERE
					(CONCAT(author_name, ' ', author_surname) LIKE '%" . mysql_real_escape_string($author) . "%' OR
					CONCAT(author_surname, ' ', author_name) LIKE '%" . mysql_real_escape_string($author) . "%') AND
					zt_books.author_id = zt_authors.author_id
				ORDER BY
					book_name_latin ASC
			";
		} else if($author == null && $bookName != null){
			$query = "
				SELECT
					*
				FROM
					zt_books
				WHERE
					book_name LIKE '%" . mysql_real_escape_string($bookName) . "%'
				ORDER BY
					book_name_latin ASC
			";
 		} else {
 			throw new Exception("Search database error");
 		}

 		if(!empty($limit)){
			$query .= "LIMIT ?,? ";
			$bookQueryResult = $this->db->query($query, array($offset, $limit))->result();
		} else {
			$bookQueryResult= $this->db->query($query)->result();
		}

		return $this->CreateObjectArray($bookQueryResult);


	}



	// ##############################
	// ###### BOOKS ##### END #######
	// ##############################
}

?>