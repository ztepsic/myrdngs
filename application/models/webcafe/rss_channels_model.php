<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("bobjects/ZtRssChannel.php");
require_once (LIBPATH . SYSPATH . "rss/bobjects/RssChannel.php");
require_once(LIBPATH . SYSPATH . "models/IOrmModel.php");

class Rss_channels_model extends Model implements IOrmModel {

	/**
	 * Konstruktor
	 *
	 */
	public function __construct(){
		parent::Model();

		$this->load->model("webcafe/rss_channel_categories_model", "rssChannelCategoriesModel");
		$this->load->model("webcafe/rss_channel_items_model", "rssChannelItemsModel");
	}

	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################

	/**
	 * Stvara ZtRssChannel objekt na temelju rezultata upita
	 *
	 * @param std_class $queryRow - jedna n-torka upita
	 * @return ZtRssChannel
	 */
	public function CreateObject($queryRow, $includes = null){
		if(!empty($queryRow)){
			$ztRssChannel = new ZtRssChannel();
			
			$ztRssChannel->SetId($queryRow->rss_channel_id);
			$ztRssChannel->SetTitle($queryRow->rss_channel_name);
			$ztRssChannel->SetTtl($queryRow->rss_channel_ttl);
			$ztRssChannel->SetDescription($queryRow->rss_channel_description);
			$ztRssChannel->SetSourceUrl($queryRow->rss_channel_url);
			$ztRssChannel->SetLatestDownload($queryRow->rss_channel_latest_download);
			
			$rssChannelCategory = $this->rssChannelCategoriesModel->GetRssChannelCategory($queryRow->rss_channel_category_id);
			$ztRssChannel->SetCategory($rssChannelCategory);

			return $ztRssChannel;
		} else {
			return null;
		}

	}

	/**
	 * Stvara polje ZtRssChannel objekata na temelju rezultata upita
	 *
	 * @param std_class $queryResult - rezultati upita, vise n-torki
	 * @return array<ZtRssChannel> - polje rss kanala
	 */
	public function CreateObjectArray($queryResult, $includes = null){
		if(!empty($queryResult)){
			$ztRssChannels = array();
			foreach ($queryResult as $queryRow){
				$ztRssChannels[] = $this->CreateObject($queryRow);
			}


			return $ztRssChannels;
		} else {
			return array();
		}

	}
	
	// ###############################
	// ###### FETCH ##### BEGIN ######
	// ###############################
	
	/**
	 * Dohvaca sve rss kanale
	 *
	 * @return array<ZtRssChannelCategory>y
	 */
	public function GetRssChannels(){
		$query = "
			SELECT
				*
			FROM
				zt_rss_channels
		";

		$rssChannelsQueryResult = $this->db->query($query)->result();

		return $this->CreateObjectArray($rssChannelsQueryResult);

	}


	/**
	 * Dohvaca rss kanale za zadanu kategoriju
	 *
	 * @param int $rssChannelCategoryId - identifikator kategorije kanala
	 * @return array<ZtRssChannelCategory>y
	 */
	public function GetRssChannelsByCategory($rssChannelCategoryId){
		$query = "
			SELECT
				*
			FROM
				zt_rss_channels
			WHERE
				rss_channel_category_id = ?
		";

		$rssChannelsQueryResult = $this->db->query($query, $rssChannelCategoryId)->result();

		return $this->CreateObjectArray($rssChannelsQueryResult);

	}



	// #############################
	// ###### FETCH ##### END ######
	// #############################
	
	// ################################
	// ###### UPDATE ##### BEGIN ######
	// ################################
	
	/**
	 * Azurira rss kanal
	 * @param $ztRssChannel - rss kanal
	 */
	public function Update(ZtRssChannel $ztRssChannel){
		$data = array(
			"rss_channel_name" => $ztRssChannel->GetTitle(),
			"rss_channel_description" => $ztRssChannel->GetDescription(),
			"rss_channel_latest_download" => date(DATE_W3C, time()),
			"rss_channel_ttl" => $ztRssChannel->GetTtl()
		);

		$this->db->where("rss_channel_id", $ztRssChannel->GetId());
		$this->db->update("zt_rss_channels", $data);
	}
	
	
	// ##############################
	// ###### UPDATE ##### END ######
	// ##############################
	
	
	public function RefreshRssData(ZtRssChannel $ztRssChannel){
		$this->db->trans_start();
		
		$this->Update($ztRssChannel);
		
		foreach($ztRssChannel->GetItems() as $ztRssItem){
			$this->rssChannelItemsModel->Insert($ztRssItem, $ztRssChannel->GetId());
		}
		
		$this->db->trans_complete(); 
	}



	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
}

?>