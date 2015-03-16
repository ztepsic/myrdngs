<?php

class Naslovnica extends ZT_Controller  {

	public function __construct() {
		parent::__construct();

		$this->load->library(PathManager::GetSystemPath("htmlComponents/letters_navigation/letters_navigation"), array("uri" => "lektire/slovo/", "show_num" => true, "title" => "Lektire"));
		//$this->load->model("webcafe/rss_channel_items_model", "rssChannelItemsModel");
		
		$this->load->helper('text');
	}

	public function index() {
		$this->head_generator->SetHeadTitle("Lektire");
		$this->head_generator->SetHeadDescription('Portal "Moje lektire" sadrži zbirku besplatnih lektira za osnovne i srednje škole. Jako veliki izbor kvalitetnih lektira sa mogućnosti skidanja lektira i ostalim relevantnim linkovima za navedene lektire. Isto tako omogućen je upload vaših lektira kako bi povećeli bazu lektira i svima olakšali školske dane. Obavezno nas posjetite.');
		$this->head_generator->AddHeadMetaTag(new Meta("property", "fb:app_id", 206030906099655));
		
		$mainTemplateData['downHeader'] = $this->load->view(PathManager::GetPackagePath("lektire", "m_search_form_view"), null, true);

		$contentTop = "";
		
		$contentTop .= $this->load->view('ads/adsense_links728x15_5_home_view.php', null, true);
		$contentTop .= $this->load->view('ads/adsense_leaderboard_view.php', null, true);

		$notificationData['notificationTitle'] = "Moje lektire";
		$notificationData['notificationText'] = 'Portal &quot;Moje lektire&quot; sadrži zbirku besplatnih lektira za osnovne i srednje škole. Jako veliki izbor kvalitetnih lektira sa mogućnosti skidanja lektira i ostalim relevantnim linkovima za navedene lektire. Isto tako omogućen je upload vaših lektira kako bi povećeli bazu lektira i svima olakšali školske dane. Obavezno nas posjetite.';
		$contentTop .= $this->load->view(PathManager::GetSharedPath("notification_message_view"), $notificationData, true);
		$contentTop .= $this->load->view(PathManager::GetSharedPath("facebook/like_leaderboard_view"), null, true);

		$mainTemplateData['contentTop'] = $contentTop;
		
		//$feedsBoxData["ztRssChannelItems"] = $this->rssChannelItemsModel->GetLatestRssChannelItems(5);
		//$mainTemplateData['contentTop'] .= $this->load->view(PathManager::GetPackagePath("webcafe", "m_feeds_box_top_view"), $feedsBoxData, true); 

		$this->Render($mainTemplateData);

	}
}