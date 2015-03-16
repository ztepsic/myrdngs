<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("bobjects/reading.php");
require_once(LIBPATH . SYSPATH . "models/IOrmModel.php");

class Readings_model extends Model implements IOrmModel {

	/**
	 * Konstruktor
	 *
	 */
	public function __construct(){
		parent::Model();

	}

	// ##################################
	// ###### READINGS ##### BEGIN ######
	// ##################################

	/**
	 * Stvara Reading objekt na temelju rezultata upita
	 *
	 * @param std_class $queryRow - jedna n-torka upita
	 * @return Reading
	 */
	public function CreateObject($queryRow, $includes = null){
		if(!empty($queryRow)){
			$reading = new Reading($queryRow->reading_file_name);
			$reading->SetId($queryRow->reading_id);
			$reading->SetDateTimeAdded($queryRow->reading_datetime_added);
			$reading->SetReadingAuthorName($queryRow->reading_author_name);
			$reading->SetReadingAuthorWebsite($queryRow->reading_author_website);
			$reading->SetReadingAuthorInfo($queryRow->reading_author_info);
			$reading->SetReadingAuthorEmail($queryRow->reading_author_email);
			$reading->SetDownloadCount($queryRow->reading_download_count);

			return $reading;
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
			$readings = array();
			foreach ($queryResult as $queryRow){
				$readings[] = $this->CreateObject($queryRow);
			}

			return $readings;
		} else {
			return array();
		}

	}

	/**
	 * Dohvaca lektire za zadanu knjigu
	 *
	 * @param int $bookId - identifikator knjige
	 * @return Reading array - polje lektira
	 */
	public function GetReadings($bookId){
		$query = "
			SELECT
				*
			FROM
				zt_readings
			WHERE
				book_id = ?
			ORDER BY
				reading_file_name ASC

		";

		$readingQueryResult = $this->db->query($query, $bookId)->result();
		return $this->CreateObjectArray($readingQueryResult);
	}


	/**
	 * Dohvaca lektiru za njezin identifikator
	 *
	 * @param int $readingId - identifikator lektire
	 * @return Reading
	 */
	public function GetReading($readingId){
		$query = "
			SELECT
				*
			FROM
				zt_readings
			WHERE
				reading_id = ?
			LIMIT 1
		";

		$readingQueryRow = $this->db->query($query, $readingId)->row();
		return $this->CreateObject($readingQueryRow);

	}

	/**
	 * Povecava za jedan broj skidanja lektire
	 *
	 * @param int $readingId - identifikator lektire
	 * @return int - broj zahvacenih redataka
	 */
	public function IncrementReadingDownload($readingId){
		$query = "
			UPDATE
				zt_readings
			SET
				reading_download_count = reading_download_count + 1
			WHERE
				zt_readings.reading_id = ?
			LIMIT 1 ;
		";

		return $this->db->query($query, $readingId);
	}



	// #################################
	// ###### READINGS ##### END #######
	// #################################
}

?>