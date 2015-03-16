<?php

class Informacije extends ZT_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->library('email');
		$this->load->helper('string');
		$this->load->helper('text');
		
		// $this->load->model("webcafe/rss_channel_categories_model", "rssChannelCategoriesModel");
		// $this->load->model("webcafe/rss_channels_model", "rssChannelsModel");
		// $this->load->model("webcafe/rss_channel_items_model", "rssChannelItemsModel");

		$this->load->library(PathManager::GetSystemPath("htmlComponents/letters_navigation/letters_navigation"), array("uri" => "lektire/slovo/", "show_num" => true, "title" => "Lektire"));

	}
	
	public function najcescapitanja(){
		$this->head_generator->SetHeadTitle("Najčešća pitanja");
		$this->head_generator->SetHeadDescription("Portal sa lektirama Moje Lektire odgovara na vaša najčešća pitanja. Na ovome mjestu možete pronaći većinu informacija vezanih uz lektire i korištenje portala.");
		$this->head_generator->AddHeadKeywords("najčešća pitanja, pitanja, faq");
		
		$mainTemplateData['downHeader'] = $this->load->view(PathManager::GetPackagePath("lektire", "m_search_form_view"), null, true);

		$contentTop = "";

		//$contentTop .= $this->load->view('ads/adsense_leaderboard_view.php', null, true);

		$mainTemplateData['contentTop'] = $contentTop;

		$mainColumnData['mainTitle'] = "Najčešća pitanja";
		$mainColumnData['mainContent'] = $this->load->view('informacije/najcescapitanja_view', null, true);
		$templateData['contentLeft'] = $this->load->view(PathManager::GetSharedPath("main_column_view"), $mainColumnData, true);
		
		$templateData['contentRight'] = "";
		$adsenseMrectDetailsViewData["marginTopBottom"] = 0;
		//$templateData['contentRight'] .= $this->load->view('ads/adsense_mrect_details_view', $adsenseMrectDetailsViewData, true);
		//$templateData['contentRight'] .= $this->load->view(PathManager::GetSharedPath("facebook/activity_feed_view"), null, true);
		//$templateData['contentRight'] .= $this->load->view(PathManager::GetSharedPath("facebook/like_view"), null, true);
		$templateData['contentRight'] .= $this->randomBanner();
		//$templateData['contentRight'] .= $this->load->view('ads/adsense_mrect_details_view', $adsenseMrectDetailsViewData, true);
		
		$mainTemplateData["template"] = $this->load->view(PathManager::GetSharedPath("template_84_view"), $templateData, true);

		$this->Render($mainTemplateData);
	}

	/**
	 * Prikazuje uvjete koristenja
	 *
	 */
	public function uvjetikoristenja(){
		$this->head_generator->SetHeadTitle("Uvijeti korištenja");
		$this->head_generator->SetHeadDescription("Uvjeti korištenja sadržaja na portalu sa besplatnim lektirama za osnovne i srednje škole.");
		$this->head_generator->AddHeadKeywords("uvjeti korištenja, pravila");
		$this->head_generator->AddHeadMetaTag(new Meta(Meta::TYPE_NAME, "robots", "noindex"));
		
		$mainTemplateData['downHeader'] = $this->load->view(PathManager::GetPackagePath("lektire", "m_search_form_view"), null, true);

		$contentTop = "";

		$contentTop .= $this->load->view('ads/adsense_leaderboard_view.php', null, true);

		$mainTemplateData['contentTop'] = $contentTop;

		$mainColumnData['mainTitle'] = "Uvjeti korištenja";
		$mainColumnData['mainContent'] = '
		<p>Portal <strong>Moje lektire</strong> posjetiteljima u dobroj namjeri pruža sadržaj naučnog karaktera. Svi posjetitelji stranice imaju pravo besplatno koristiti sadržaje portala ukoliko time ne krše pravila korištenja.</p>

		<p>Portal "Moje lektire" objavljuje sadržaj u dobroj namjeri. Sav sadržaj portala koristite na vlastitu odgovornost i portal "Moje lektire" se ne smatra odgovorinim za bilo kakvu štetu nastalu korištenjem tog sadržaja.
		Sadržaj na portalu moguće je promijeniti bez prethodne najave.</p>

		<p>Preuzimanje datoteka koje sadže lektire je u potpunosti besplatno.</p>

		<p>Portal "Moje lektire" može sadržavati poveznice na druga web sjedišta. Poveznice na druga web sjedišta objavljena su u dobroj namjeri i portal "Moje lektire" se ne smatra odgovornim za sadržaj na tim web sjedištima.</p>

		<p>Portal "Moje lektire" štiti privatnost korisnika u najvećoj mogućoj mjeri. Portal će koristiti dobivene podatke korisnike u dobroj namjeri, te podatke neće distribuirati niti prodavati trećoj strani.</p>

		<p>Portal "Moje lektire" nije ni na koji način odgovoran za sadržaj koji objavljuju posjetitelji portala.</p>

		<p>Na portalu "Moje lektire" prikazuju se oglasi oglašivačkih tvrtki treće strane. Te tvrtke mogu koristiti informacije (ne uključujući vaše ime, adresu, email adresu ili telefonski broj) o vašim posjetama ovome web sjedištu kao i drugim web sjedištima u svrhu prikazivanja odgovarajućih oglasa koji bi vas mogli zanimati.</p>

<p>Google, kao pružatelj oglasa treće strane, koristi kolačiće za prikazivanje oglasa na ovome web sjedištu. Google koristi DART kolačić radi prikupljanja informacija za prikazivanje oglasa koji bi vas mogli zanimati na ovome i drugim web sjedištima. Korisnici se mogu isključiti od korištenja DART kolačića tako da posjete slijedeći link <a href="http://www.google.com/privacy_ads.html">http://www.google.com/privacy_ads.html</a>.</p>
		';

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
		
		$mainTemplateData["template"] = $this->load->view(PathManager::GetSharedPath("template_84_view"), $templateData, true);

		$this->Render($mainTemplateData);
	}

	/**
	 * Email validacija
	 *
	 * @return boolean - true ako je uspjesno, inace false
	 */
	private function emailDataValidation(){
		$this->form_validation->set_rules('contact_subject', 'Naslov poruke', 'trim|required|xss');
		$this->form_validation->set_rules('contact_message', 'Sadržaj poruke', 'trim|required|xss');
		$this->form_validation->set_rules('contact_name', 'Ime', 'trim|required|xss');
		$this->form_validation->set_rules('contact_email', 'Email adresa', 'trim|required|valid_email|xss');

		if ($this->form_validation->run()) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Slanje maila
	 *
	 */

	private function sendMail(){
		$emailTo = "info@moje-lektire.com";

		$subject = trim($this->input->post('contact_subject'));
		$formMessage = trim($this->input->post('contact_message'));
		$name = trim($this->input->post('contact_name'));
		$emailFrom = trim($this->input->post('contact_email'));

		$config['wordwarp'] = true;
		$config['charset'] = 'utf-8';
		$config['useragent'] = 'Moje lektire BOT';

		$this->email->initialize($config);
		$this->email->from($emailFrom, $name);
		$this->email->to($emailTo);
		$this->email->subject($subject);

		$message = $formMessage . "\n\n" . $name . "\n" . $emailFrom;
		$this->email->message($message);


		if ( ! $this->email->send()) {
    		echo "greška";
		}


	}

	/**
	 * Prikazuje kontakt stranicu
	 *
	 */
	public function Kontakt(){
		$isValidData = $this->emailDataValidation();
		if($isValidData){
				$this->sendMail();
				$this->session->set_flashdata('contact_mail', 'Poruka je uspješno poslana.');
				redirect('informacije/kontakt');
		} else {
			$this->head_generator->SetHeadTitle("Kontakt");
			$this->head_generator->SetHeadDescription("Stranica sa kontaktnim informacijama portala sa besplatnim lektirama za osnovne i srednje škole.");
			$this->head_generator->AddHeadKeyword("kontakt, informacije, pitanja");
			
			$mainTemplateData['downHeader'] = $this->load->view(PathManager::GetPackagePath("lektire", "m_search_form_view"), null, true);

			$contentTop = "";

			$contentTop .= $this->load->view('ads/adsense_leaderboard_view.php', null, true);

			if($this->session->flashdata('contact_mail')){
				$notificationData['notificationTitle'] = $this->session->flashdata('contact_mail');
				$notificationData['notificationText'] = '';
				$contentTop .= $this->load->view(PathManager::GetSharedPath("notification_message_view"), $notificationData, true);
			}

			$mainTemplateData['contentTop'] = $contentTop;

			$mainColumnData['mainTitle'] = "Kontakt";
			$mainColumnData['mainContent'] = $this->load->view(PathManager::GetPackagePath("informacije", "c_contact_view"), null, true);

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
			
			$mainTemplateData["template"] = $this->load->view(PathManager::GetSharedPath("template_84_view"), $templateData, true);

			$this->Render($mainTemplateData);

		}


	}
	
	private function randomBanner(){
		srand(time());
		$randval = rand(0, 1);
		
		return $randval < 0.5 ? '<a href="http://www.otkrij-igre.net/" title="Otkrij besplatne online igre" target="_blank"><img src="'. static_url("img/ads/igre_otkrij_net_300x250.jpg") . '" /></a>' : '<a href="http://www.tv-tube.tv/" title="TvTube - Watch free online TV" target="_blank"><img alt="TvTube - Watch free online TV" src="'. static_url("img/ads/tvtube_banner_300x250.jpg") . '" /></a>';
	}


}



?>