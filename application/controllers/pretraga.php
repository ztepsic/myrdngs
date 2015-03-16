<?php

require_once(MODPATH . "lektire/bobjects/book.php");

class Pretraga extends ZT_Controller {

	const PER_PAGE = 10;

	public function __construct() {
		parent::__construct();

		$this->load->model("lektire/books_model", "booksModel");
		
		// $this->load->model("webcafe/rss_channel_categories_model", "rssChannelCategoriesModel");
		// $this->load->model("webcafe/rss_channels_model", "rssChannelsModel");
		// $this->load->model("webcafe/rss_channel_items_model", "rssChannelItemsModel");

		$this->load->library(PathManager::GetSystemPath("htmlComponents/letters_navigation/letters_navigation"), array("uri" => "lektire/slovo/", "show_num" => true, "title" => "Lektire"));

		$this->load->helper('text');
	}
	
	public function Index(){
		$searchQuery = "";
		if($this->input->get("q")){
			$searchQuery = $this->input->get("q");
		}

		$this->head_generator->SetHeadTitle($searchQuery);
		$this->head_generator->SetHeadDescription("Prikaz rezultata pretrage.");
		$this->head_generator->AddHeadKeywords("rezultati, pretraga");
		$this->head_generator->AddHeadMetaTag(new Meta(Meta::TYPE_NAME, "robots", "noindex"));
		
		$mainTemplateData['downHeader'] = $this->load->view(PathManager::GetPackagePath("lektire", "m_search_form_view"), null, true);

		$contentTop = "";
		$contentTop .= $this->load->view('ads/adsense_leaderboard_view.php', null, true);
		$contentTop .= $this->letters_navigation->Render();

		$notificationData['notificationTitle'] = "Pošaljite nam vaše lektire";
		$notificationData['notificationText'] = 'Ukoliko imate kvalitetnu i dobru lektiru podijelite to sa drugima. Pomozite nam da povećamo zbirku lektira i tako pomognemo novim generacijama. Pošaljite lektiru na ovome <a href="' . site_url("lektire/upload") . '" title="Pošaljite lektiru">linku</a>.';
		$contentTop .= $this->load->view(PathManager::GetSharedPath("notification_message_view"), $notificationData, true);
		
		

		$mainTemplateData['contentTop'] = $contentTop;

		$mainColumnData['mainContent'] = $this->load->view(PathManager::GetPackagePath("pretraga", "c_google_search_view"), null, true);	
		$templateData['contentLeft'] = $this->load->view(PathManager::GetSharedPath("main_column_view"), $mainColumnData, true);


		$templateData['contentRight'] = "";
		$templateData['contentRight'] .= $this->load->view('ads/adsense_mrect_list_view', array("marginTopBottom" => 0), true);
		$templateData['contentRight'] .= $this->randomBanner();
		$templateData['contentRight'] .= $this->load->view('ads/adsense_widesky_details_view', null, true);
		
		$mainTemplateData["template"] = $this->load->view(PathManager::GetSharedPath("template_84_view"), $templateData, true);

		$this->Render($mainTemplateData);
	}

	private function Index_OLD() {
		$author = null;
		$bookName = null;

		if($this->input->get("author")){
			$author = $this->input->get("author");
		}

		if($this->input->get("book-name")){
			$bookName = $this->input->get("book-name");
		}

		if($author == null && $bookName == null){
			redirect("");
		}
		
		$searchTitle = "Pretraživanje lektira za: ";
		if($author != null){
			$searchTitle .= "Autor: " . $author;
		}

		if($bookName != null){
			if($author != null){
				$searchTitle .= ", ";
			}
			$searchTitle .= "Naziv djela: " . $bookName;
		}

		
		$this->head_generator->SetHeadTitle($searchTitle);
		$this->head_generator->SetHeadDescription("Prikaz rezultata pretrage vezane uz ime i prezime pisca, te naziv lektire.");
		$this->head_generator->AddHeadKeywords("rezultati, pretraga");
		$this->head_generator->AddHeadMetaTag(new Meta(Meta::TYPE_NAME, "robots", "noindex"));
		
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

		$config['base_url'] = site_url("pretraga");
		$config['page_path'] = "stranica";
		$config['total_rows'] = $this->booksModel->CountSearchBooks($author, $bookName);
		$config['per_page'] = Pretraga::PER_PAGE;
		$config['uri_segment'] = 3;

		$this->paginationInit(&$config);
		$this->pagination->Initialize($config);

		$booksData['books'] = $this->booksModel->SearchBooks($author, $bookName, Pretraga::PER_PAGE, $this->pagination->GetOffset());
		$booksData['pagination'] = $this->pagination->create_links();

		// ###### PAGINACIJA - END ######

		$mainColumnData['mainTitle'] = $searchTitle;
		$mainColumnData['mainContent'] = "";
		// $mainColumnData['mainContent'] .='<div class="float-left">';
		// $mainColumnData['mainContent'] .= $this->load->view('ads/adsense_mrect_list_view', null, true);
		// $mainColumnData['mainContent'] .='</div>';
		// $mainColumnData['mainContent'] .='<div class="float-left">';
		// $mainColumnData['mainContent'] .= $this->load->view('ads/adsense_mrect_list_view', null, true);
		// $mainColumnData['mainContent'] .='</div><div class="clear"></div>';
		if($config['total_rows'] > 0){
			$mainColumnData['mainContent'] .= $this->load->view(PathManager::GetPackagePath("lektire", "c_books_list_view"), $booksData, true);	
		} else {
			$mainColumnData['mainContent'] .= "<p><strong>Nema rezultata za pretragu. Pokušajte sa drugim pojmom.</strong></p>";
		}
		

		$templateData['contentLeft'] = $this->load->view(PathManager::GetSharedPath("main_column_view"), $mainColumnData, true);


		$templateData['contentRight'] = "";
		$templateData['contentRight'] .= $this->load->view('ads/adsense_mrect_details_view', null, true);
		$templateData['contentRight'] .= $this->randomBanner();
		$templateData['contentRight'] .= $this->load->view('ads/adsense_mrect_details_view', null, true);
		
		// $ztRssChannelCategory = $this->rssChannelCategoriesModel->GetRandomRssChannelCategory();
		// $feedsBoxData["ztRssChannelCategory"] = $ztRssChannelCategory;
		// $feedsBoxData["ztRssChannelItems"] = $this->rssChannelItemsModel->GetRssChannelItemsByCategory($ztRssChannelCategory->GetId(), 5, 0);
		// $templateData['contentRight'] .= $this->load->view(PathManager::GetPackagePath("webcafe", "m_feeds_box_view"), $feedsBoxData, true);
		
		
		$mainTemplateData["template"] = $this->load->view(PathManager::GetSharedPath("template_84_view"), $templateData, true);

		$this->Render($mainTemplateData);


	}
	
	private function randomBanner(){
		srand(time());
		$randval = rand(0, 1);
		
		return $randval < 0.5 ? '<a href="http://www.otkrij-igre.net/" title="Otkrij besplatne online igre" target="_blank"><img src="'. static_url("img/ads/igre_otkrij_net_300x250.jpg") . '" /></a>' : '<a href="http://www.tv-tube.tv/" title="TvTube - Watch free online TV" target="_blank"><img alt="TvTube - Watch free online TV" src="'. static_url("img/ads/tvtube_banner_300x250.jpg") . '" /></a>';
	}

	/**
	 * Incijalizacija paginacije
	 *
	 * @param array $config
	 */
	private function paginationInit($config){
		$config['first_link'] = 'Prva';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';

		$config['last_link'] = 'Posljednja';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';

		$config['next_link'] = '&gt;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = '&lt;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="nota">';
		$config['cur_tag_close'] = '</li>';

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
	}
}

?>