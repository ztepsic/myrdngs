<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (LIBPATH . SYSPATH . "socialshare/socialshare.php");

class Delicious_socialshare extends Socialshare {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	const DELICIOUS_BASE_SHARE_URL = "http://delicious.com/save?";
	
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
		parent::__construct(self::DELICIOUS_BASE_SHARE_URL, $url, $title);
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
			"jump" => "yes",
			"url" => $this->GetUrl(),
			"title" => $this->GetTitle()
		);
		
		return $this->GetBasicShareServiceUrl() . http_build_query($queryStringArray);
	}
	
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
}

?>
