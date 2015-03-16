<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("bobjects/ReadingLink.php");
require_once(LIBPATH . SYSPATH . "models/IOrmModel.php");

class Reading_links_model extends Model implements IOrmModel {

	/**
	 * Konstruktor
	 *
	 */
	public function __construct(){
		parent::Model();

	}

	// #######################################
	// ###### READING LINKS ##### BEGIN ######
	// #######################################

	/**
	 * Stvara ReadingLink objekt na temelju rezultata upita
	 *
	 * @param std_class $queryRow - jedna n-torka upita
	 * @return Reading
	 */
	public function CreateObject($queryRow, $includes = null){
		if(!empty($queryRow)){
			$readingLink = new ReadingLink($queryRow->reading_link_id, $queryRow->reading_link_url, $queryRow->book_id);
			
			return $readingLink;
		} else {
			return null;
		}

	}

	/**
	 * Stvara polje Reading objekata na temelju rezultata upita
	 *
	 * @param std_class $queryResult - rezultati upita, vise n-torki
	 * @return Reading array - polje lektira
	 */
	public function CreateObjectArray($queryResult, $includes = null){
		if(!empty($queryResult)){
			$readingLinks = array();
			foreach ($queryResult as $queryRow){
				$readingLinks[] = $this->CreateObject($queryRow);
			}

			return $readingLinks;
		} else {
			return array();
		}

	}
	
	/**
	 * Dohvaca sve linkoce
	 * @return ReadingLink array
	 */
	public function GetReadingLinks(){
		$query = "
			SELECT
				*
			FROM
				zt_reading_links
			ORDER BY
				reading_link_id
		";

		$readingLinkQueryResult = $this->db->query($query)->result();
		return $this->CreateObjectArray($readingLinkQueryResult);
	}

	/**
	 * Dohvaca linkove lektire za zadanu knjigu
	 *
	 * @param int $bookId - identifikator knjige
	 * @return ReadingLink array - polje linkova lektira
	 */
	public function GetReadingLinksByBook($bookId){
		$query = "
			SELECT
				*
			FROM
				zt_reading_links
			WHERE
				book_id = ?
		";

		$readingLinkQueryResult = $this->db->query($query, $bookId)->result();
		return $this->CreateObjectArray($readingLinkQueryResult);
	}


	/**
	 * Dohvaca link lektire za njezin identifikator
	 *
	 * @param int $readingLinkId - identifikator linka lektire
	 * @return ReadingLink
	 */
	public function GetReadingLink($readingLinkId){
		$query = "
			SELECT
				*
			FROM
				zt_reading_links
			WHERE
				reading_link_id = ?
			LIMIT 1
		";

		$readingLinkQueryRow = $this->db->query($query, $readingLinkId)->row();
		return $this->createObject($readingLinkQueryRow);

	}


	// #################################
	// ###### READINGS ##### END #######
	// #################################
}

?>