<?php

require_once(MODPATH . "lektire/bobjects/author.php");

class Pisci extends ZT_Controller {

	const PER_PAGE = 10;

	public function __construct() {
		parent::__construct();

		$this->load->model("lektire/authors_model", "authorsModel");
		$this->load->model("lektire/books_model", "booksModel");
		
		// $this->load->model("webcafe/rss_channel_categories_model", "rssChannelCategoriesModel");
		// $this->load->model("webcafe/rss_channels_model", "rssChannelsModel");
		// $this->load->model("webcafe/rss_channel_items_model", "rssChannelItemsModel");

		$this->load->library(PathManager::GetSystemPath("htmlComponents/letters_navigation/letters_navigation"), array("uri" => "pisci/slovo/", "show_num" => false, "title" => "Pisci"));

		$this->load->helper('text');
	}

	/**
	 * Prikaz svih pisaca
	 *
	 */
	public function Index() {
		$pageNumber = $this->uri->segment(3);
		$this->head_generator->SetHeadTitle(empty($pageNumber) ? "Pisci lektira" : "Pisci lektira - stranica " . $pageNumber);
		$this->head_generator->SetHeadDescription("Stranica sadrži popis svih pisaca lektira za osnovne i srednje škole.");
		$this->head_generator->AddHeadKeywords("popis");
		
		$mainTemplateData['downHeader'] = $this->load->view(PathManager::GetPackagePath("lektire", "m_search_form_view"), null, true);

		$contentTop = "";
		$contentTop .= $this->load->view('ads/adsense_leaderboard_view.php', null, true);
		$contentTop .= $this->letters_navigation->Render();

		$notificationData['notificationTitle'] = "Pošaljite nam vaše lektire";
		$notificationData['notificationText'] = 'Ukoliko imate kvalitetnu i dobru lektiru podijelite to sa drugima. Pomozite nam da povećamo zbirku lektira i tako pomognemo novim generacijama. Pošaljite lektiru na ovome <a href="' . site_url("lektire/upload") . '" title="Pošaljite lektiru">linku</a>.';
		$contentTop .= $this->load->view(PathManager::GetSharedPath("notification_message_view"), $notificationData, true);

		$mainTemplateData['contentTop'] = $contentTop;


		// ###### PAGINACIJA - BEGIN ######

		$this->load->library('pagination');

		$config['base_url'] = site_url("pisci");
		$config['page_path'] = "stranica";
		$config['total_rows'] = $this->authorsModel->CountAuthors();
		$config['per_page'] = self::PER_PAGE;
		$config['uri_segment'] = 3;

		$this->pagination->Initialize($config);

		$authorData['authors'] = $this->authorsModel->GetAuthors(self::PER_PAGE, $this->pagination->GetOffset());
		$authorData['pagination'] = $this->pagination->create_links();

		// ###### PAGINACIJA - END ######

		$mainColumnData['mainTitle'] = "Pisci lektira";
		$mainColumnData['mainContent'] = "";
		// $mainColumnData['mainContent'] .='<div class="float-left">';
		// $mainColumnData['mainContent'] .= $this->load->view('ads/adsense_mrect_list_view', null, true);
		// $mainColumnData['mainContent'] .='</div>';
		// $mainColumnData['mainContent'] .='<div class="float-left">';
		// $mainColumnData['mainContent'] .= $this->load->view('ads/adsense_mrect_list_view', null, true);
		// $mainColumnData['mainContent'] .='</div><div class="clear"></div>';
		$mainColumnData['mainContent'] .= $this->load->view(PathManager::GetPackagePath("lektire", "c_authors_view"), $authorData, true);

		$templateData['contentLeft'] = $this->load->view(PathManager::GetSharedPath("main_column_view"), $mainColumnData, true);


		$templateData['contentRight'] = "";
		//$templateData['contentRight'] .= $this->load->view('ads/adsense_mrect_list_view', array("marginTopBottom" => 75), true);
		$templateData['contentRight'] .= $this->load->view('ads/adsense_mrect_list_view', null, true);
		$templateData['contentRight'] .= $this->load->view(PathManager::GetSharedPath("facebook/like_view"), null, true);
		$templateData['contentRight'] .= $this->load->view('ads/adsense_mrect_list_view', null, true);
		$templateData['contentRight'] .= $this->load->view(PathManager::GetSharedPath("facebook/activity_feed_view"), null, true);
		$templateData['contentRight'] .= $this->randomBanner();
		
		// $ztRssChannelCategory = $this->rssChannelCategoriesModel->GetRandomRssChannelCategory();
		// $feedsBoxData["ztRssChannelCategory"] = $ztRssChannelCategory;
		// $feedsBoxData["ztRssChannelItems"] = $this->rssChannelItemsModel->GetRssChannelItemsByCategory($ztRssChannelCategory->GetId(), 10, 0);
		// $templateData['contentRight'] .= $this->load->view(PathManager::GetPackagePath("webcafe", "m_feeds_box_view"), $feedsBoxData, true);
		
		$mainTemplateData["template"] = $this->load->view(PathManager::GetSharedPath("template_84_view"), $templateData, true);

		$this->Render($mainTemplateData);


	}

	/**
	 * Predstavlja stranicu sa piscem
	 *
	 * @param int $authorId - identifikator pisca
	 */
	public function Pisac($authorId = 0){
		if(!is_numeric($authorId) && empty($authorId)){
			show_404();
		}

		$author = $this->authorsModel->GetAuthor($authorId);

		if(empty($author)){
			show_404();
		}
		
		$this->head_generator->SetHeadTitle($author->GetFullName() . " - Pisac");
		$this->head_generator->SetHeadDescription(word_limiter(strip_tags($author->GetInfo()), 50));
		$this->head_generator->AddHeadKeyword($author->GetFullName());
		
		$this->head_generator->AddHeadMetaTag(new Meta(Meta::TYPE_NAME, "medium", "news"));
		$this->head_generator->AddHeadMetaTag(new Meta("property", "og:title", $author->GetFullName() . " - Pisac"));
		$this->head_generator->AddHeadMetaTag(new Meta("property", "og:site_name", $this->config->item("zt_site_title")));
		$this->head_generator->AddHeadMetaTag(new Meta("property", "og:image", static_url("img/logo_100x100.jpg")));
		
		$mainTemplateData['downHeader'] = $this->load->view(PathManager::GetPackagePath("lektire", "m_search_form_view"), null, true);

		$contentTop = "";
		$contentTop .= $this->load->view('ads/adsense_leaderboard_view.php', null, true);
		$contentTop .= $this->letters_navigation->Render();	
		
		$mainTemplateData['contentTop'] = $contentTop;
		
		$contentBottom = "";
		$mainTemplateData['contentBottom'] = $contentBottom;

		$mainColumnData['mainTitle'] = $author->GetFullName();
		$authorData['author'] = $author;
		$mainColumnData['mainContent'] = "";
		$authorData['ad'] = $this->load->view('ads/adsense_mrect_details_view', null, true);
		$authorBooks = $this->booksModel->GetBooksByAuthor($author->GetId());
		$authorData["authorBooksCount"] = count($authorBooks);
		$mainColumnData['mainContent'] .= $this->load->view(PathManager::GetPackagePath("lektire", "c_author_view"), $authorData, true);

		$booksData['books'] = $authorBooks;
		$mainColumnData['mainContent'] .= $this->load->view(PathManager::GetPackagePath("lektire", "c_books_list_view"), $booksData, true);
		$mainColumnData["url"] = site_url("lektira/" . $author->GetId() . "/" . hr_url_title($author->GetFullName(), "dash", true));

		$templateData['contentLeft'] = $this->load->view(PathManager::GetSharedPath("main_column_view"), $mainColumnData, true);

		$templateData['contentRight'] = "";
		$templateData['contentRight'] .= $this->randomBanner();
		$templateData['contentRight'] .= $this->load->view(PathManager::GetSharedPath("facebook/activity_feed_view"), null, true);
		$templateData['contentRight'] .= $this->load->view(PathManager::GetSharedPath("facebook/like_view"), null, true);
		$templateData['contentRight'] .= $this->load->view('ads/adsense_widesky_details_view', null, true);
		
		// $ztRssChannelCategory = $this->rssChannelCategoriesModel->GetRandomRssChannelCategory();
		// $feedsBoxData["ztRssChannelCategory"] = $ztRssChannelCategory;
		// $feedsBoxData["ztRssChannelItems"] = $this->rssChannelItemsModel->GetRssChannelItemsByCategory($ztRssChannelCategory->GetId(), 5, 0);
		// $templateData['contentRight'] .= $this->load->view(PathManager::GetPackagePath("webcafe", "m_feeds_box_view"), $feedsBoxData, true);
		
		$mainTemplateData["template"] = $this->load->view(PathManager::GetSharedPath("template_84_view"), $templateData, true);

		$this->Render($mainTemplateData);

	}


	/**
	 * Prikaz svih pisaca cije prezime zapocinje zadanim slovom
	 *
	 * @param String $letter - pocetno slovo prezimena
	 */
	public function Slovo($uriLetter){
		$letterLenght = strlen($uriLetter);
		if($letterLenght <= 0 || $letterLenght > 3){
			show_404();
		}

		$letter = $this->letters_navigation->ConvertUriLetter($uriLetter);
		
		$pageNumber = $this->uri->segment(5);
		$this->head_generator->SetHeadTitle(empty($pageNumber) ? "Pisaci kojima prezimena započinju slovom - " . $letter : "Pisaci kojima prezimena započinju slovom - " . $letter . " - stranica " . $pageNumber);
		$this->head_generator->SetHeadDescription("Prikaz svih pisaca kojima prezimena započinju slovom - " . $letter);
		//$this->head->GetHeadModel()->AddKeyword($author->GetFullName());

		$mainTemplateData['downHeader'] = $this->load->view(PathManager::GetPackagePath("lektire", "m_search_form_view"), null, true);

		$contentTop = "";
		$contentTop .= $this->load->view('ads/adsense_leaderboard_view.php', null, true);
		$this->letters_navigation->SetActiveLetter($letter);
		$contentTop .= $this->letters_navigation->Render();

		$notificationData['notificationTitle'] = "Pošaljite nam vaše lektire";
		$notificationData['notificationText'] = 'Ukoliko imate kvalitetnu i dobru lektiru podijelite to sa drugima. Pomozite nam da povećamo zbirku lektira i tako pomognemo novim generacijama. Pošaljite lektiru na ovome <a href="' . site_url("lektire/upload") . '" title="Pošaljite lektiru">linku</a>.';
		$contentTop .= $this->load->view(PathManager::GetSharedPath("notification_message_view"), $notificationData, true);

		$mainTemplateData['contentTop'] = $contentTop;


		// ###### PAGINACIJA - BEGIN ######

		$this->load->library('pagination');

		$config['base_url'] = site_url('pisci/slovo/' . $uriLetter);
		$config['page_path'] = "stranica";
		$config['total_rows'] = $this->authorsModel->CountAuthors($letter);
		$config['per_page'] = self::PER_PAGE;
		$config['uri_segment'] = 5;

		$this->pagination->Initialize($config);

		$authorData['authors'] = $this->authorsModel->GetAuthorsByLetter($letter, self::PER_PAGE, $this->pagination->GetOffset());
		$authorData['pagination'] = $this->pagination->create_links();

		// ###### PAGINACIJA - END ######

		$mainColumnData['mainTitle'] = "Pisaci kojima prezimena započinju slovom - " . $letter;
		$mainColumnData['mainContent'] = "";
		// $mainColumnData['mainContent'] .='<div class="float-left">';
		// $mainColumnData['mainContent'] .= $this->load->view('ads/adsense_mrect_list_view', null, true);
		// $mainColumnData['mainContent'] .='</div>';
		// $mainColumnData['mainContent'] .='<div class="float-left">';
		// $mainColumnData['mainContent'] .= $this->load->view('ads/adsense_mrect_list_view', null, true);
		// $mainColumnData['mainContent'] .='</div><div class="clear"></div>';
		$mainColumnData['mainContent'] .= $this->load->view(PathManager::GetPackagePath("lektire", "c_authors_view"), $authorData, true);

		$templateData['contentLeft'] = $this->load->view(PathManager::GetSharedPath("main_column_view"), $mainColumnData, true);


		$templateData['contentRight'] = "";
//	if(sizeof($authorData["authors"]) > 5){
//			$templateData['contentRight'] .= $this->load->view('ads/adsense_mrect_list_view', array("marginTopBottom" => 75), true);
//			$templateData['contentRight'] .= $this->randomBanner();
//			$templateData['contentRight'] .= $this->load->view('ads/adsense_widesky_details_view', null, true);
//		} else {
//			$templateData['contentRight'] .= $this->load->view('ads/adsense_mrect_list_view', array("marginTopBottom" => 0), true);
//			$templateData['contentRight'] .= $this->randomBanner();
//			$templateData['contentRight'] .= $this->load->view('ads/adsense_mrect_list_view', array("marginTopBottom" => 0), true);
//		}
		
		$templateData['contentRight'] .= $this->load->view('ads/adsense_mrect_list_view', null, true);
		$templateData['contentRight'] .= $this->load->view(PathManager::GetSharedPath("facebook/like_view"), null, true);
		$templateData['contentRight'] .= $this->load->view('ads/adsense_mrect_list_view', null, true);
		$templateData['contentRight'] .= $this->load->view(PathManager::GetSharedPath("facebook/activity_feed_view"), null, true);
		$templateData['contentRight'] .= $this->randomBanner();
		
		// $ztRssChannelCategory = $this->rssChannelCategoriesModel->GetRandomRssChannelCategory();
		// $feedsBoxData["ztRssChannelCategory"] = $ztRssChannelCategory;
		// $feedsBoxData["ztRssChannelItems"] = $this->rssChannelItemsModel->GetRssChannelItemsByCategory($ztRssChannelCategory->GetId(), 10, 0);
		// $templateData['contentRight'] .= $this->load->view(PathManager::GetPackagePath("webcafe", "m_feeds_box_view"), $feedsBoxData, true);	
		
		$mainTemplateData["template"] = $this->load->view(PathManager::GetSharedPath("template_84_view"), $templateData, true);

		$this->Render($mainTemplateData);
	}
	
	
	private function randomBanner(){
		srand(time());
		$randval = rand(0, 1);
		
		return $randval < 0.5 ? '<a href="http://www.otkrij-igre.net/" title="Otkrij besplatne online igre" target="_blank"><img src="'. static_url("img/ads/igre_otkrij_net_300x250.jpg") . '" /></a>' : '<a href="http://www.tv-tube.tv/" title="TvTube - Watch free online TV" target="_blank"><img alt="TvTube - Watch free online TV" src="'. static_url("img/ads/tvtube_banner_300x250.jpg") . '" /></a>';
	}

}

?>