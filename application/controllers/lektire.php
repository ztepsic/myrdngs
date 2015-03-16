<?php

require_once(MODPATH . "lektire/bobjects/book.php");
require_once(LIBPATH . SYSPATH . "htmlComponents/linkproxy/ILinkProxy.php");

class Lektire extends ZT_Controller implements ILinkProxy {

	const PER_PAGE = 10;

	public function __construct() {
		parent::__construct();

		$this->load->model("lektire/books_model", "booksModel");
		$this->load->model("lektire/readings_model", "readingModel");
		$this->load->model("lektire/reading_links_model", "readingLinksModel");
		
		//$this->load->model("webcafe/rss_channel_categories_model", "rssChannelCategoriesModel");
		//$this->load->model("webcafe/rss_channels_model", "rssChannelsModel");
		//$this->load->model("webcafe/rss_channel_items_model", "rssChannelItemsModel");

		$this->load->library(PathManager::GetSystemPath("htmlComponents/letters_navigation/letters_navigation"), array("uri" => "lektire/slovo/", "show_num" => true, "title" => "Lektire"));
		$this->load->library('form_validation');

		$this->load->helper('text');

	}

	public function Index() {
		$pageNumber = $this->uri->segment(3);
		$this->head_generator->SetHeadTitle(empty($pageNumber) ? "Lektire" : "Lektire - stranica " . $pageNumber);
		$this->head_generator->SetHeadDescription("Stranica sa popisom svih lektira za osnovne i srednje škole.");
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
		
		$config['base_url'] = site_url("lektire");
		$config['page_path'] = "stranica";
		$config['total_rows'] = $this->booksModel->CountBooks();
		$config['per_page'] = self::PER_PAGE;
		$config['uri_segment'] = 3;

		$this->pagination->Initialize($config);

		$booksData['books'] = $this->booksModel->GetBooks(self::PER_PAGE, $this->pagination->GetOffset());
		$booksData['pagination'] = $this->pagination->create_links();

		// ###### PAGINACIJA - END ######

		$mainColumnData['mainTitle'] = "Lektire";
		$mainColumnData['mainContent'] = "";
		// $mainColumnData['mainContent'] .='<div class="float-left">';
		// $mainColumnData['mainContent'] .= $this->load->view('ads/adsense_mrect_list_view', null, true);
		// $mainColumnData['mainContent'] .='</div>';
		// $mainColumnData['mainContent'] .='<div class="float-left">';
		// $mainColumnData['mainContent'] .= $this->load->view('ads/adsense_mrect_list_view', null, true);
		// $mainColumnData['mainContent'] .='</div><div class="clear"></div>';
		$mainColumnData['mainContent'] .= $this->load->view(PathManager::GetPackagePath("lektire", "c_books_list_view"), $booksData, true);

		$templateData['contentLeft'] = $this->load->view(PathManager::GetSharedPath("main_column_view"), $mainColumnData, true);

		$templateData['contentRight'] = "";
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
	 * Predstavlja stranicu sa lektirom
	 *
	 * @param int $bookId - identifikator knjige
	 */
	public function Lektira($bookId = 0){
 		if(!is_numeric($bookId) && empty($bookId)){
			show_404();
		}

		$book = $this->booksModel->GetBook($bookId);

		if($book == null){
			show_404();
		}
		
		//$this->checkReadingLinks($book);
		
		
		$title = $book->GetTitle();
		$author = $book->GetAuthor()->GetFullName();
		if(!empty($author)){
			$title .= " (" . $author . ")"; 
		}

		$this->head_generator->SetHeadTitle($title . " - Lektire");
		$this->head_generator->SetHeadDescription(word_limiter(strip_tags($book->GetDescription()), 50));
		$this->head_generator->AddHeadKeyword($book->GetTitle());
		$this->head_generator->AddHeadKeyword($book->GetAuthor()->GetFullName());
		
		$mainTemplateData['downHeader'] = $this->load->view(PathManager::GetPackagePath("lektire", "m_search_form_view"), null, true);
		
		$isLargeTextContent = false;
		if(strlen($book->GetDescription()) > 1000){
			$isLargeTextContent = true;
		}

		$contentTop = "";
		
		if(!$isLargeTextContent){
			$contentTop .= $this->load->view('ads/adsense_leaderboard_view.php', null, true);
		}
		
		$contentTop .= $this->letters_navigation->Render();
		
		$notificationData['notificationTitle'] = "Datoteke za navedenu lektiru definirane su u PDF formatu.";
		$notificationData['notificationText'] = 'Da bi ste ih otvorili/pročitali potrebno je posjedovati PDF čitač. Ukoliko ga nemate možete ga besplatno preuzeti <a href="http://get.adobe.com/reader/">ovdje</a>';
		$contentTop .= $this->load->view(PathManager::GetSharedPath("notification_message_view"), $notificationData, true);
		
		$likeButtonDataView["url"] = site_url("lektira/" . $book->GetId() . "/" . hr_url_title($book->GetTitle(), "dash", true));
		$contentTop .= $this->load->view(PathManager::GetSharedPath("facebook/like_button_view"), $likeButtonDataView, true);
		
		$mainTemplateData['contentTop'] = $contentTop;
		
		
		$contentBottom = "";
		if($isLargeTextContent){
			$contentBottom .= $this->load->view('ads/adsense_leaderboard_view.php', null, true);
		}
		$mainTemplateData['contentBottom'] = $contentBottom;

		$mainColumnData['mainTitle'] = $book->GetTitle();
		$bookData['book'] = $book;
		//$mainColumnData['mainContent'] = $this->load->view('author_view', $authorData, true);
		$bookData['ad'] = $this->load->view('ads/adsense_mrect_details_view', null, true);
		$mainColumnData['mainContent'] = $this->load->view(PathManager::GetPackagePath("lektire", "c_book_view"), $bookData, true);

		$templateData['contentLeft'] = $this->load->view(PathManager::GetSharedPath("main_column_view"), $mainColumnData, true);

		$templateData['contentRight'] = "";
		$templateData['contentRight'] .= $this->load->view(PathManager::GetPackagePath("lektire", "c_reading_links_view"), $bookData, true);
		$templateData['contentRight'] .= $this->load->view(PathManager::GetSharedPath("facebook/activity_feed_view"), null, true);
		$templateData['contentRight'] .= $this->load->view(PathManager::GetSharedPath("facebook/like_view"), null, true);
		
		$mainTemplateData["template"] = $this->load->view(PathManager::GetSharedPath("template_84_view"), $templateData, true);

		$this->Render($mainTemplateData);

	}


	/**
	 * Prikaz svih knjiga/lektira ciji naslov pocinje zadanim slovom
	 *
	 * @param String $letter - pocetno slovo naslova knjiga/lektira
	 */
	public function Slovo($uriLetter){
		$letterLenght = strlen($uriLetter);
		if($letterLenght <= 0 || $letterLenght > 3){
			show_404();
		}

		$letter = $this->letters_navigation->ConvertUriLetter($uriLetter);
		
		$pageNumber = $this->uri->segment(5);
		$this->head_generator->SetHeadTitle(empty($pageNumber) ? "Lektire kojima naziv započinje slovom - " . $letter : "Lektire kojima naziv započinje slovom - " . $letter . " - stranica " . $pageNumber);
		$this->head_generator->SetHeadDescription("Prikaz svih lektira kojima naziv započinje slovom - " . $letter);

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

		$config['base_url'] = site_url("lektire/slovo/" . $uriLetter);
		$config['page_path'] = "stranica";
		$config['total_rows'] = $this->booksModel->CountBooks($letter);
		$config['per_page'] = self::PER_PAGE;
		$config['uri_segment'] = 5;
		
		$this->pagination->Initialize($config);

		$booksData['books'] = $this->booksModel->GetBooksByLetter($letter, Lektire::PER_PAGE, $this->pagination->GetOffset());
		$booksData['pagination'] = $this->pagination->create_links();

		// ###### PAGINACIJA - END ######

		$mainColumnData['mainTitle'] = "Lektire kojima naziv započinje slovom - " . $letter;
		$mainColumnData['mainContent'] = "";
		// $mainColumnData['mainContent'] .='<div class="float-left">';
		// $mainColumnData['mainContent'] .= $this->load->view('ads/adsense_mrect_list_view', null, true);
		// $mainColumnData['mainContent'] .='</div>';
		// $mainColumnData['mainContent'] .='<div class="float-left">';
		// $mainColumnData['mainContent'] .= $this->load->view('ads/adsense_mrect_list_view', null, true);
		// $mainColumnData['mainContent'] .='</div><div class="clear"></div>';
		$mainColumnData['mainContent'] .= $this->load->view(PathManager::GetPackagePath("lektire", "c_books_list_view"), $booksData, true);

		$templateData['contentLeft'] = $this->load->view(PathManager::GetSharedPath("main_column_view"), $mainColumnData, true);


		$templateData['contentRight'] = "";
//		if(sizeof($booksData["books"]) > 5){
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

	
	public function Download($readingId = 0){
		if(!is_numeric($readingId) && empty($readingId)){
			show_404();
		}

		$reading = $this->readingModel->GetReading($readingId);

		if(empty($reading)){
			show_404();
		}
		
			
		$jsCode = '
			$(document).ready(function () {
				setTimeout("switchAdToDownloadLink()", 5000);
			});

			function switchAdToDownloadLink(){
		 		$("#ad").attr("style", "display: none");
				$("#ff").attr("style", "display: block");
			}';

		$book = $this->booksModel->GetBookByReading($reading->GetId());
		$this->head_generator->SetHeadTitle($book->GetTitle() . " (" . $book->GetAuthor()->GetFullName() . ") - DOWNLOAD lektire - " . $reading->GetFileName());
		$this->head_generator->SetHeadDescription("Stranica za download lektire " . $book->GetTitle() . " - " . $book->GetAuthor()->GetFullName() . " - " . $reading->GetFileName());
		$this->head_generator->AddHeadKeyword("preuzimanje");
		$this->head_generator->AddHeadKeyword($book->GetTitle());
		$this->head_generator->AddHeadKeyword($book->GetAuthor()->GetFullName());
		$this->head_generator->AddHeadScript(new Script(null, $jsCode));
	
		$mainTemplateData['downHeader'] = $this->load->view(PathManager::GetPackagePath("lektire", "m_search_form_view"), null, true);

		$contentTop = "";
		$contentTop .= $this->letters_navigation->Render();

		$notificationData['notificationTitle'] = "Pošaljite nam vaše lektire";
		$notificationData['notificationText'] = 'Ukoliko imate kvalitetnu i dobru lektiru podijelite to sa drugima. Pomozite nam da povećamo zbirku lektira i tako pomognemo novim generacijama. Pošaljite lektiru na ovome <a href="' . site_url("lektire/upload") . '" title="Pošaljite lektiru">linku</a>.';
		$contentTop .= $this->load->view(PathManager::GetSharedPath("notification_message_view"), $notificationData, true);

		$mainTemplateData['contentTop'] = $contentTop;


		$mainColumnData['mainTitle'] = "Download lektire: " .  $book->GetTitle() . " - " . $book->GetAuthor()->GetFullName();
		$downloadData["reading"] = $reading;
		$downloadData["book"] = $book;
		
		$downloadData["ads"] = '';
		$downloadData["ads"] .= '<div class="float-left">';
		$downloadData["ads"] .= $this->load->view('ads/adsense_mrect_details_view', null, true);
		$downloadData["ads"] .= '</div>';
		$downloadData["ads"] .= '<div class="float-left">';
		$downloadData["ads"] .= $this->load->view('ads/adsense_mrect_details_view', null, true);
		$downloadData["ads"] .= '</div>';
		$downloadData["largeRectangleAd"] = $this->load->view('ads/adsense_lrect_download_view', null, true);
		$mainColumnData['mainContent'] = $this->load->view(PathManager::GetPackagePath("lektire", "c_reading_download_view"), $downloadData, true);

		$templateData['contentLeft'] = $this->load->view(PathManager::GetSharedPath("main_column_view"), $mainColumnData, true);


		$templateData['contentRight'] = "";
		$templateData['contentRight'] .= $this->load->view(PathManager::GetPackagePath("lektire", "c_reading_links_view"), array("book" => $book), true);
		$templateData['contentRight'] .= $this->load->view(PathManager::GetSharedPath("facebook/activity_feed_view"), null, true);
		$templateData['contentRight'] .= $this->load->view(PathManager::GetSharedPath("facebook/like_view"), null, true);
		//$templateData['contentRight'] .=  $this->randomBanner();
		
		$mainTemplateData["template"] = $this->load->view(PathManager::GetSharedPath("template_84_view"), $templateData, true);

		$this->Render($mainTemplateData);
	}

	
		
	/**
	 * Preuzimanje datoteke za lektiru
	 *
	 * @param int $readingId
	 */
	public function Datoteka($readingId = 0){
		if(!is_numeric($readingId) && empty($readingId)){
			show_404();
		}

		$reading = $this->readingModel->GetReading($readingId);

		if(empty($reading)){
			show_404();
		}

		$this->load->helper('download');

		$data = @file_get_contents("readings_repo/" . $readingId . "/" . $reading->GetFileName());
		if($data){
			$this->readingModel->IncrementReadingDownload($readingId);
			force_download($reading->GetFileName(), $data);
		} else {
			show_error("Datoteka " . $reading->GetFileName() . " ne postoji.");
		}
	}


	public function Poveznica($readingLinkId = 0){
		if(empty($readingLinkId)){
			show_404();
		}
		
		$readingLink = $this->readingLinksModel->GetReadingLink($readingLinkId);
		
		if(empty($readingLink)){
			show_404();
		}
		
		$book = $this->booksModel->GetBook($readingLink->GetBookId());
		
		$title = $book->GetTitle();
		$author = $book->GetAuthor()->GetFullName();
		if(!empty($author)){
			$title .= " (" . $author . ")"; 
		}
		
		$this->head_generator->SetHeadTitle($title . " - Lektire -- " . $readingLink->GetHost());
		$this->head_generator->SetHeadDescription("Sadržaj lektire " . $book->GetTitle() . ", autora " . $book->GetAuthor()->GetFullName(). ", sa stranice " . $readingLink->GetHost() . ". " . word_limiter(strip_tags($book->GetDescription()), 50));
		$this->head_generator->AddHeadKeyword($book->GetTitle());
		$this->head_generator->AddHeadKeyword($book->GetAuthor()->GetFullName());
		$this->head_generator->AddHeadKeyword($readingLink->GetHost());
		
		$params = array(
			"url" => $readingLink->GetUrl(),
			"controllerName" => "lektire",
			"head" => $this->head_generator->Render(), 
			"genericId" => $book->GetId(),
			"noFrames" => word_limiter(strip_tags($book->GetDescription()), 50),
			"headerRows" => 105
		);
		
		$this->load->library(PathManager::GetSystemPath("htmlComponents/linkproxy/link_proxy"), $params);
		
		echo $this->link_proxy->Render();
	}
	
	/**
	 * Generiranje stranice za header poveznice
	 * @param int $id - identifikator knjige
	 * @return unknown_type
	 */
	public function Header($id = 0){
		if($id > 0 ){
			$book = $this->booksModel->GetBook($id);
			
			if(empty($book)){
				show_404();
			}
		
			$this->head_generator->SetHeadTitle("Lektira - " . $book->GetTitle() . " - " . $book->GetAuthor()->GetFullName());
			$this->head_generator->SetHeadDescription("Poveznica na lektiru " . $book->GetTitle() . ", autora " . $book->GetAuthor()->GetFullName() . ". " . word_limiter(strip_tags($book->GetDescription()), 50));
			$this->head_generator->AddHeadKeyword($book->GetTitle());
			$this->head_generator->AddHeadKeyword($book->GetAuthor()->GetFullName());
			$headerData['head'] = $this->head_generator->Render();
			
			//$headerData["content"] = $book->GetDescription();
			
			$bookPage = array("lektira", $book->GetId(), hr_url_title($book->GetTitle(), "dash", true));
			
			$headerData["links"] = array(
				"Povratak na lektire" => site_url($bookPage),
				"Moje lektire" => base_url(),
				"Otkrij igre" => "www.otkrij-igre.net"
			);
			
		} else {
			show_404();	
		}
		
		
		$headerData['ad'] = $this->load->view('ads/adsense_proxy_leaderboard_view.php', null, true);
		
		$this->load->view(PathManager::GetSharedPath("linkproxy/header"), $headerData);
	}
	
	private function randomBanner(){
		srand(time());
		$randval = rand(0, 1);
		
		return $randval < 0.5 ? '<a href="http://www.otkrij-igre.net/" title="Otkrij besplatne online igre" target="_blank"><img src="'. static_url("img/ads/igre_otkrij_net_300x250.jpg") . '" /></a>' : '<a href="http://www.tv-tube.net/" title="TvTube - Watch free online TV" target="_blank"><img alt="TvTube - Watch free online TV" src="'. static_url("img/ads/tvtube_banner_300x250.jpg") . '" /></a>';
	}
	
	
	/**
	 * Validacija lektire
	 *
	 * @return boolean - true ako je uspjesno, inace false
	 */
	private function readingUploadDataValidation(){
		$this->form_validation->set_rules('reading_title', 'Naziv lektire', 'trim|required|xss');
		$this->form_validation->set_rules('reading_author', 'Pisac lektire', 'trim|required|xss');
		$this->form_validation->set_rules('uploader_full_name', 'Ime i prezime', 'trim|required|xss');
		$this->form_validation->set_rules('uploader_email', 'Email adresa', 'trim|required|valid_email|xss');
		$this->form_validation->set_rules('uploader_website', 'Web adresa', 'trim|xss');
		$this->form_validation->set_rules('uploader_info', 'Razred i škola', 'trim|xss');

		$isSuccessValidation = $this->form_validation->run();

		if ($isSuccessValidation) {
			$isSuccessUpload = $this->readingUpload();
			if($isSuccessUpload){
				return true;
			} else {
				return false;
			}

		} else {
			return false;
		}
	}

	/**
	 * Ucitavanje datoteke
	 *
	 * @return boolean - true ako je uspjesno, inace false
	 */
	private function readingUpload(){
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'doc|docx|pdf|zip|rar';
		$config['encrypt_name'] = true;

		$this->load->library('upload', $config);

		$isSuccess = $this->upload->do_upload("reading_file");
		if($isSuccess){
			$this->session->set_flashdata('reading_upload_success', "Slanje lektire je uspješno obavljeno. Zahvaljujemo se na slanju lektire.");

			$uploadData = $this->upload->data();
			$this->load->helper('file');
			$text = date("Y-m-d, H:i", time()) . " -- " .
			$this->input->post("uploader_full_name") . ", " .
			$this->input->post("uploader_email") . ", " .
			$this->input->post("uploader_website") . ", " .
			$this->input->post("uploader_info") . 
			" -- " . $this->input->post("reading_title") . ", " . $this->input->post("reading_author") . " -- " . $uploadData['file_name'] .
			"\n";
			write_file('uploads.txt', $text, "a+");
			
			$this->load->library('email');
			$this->email->to("info@moje-lektire.com");
    		$this->email->from($this->input->post("uploader_email"), $this->input->post("uploader_full_name"));
    		$this->email->subject("[moje-lektire.com] Upload lektire - " . $this->input->post("reading_author") . ": " . $this->input->post("reading_title"));
    		$this->email->message($text);
    		$this->email->send();

			return true;
		} else {
			$this->session->set_flashdata('reading_upload_error', $this->upload->display_errors());
			return  false;
		}


	}

	/**
	 * Ucitavanje lektire
	 *
	 */
	public function Upload(){
		$isValidData = $this->readingUploadDataValidation();
		if($isValidData){
				redirect('lektire/upload');
		} else {
			$this->head_generator->SetHeadTitle("Pošalji lektiru");
			$this->head_generator->SetHeadDescription("Stranica za slanje vaših školskih lektira sa svrhom pomoći ostalim korisnicima portala.");
			$this->head_generator->AddHeadKeywords("upload, slanje, učitavanje");
			
			$mainTemplateData['downHeader'] = $this->load->view(PathManager::GetPackagePath("lektire", "m_search_form_view"), null, true);

			$contentTop = "";
			
			$contentTop .= $this->load->view('ads/adsense_leaderboard_view.php', null, true);

			$contentTop .= $this->letters_navigation->Render();

			if($this->session->flashdata('reading_upload_success')){
				$notificationData['notificationTitle'] = "Obavijest";
				$notificationData['notificationText'] = $this->session->flashdata('reading_upload_success');
				$contentTop .= $this->load->view(PathManager::GetSharedPath('notification_message_view'), $notificationData, true);
			} else if($this->session->flashdata('reading_upload_error')){
				$notificationData['notificationTitle'] = "Greška";
				$notificationData['notificationText'] = $this->session->flashdata('reading_upload_error');
				$contentTop .= $this->load->view(PathManager::GetSharedPath("notification_message_view"), $notificationData, true);
			}

			$mainTemplateData['contentTop'] = $contentTop;


			$mainColumnData['mainTitle'] = "Pošalji lektiru";
			$mainColumnData['mainContent'] = $this->load->view(PathManager::GetPackagePath("lektire", "c_upload_reading_view"), null, true);

			$templateData['contentLeft'] = $this->load->view(PathManager::GetSharedPath("main_column_view"), $mainColumnData, true);


			$templateData['contentRight'] = "";
			$adsenseMrectDetailsViewData["marginTopBottom"] = 0;
			$templateData['contentRight'] .= $this->load->view('ads/adsense_mrect_details_view', $adsenseMrectDetailsViewData, true);
			$templateData['contentRight'] .= $this->randomBanner();
			$templateData['contentRight'] .= $this->load->view('ads/adsense_mrect_details_view', $adsenseMrectDetailsViewData, true);
			
			// $ztRssChannelCategory = $this->rssChannelCategoriesModel->GetRandomRssChannelCategory();
			// $feedsBoxData["ztRssChannelCategory"] = $ztRssChannelCategory;
			// $feedsBoxData["ztRssChannelItems"] = $this->rssChannelItemsModel->GetRssChannelItemsByCategory($ztRssChannelCategory->GetId(), 5, 0);
			// $templateData['contentRight'] .= $this->load->view(PathManager::GetPackagePath("webcafe", "m_feeds_box_view"), $feedsBoxData, true);
			
			//$mainTemplateData['contentTop'] .= $this->load->view('ads/adsense_leaderboard_view.php', null, true);
			
			$mainTemplateData["template"] = $this->load->view(PathManager::GetSharedPath("template_84_view"), $templateData, true);

			$this->Render($mainTemplateData);

		}
		
	}
	
	/**
	 * Provjerava ispravnost linkova.
	 * Neispravne linkove zapisuje u datoteku
	 */
	private function checkReadingLinks($book){
		$this->load->helper('file');
		foreach ($book->GetReadingLinks() as $readingLink){
			if(!isValidUrlCurl($readingLink->GetUrl())){
				write_file("link_error.txt", date("d.m.Y", time()) . ", " . $readingLink->GetId() . "\n", "a");
			}
		}

	}
}

?>