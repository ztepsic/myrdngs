<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (LIBPATH . SYSPATH . "rss/rss_reader.php");

class Zt_rss_reader extends Rss_reader {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################
	

	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################
	
	function __construct () {
		parent::__construct();
		
		$this->CI->load->model("webcafe/rss_channels_model", "rssChannelsModel");
		$this->CI->load->model("webcafe/rss_channel_items_model", "rssChannelItemsModel");
		
	}
	

	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
	

	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################
	
	public function ReadToDb($ztRssChannel){
		$rssChannel = $this->Read($ztRssChannel->GetSourceUrl());
		if(!empty($rssChannel)){
			$ztRssChannel->SetTtl($rssChannel->GetTtl());
			$ztRssChannel->SetTitle($rssChannel->GetTitle());
			$ztRssChannel->SetDescription($rssChannel->GetDescription());
			$ztRssChannel->SetItems($rssChannel->GetItems());
		
			$this->CI->rssChannelsModel->RefreshRssData($ztRssChannel);	
		}
		
	}
	
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################

}

?>