<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("bobjects/ZtRssChannelCategory.php");
require_once(LIBPATH . SYSPATH . "models/IOrmModel.php");

class Rss_channel_categories_model extends Model implements IOrmModel {

	/**
	 * Konstruktor
	 *
	 */
	public function __construct(){
		parent::Model();

	}

	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################

	/**
	 * Stvara RssChannelCategory objekt na temelju rezultata upita
	 *
	 * @param std_class $queryRow - jedna n-torka upita
	 * @return RssChannelCategory
	 */
	public function CreateObject($queryRow, $includes = null){
		if(!empty($queryRow)){
			$rssChannelCategory = new ZtRssChannelCategory(
				$queryRow->rss_channel_category_id,
				$queryRow->rss_channel_category_name,
				$queryRow->rss_channel_category_description);

			return $rssChannelCategory;
		} else {
			return null;
		}

	}

	/**
	 * Stvara polje RssChannelCategory objekata na temelju rezultata upita
	 *
	 * @param std_class $queryResult - rezultati upita, vise n-torki
	 * @return RssChannelCateogry array - polje kategorija rss kanala
	 */
	public function CreateObjectArray($queryResult, $includes = null){
		if(!empty($queryResult)){
			$rssChannelCategories = array();
			foreach ($queryResult as $queryRow){
				$rssChannelCategories[] = $this->CreateObject($queryRow);
			}


			return $rssChannelCategories;
		} else {
			return array();
		}

	}


	/**
	 * Dohvaca sve kategorije rss kanala
	 *
	 * @return RssChannelCategory array
	 */
	public function GetRssChannelCategories(){
		$query = "
			SELECT
				*
			FROM
				zt_rss_channel_categories
			ORDER BY
				rss_channel_category_name ASC
		";

		$rssChannelCategoryQueryResult= $this->db->query($query)->result();

		return $this->CreateObjectArray($rssChannelCategoryQueryResult);

	}


	/**
	 * Dohvaca kategoriju rss kanala, za njezin identifikator
	 *
	 * @param int $rssChannelCategoryId - identifikator kategorije rss kanala
	 * @return RssChannelCategory
	 */
	public function GetRssChannelCategory($rssChannelCategoryId){
		$query = "
			SELECT
				*
			FROM
				zt_rss_channel_categories
			WHERE
				rss_channel_category_id = ?
			LIMIT 1
		";

		$rssChannelCategoryQueryRow = $this->db->query($query, $rssChannelCategoryId)->row();
		return $this->CreateObject($rssChannelCategoryQueryRow);

	}

	/**
	 * Dohvaca random jednu kategoriju RSS kanala
	 *
	 * @return ZtRssChannelCategory
	 */
	public function GetRandomRssChannelCategory(){
		$query = "
			SELECT
				*
			FROM
				zt_rss_channel_categories
			ORDER BY RAND()
			LIMIT 1;
		";
		
		$rssChannelCategoryQueryResult = $this->db->query($query)->row();

		return $this->CreateObject($rssChannelCategoryQueryResult);
		
	}

	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
}

?>