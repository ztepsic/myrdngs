<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (LIBPATH . SYSPATH . "socialshare/socialshare.php");

class Google_socialshare extends Socialshare {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	const GOOGLE_BASE_SHARE_URL = "http://www.google.com/bookmarks/mark?";
	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################
	
	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################
	
	/**
	 * Konstruktor
	 */
	public function __construct($url, $title){
		parent::__construct(self::GOOGLE_BASE_SHARE_URL, $url, $title);
	}

	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
	
	
	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################

	/**
	 * Dohvaca punu URL adresu na servis za sharenje sadrzaja
	 * @return string
	 */
	public function GetShareServiceUrl() {
		$queryStringArray = array(
			"op" => "add",
			"bkmk" => $this->GetUrl(),
			"title" => $this->GetTitle()
		);
		
		return $this->GetBasicShareServiceUrl() . http_build_query($queryStringArray);
	}
	
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
}

?>
