<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (LIBPATH . SYSPATH . "rss/bobjects/RssChannelItem.php");
require_once("bobjects/ZtRssChannelItem.php");
require_once(LIBPATH . SYSPATH . "models/IOrmModel.php");

class Rss_channel_items_model extends Model implements IOrmModel {

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
	 * Stvara ZtRssChannelItem objekt na temelju rezultata upita
	 *
	 * @param std_class $queryRow - jedna n-torka upita
	 * @return ZtRssChannelItem
	 */
	public function CreateObject($queryRow, $includes = null){
		if(!empty($queryRow)){
			$ztRssChannelItem = new ZtRssChannelItem();
			
			$ztRssChannelItem->SetId($queryRow->rss_channel_item_id);
			$ztRssChannelItem->SetDescription($queryRow->rss_channel_item_description);
			$ztRssChannelItem->SetTitle($queryRow->rss_channel_item_title);
			$ztRssChannelItem->SetLink($queryRow->rss_channel_item_link);
			$ztRssChannelItem->SetPubDate($queryRow->rss_channel_item_pubdate);
			$ztRssChannelItem->SetGuid($queryRow->rss_channel_item_guid);
			$ztRssChannelItem->SetImage($queryRow->rss_channel_item_image);

			return $ztRssChannelItem;
		} else {
			return null;
		}

	}

	/**
	 * Stvara polje ZtRssChannelItem objekata na temelju rezultata upita
	 *
	 * @param std_class $queryResult - rezultati upita, vise n-torki
	 * @return ZtRssChannelItem array - polje elemenata rss kanala
	 */
	public function CreateObjectArray($queryResult, $includes = null){
		if(!empty($queryResult)){
			$ztRssChannelItems = array();
			foreach ($queryResult as $queryRow){
				$ztRssChannelItems[] = $this->CreateObject($queryRow);
			}

			return $ztRssChannelItems;
		} else {
			return array();
		}

	}

	// ###############################
	// ###### FETCH ##### BEGIN ######
	// ###############################


	/**
	 * Dohvaca element rss kanala za njegov identifikator
	 *
	 * @param int $ztRssChannelItemId - identifikator elementa rss kanala
	 * @return ZtRssChannelItem
	 */
	public function GetRssChannelItem($ztRssChannelItemId){
		$query = "
			SELECT
				*
			FROM
				zt_rss_channel_items
			WHERE
				rss_channel_item_id = ?
			LIMIT 1
		";

		$ztRssChannelItemQueryRow = $this->db->query($query, $ztRssChannelItemId)->row();
		return $this->CreateObject($ztRssChannelItemQueryRow);

	}
	
	
	/**
	 * Dohvaca elemente rss kanala za zadanu kategoriju
	 *
	 * @param int $rssChannelCateogryId - identifikator kategorije kanala
	 * @param int $limit - maksimalni broj n-torki
	 * @param int $offset - pomak
	 * @return array<ZtRssChannelItem>
	 */
	public function GetRssChannelItemsByCategory($rssChannelCateogryId, $limit = 0, $offset = 0){
		$query = "
				SELECT
					zt_rss_channel_items.*
				FROM
					zt_rss_channel_items,
					zt_rss_channels
				WHERE
					zt_rss_channel_items.rss_channel_id = zt_rss_channels.rss_channel_id AND
					rss_channel_category_id = ?
				ORDER BY
					rss_channel_item_pubdate DESC
		";

		if(!empty($limit)){
			$query .= "LIMIT ?,? ";
			$rssChannelItemsQueryResult = $this->db->query($query, array($rssChannelCateogryId, $offset, $limit))->result();
		} else {
			$rssChannelItemsQueryResult= $this->db->query($query)->result();
		}

		return $this->CreateObjectArray($rssChannelItemsQueryResult);

	}
	
	
	/**
	 * Dohvaca ukupan elemenata rss kanala
	 *
	 * @param int $rssChannelCateogryId - identifikator kategorije rss kanala
	 * @return int broj elemenata rss kanala
	 */
	public function CountRssChannelItems($rssChannelCateogryId = 0){
		if($rssChannelCateogryId === 0){
			$query = "
				SELECT
					COUNT(*) AS count
				FROM
					zt_rss_channel_items;
			";
			
			return $this->db->query($query)->row()->count;
		} else {
			$query = "
				SELECT
					COUNT(rss_channel_item_id) AS count
				FROM
					zt_rss_channel_items,
					zt_rss_channels
				WHERE
					zt_rss_channel_items.rss_channel_id = zt_rss_channels.rss_channel_id AND
					rss_channel_category_id = ?
			";
			
			return $this->db->query($query, $rssChannelCateogryId)->row()->count;
		}
	}
	
	/**
	 * Dohvaca zadani broj najnovijih elemenata
	 *
	 * @param $numberOfItems - broj elemenata
	 * @return array<ZtRssChannelcItem>
	 */
	public function GetLatestRssChannelItems($numberOfItems){
		$query = "
			SELECT
				*
			FROM
				zt_rss_channel_items
			ORDER BY
				rss_channel_item_pubdate DESC
			LIMIT ?;
		";
		
		$rssChannelItemsQueryResult = $this->db->query($query, $numberOfItems)->result();

		return $this->CreateObjectArray($rssChannelItemsQueryResult);
		
	}

	
	// #############################
	// ###### FETCH ##### END ######
	// #############################
	
	// ################################
	// ###### INSERT ##### BEGIN ######
	// ################################
	
	/**
	 * Umece novi zapis elementa rss kanala
	 * @param $rssChannelItem - element rss kanala
	 * @param $ztRssChannelId - identifikator rss kanala
	 */
	public function Insert(RssChannelItem $rssChannelItem, $ztRssChannelId){
		$query = "INSERT IGNORE INTO zt_rss_channel_items (
			rss_channel_id,
			rss_channel_item_title,
			rss_channel_item_link,
			rss_channel_item_description,
			rss_channel_item_guid,
			rss_channel_item_pubdate,
			rss_channel_item_image) VALUES (?, ?, ?, ?, ?, ?, ?)";
		
		$data = array(
			"rss_channel_id" => $ztRssChannelId,
			"rss_channel_item_title" => $rssChannelItem->GetTitle(),
			"rss_channel_item_link" => $rssChannelItem->GetLink(),
			"rss_channel_item_description" => $rssChannelItem->GetDescription(),
			"rss_channel_item_guid" => $rssChannelItem->GetGuid(),
			"rss_channel_item_pubdate" => date(DATE_W3C, $rssChannelItem->GetPubDate()),
			"rss_channel_item_image" => $rssChannelItem->GetEnclosure()->GetUrl()
		);
		
		$this->db->query($query, $data);
	}
	
	// ##############################
	// ###### INSERT ##### END ######
	// ##############################
	
	// ################################
	// ###### UPDATE ##### BEGIN ######
	// ################################
	
	
	// ##############################
	// ###### UPDATE ##### END ######
	// ##############################



	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
}

?>