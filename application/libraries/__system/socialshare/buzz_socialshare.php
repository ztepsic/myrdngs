<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (LIBPATH . SYSPATH . "socialshare/socialshare.php");

class Buzz_socialshare extends Socialshare {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	const BUZZ_BASE_SHARE_URL = "http://www.google.com/reader/link?";
	
	/**
	 * SrcUrl
	 * @var string
	 */
	private $srcUrl;
	
	/**
	 * Postavlja srcUrl
	 * @param string $srcUrl
	 */
	public function SetSrcUrl($srcUrl){
		$this->srcUrl = $srcUrl;
	}
	
	/**
	 * SrcTitle
	 * @var string
	 */
	private $srcTitle;
	
	/**
	 * Postavlja srcTitle
	 * @param string $srcTitle
	 */
	public function SetSrcTitle($srcTitle){
		$this->srcTitle = $srcTitle;
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
	public function __construct($url, $title, $description){
		parent::__construct(self::BUZZ_BASE_SHARE_URL, $url, $title, $description);
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
			"snippet" => $this->GetDescription(),
			"url" => $this->GetUrl(),
			"title" => $this->GetTitle(),
			"share" => "true"
		);
		
		if(!empty($this->srcUrl) && !empty($this->srcTitle)){
			$queryStringArray["srcUrl"] = $this->srcUrl;
			$queryStringArray["srcTitle"] = $this->srcTitle;
		}
		
		return $this->GetBasicShareServiceUrl() . http_build_query($queryStringArray);
	}
	
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
}

?>