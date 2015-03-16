<?php

//require_once (LIBPATH . SYSPATH . "socialshare/socialshare.php");
require_once (LIBPATH . SYSPATH . "socialshare/delicious_socialshare.php");
require_once (LIBPATH . SYSPATH . "socialshare/digg_socialshare.php");
require_once (LIBPATH . SYSPATH . "socialshare/facebook_socialshare.php");
require_once (LIBPATH . SYSPATH . "socialshare/friendfeed_socialshare.php");
require_once (LIBPATH . SYSPATH . "socialshare/google_socialshare.php");
require_once (LIBPATH . SYSPATH . "socialshare/mixx_socialshare.php");
require_once (LIBPATH . SYSPATH . "socialshare/myspace_socialshare.php");
require_once (LIBPATH . SYSPATH . "socialshare/reddit_socialshare.php");
require_once (LIBPATH . SYSPATH . "socialshare/stumbleupon_socialshare.php");
require_once (LIBPATH . SYSPATH . "socialshare/twitter_socialshare.php");
require_once (LIBPATH . SYSPATH . "socialshare/croportal_socialshare.php");
require_once (LIBPATH . SYSPATH . "socialshare/buzz_socialshare.php");
require_once (LIBPATH . SYSPATH . "socialshare/zrikka_socialshare.php");

class Socshare extends Controller {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################
	
	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################
	
	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################
	
	public function __construct() {
		parent::__construct();
		
		$this->load->helper('text');
		
		
	}
	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
	
	// #################################
	// ###### ACTIONS ##### BEGIN ######
	// #################################
	
	public function Index () {
		$service = $this->input->get("s");
		if($service == false) {
			show_error("400 Bad Request", 400);
		} else {
			$servicesPattern = "/(delicious|digg|facebook|friendfeed|google|mixx|myspace|reddit|stumbleupon|twitter|croportal|buzz|zrikka)/i";
			$result =  preg_match($servicesPattern, $service, $matches);
			if($result != 1){
				show_error("400 Bad Request", 400);
			}
		}
		
		
		$url =  $this->input->get("u");
		if($url == false){
			show_error("400 Bad Request", 400);
		}
		$url = urldecode($url);
		
		$title = $this->input->get("t");
		$title = urldecode($title);
		$title = character_limiter($title, 75);
		
		$description = $this->input->get("d");
		if($description == false){
			$description = null;
		} else {
			$description = urldecode($description);
			$description = character_limiter($description, 340);
		}

		redirect($this->getShareServiceUrl($service, $url, $title, $description), 302);
	}
	
	// ###############################
	// ###### ACTIONS ##### END ######
	// ###############################
	
	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################
	
	private function getShareServiceUrl($service, $url, $title = null, $description = null){
		$socialShare = null;
		if($service == "facebook"){
			$socialShare = new Facebook_socialshare($url, $title);
		} else if($service == "twitter"){
			$socialShare = new Twitter_socialshare($url, $title);
			$socialShare->SetInitialMessage("RT @tv_tube:");
		} else if($service == "digg"){
			$socialShare = new Digg_socialshare($url, $title, $description);
		} else if($service == "stumbleupon"){
			$socialShare = new Stumbleupon_socialshare($url, $title);
		} else if($service == "delicious") {
			$socialShare = new Delicious_socialshare($url, $title);
		} else if($service == "google"){
			$socialShare = new Google_socialshare($url, $title);
		} else if($service == "friendfeed"){
			$socialShare = new Friendfeed_socialshare($url, $title);
		} else if($service == "mixx"){
			$socialShare = new Mixx_socialshare($url);
		} else if($service == "reddit"){
			$socialShare = new Reddit_socialshare($url, $title);
		} else if($service == "myspace"){
			$socialShare = new Myspace_socialshare($url, $title, $description);
		} else if($service == "buzz") {
			$socialShare = new Buzz_socialshare($url, $title, $description);
			$socialShare->SetSrcTitle($this->config->item("zt_site_title"));
			$socialShare->SetSrcUrl(base_url());
		} else {
			throw new Exception("Unsupported service.");
		}
		
		return $socialShare->GetShareServiceUrl();
		
	}
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
}

?>