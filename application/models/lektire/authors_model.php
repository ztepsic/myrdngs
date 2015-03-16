<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("bobjects/author.php");
require_once(LIBPATH . SYSPATH . "models/IOrmModel.php");

class Authors_model extends Model implements IOrmModel {

	/**
	 * Konstruktor
	 *
	 */
	public function __construct(){
		parent::Model();

	}

	// ################################
	// ###### AUTHOR ##### BEGIN ######
	// ################################

	/**
	 * Stvara Author objekt na temelju rezultata upita
	 *
	 * @param std_class $queryRow - jedna n-torka upita
	 * @return Author
	 */
	public function CreateObject($queryRow, $includes = null){
		if(!empty($queryRow)){
			$author = new Author($queryRow->author_name, $queryRow->author_surname);
			$author->SetId($queryRow->author_id);
			$author->SetInfo($queryRow->author_info);
			$author->SetInfoUri($queryRow->author_info_uri);

			return $author;
		} else {
			return null;
		}

	}

	/**
	 * Stvara polje Author objekata na temelju rezultata upita
	 *
	 * @param std_class $queryResult - rezultati upita, vise n-torki
	 * @return Author array - polje autora
	 */
	public function CreateObjectArray($queryResult, $includes = null){
		if(!empty($queryResult)){
			$authors = array();
			foreach ($queryResult as $queryRow){
				$authors[] = $this->CreateObject($queryRow);
			}


			return $authors;
		} else {
			return array();
		}

	}

	/**
	 * Dohvaca ukupan broj pisaca
	 *
	 * @param String $letter - pocetno slovo prezimena pisca
	 * @return int broj pisaca
	 */
	public function CountAuthors($letter = null){
		if($letter == null){
			$query = "
				SELECT
					COUNT(*) AS count
				FROM
					zt_authors;
			";
		} else {
			$query = "
				SELECT
					COUNT(*) AS count
				FROM
					zt_authors
				WHERE
					author_surname_latin LIKE '" . mysql_real_escape_string($letter) . "%'
			";
		}


		return $this->db->query($query, $letter)->row()->count;
	}

	/**
	 * Dihvaca autora
	 *
	 * @param int $limit - maksimalni broj n-torki
	 * @param int $offset - pomak
	 * @return Author array
	 */
	public function GetAuthors($limit = 0, $offset = 0){
		$query = "
			SELECT
				*
			FROM
				zt_authors
			ORDER BY
				author_surname ASC
		";

		if(!empty($limit)){
			$query .= "LIMIT ?,? ";
			$auhorQueryResult = $this->db->query($query, array($offset, $limit))->result();
		} else {
			$auhorQueryResult= $this->db->query($query)->result();
		}

		return $this->CreateObjectArray($auhorQueryResult);

	}

	/**
	 * Dihvaca autora za kojima prezimena pocinju sa zadanim slovom
	 *
	 * @param String $letter - pocetno slovo prezimena
	 * @param int $limit - maksimalni broj n-torki
	 * @param int $offset - pomak
	 * @return Author array
	 */
	public function GetAuthorsByLetter($letter, $limit = 0, $offset = 0){
		$query = "
			SELECT
				*
			FROM
				zt_authors
			WHERE
				author_surname_latin LIKE '" . mysql_real_escape_string($letter) . "%'
			ORDER BY
				author_surname_latin ASC
		";

		if(!empty($limit)){
			$query .= "LIMIT ?,? ";
			$auhorQueryResult = $this->db->query($query, array($offset, $limit))->result();
		} else {
			$auhorQueryResult= $this->db->query($query)->result();
		}

		return $this->CreateObjectArray($auhorQueryResult);

	}


	/**
	 * Dohvaca autora za njegov identifikator
	 *
	 * @param int $authorId - identifikator autora
	 * @return Author
	 */
	public function GetAuthor($authorId){
		$query = "
			SELECT
				*
			FROM
				zt_authors
			WHERE
				author_id = ?
			LIMIT 1
		";

		$authorQueryRow = $this->db->query($query, $authorId)->row();
		return $this->createObject($authorQueryRow);

	}



	// ###############################
	// ###### AUTHOR ##### END #######
	// ###############################
}

?>