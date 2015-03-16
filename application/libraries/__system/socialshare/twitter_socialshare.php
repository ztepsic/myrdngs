<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (LIBPATH . SYSPATH . "socialshare/socialshare.php");

class Twitter_socialshare extends Socialshare {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	const TWITTER_BASE_SHARE_URL = "http://twitter.com/home?";
	
	/**
	 * Pocetna poruka
	 * @var string
	 */
	private $initialMessage;
	
	/**
	 * Postavlja pocetnu poruku
	 * @param string $initialMessage
	 */
	public function SetInitialMessage($initialMessage){
		$this->initialMessage = $initialMessage;
	}
	
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
		parent::__construct(self::TWITTER_BASE_SHARE_URL, $url, $title);
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
		$status = "";
		if(!empty($this->initialMessage)){
			$status .= $this->initialMessage . " ";
		}
		
		$status .= $this->GetTitle() . " - " . $this->GetUrl();
		
		$queryStringArray = array(
			"status" => $status
		);
		
		return $this->GetBasicShareServiceUrl() . http_build_query($queryStringArray);
	}
	
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
}

?>
