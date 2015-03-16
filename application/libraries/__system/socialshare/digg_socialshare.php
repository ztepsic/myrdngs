<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (LIBPATH . SYSPATH . "socialshare/socialshare.php");

class Digg_socialshare extends Socialshare {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	const DIGG_BASE_SHARE_URL = "http://digg.com/submit?";
	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################
	
	/**
	 * Media
	 * @var string
	 */
	private $media;
	
	/**
	 * Dohvaca media
	 * @return string
	 */
	public function GetMedia(){
		return $this->media;
	}
	
	/**
	 * Postavlja media
	 * @param string $media
	 */
	public function SetMedia($media){
		$this->media = $media;
	}
	
	/**
	 * Topic
	 * @var string
	 */
	private $topic;
	
	/**
	 * Dohvaca topic
	 * @return string
	 */
	public function GetTopic(){
		return $this->topic;
	}
	
	/**
	 * Postavlja topic
	 * @param string $topic
	 */
	public function SetTopic($topic){
		$this->topic = $topic;
	}
	
	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################
	
	/**
	 * Konstruktor
	 */
	public function __construct($url, $title, $description){
		if(!$this->validateTitle($title)){
			throw new Exception("Title has to many characters.");
		}
		
		if(!$this->validateDescription($description)){
			throw new Exception("Description has to many characters.");
		}
		
		parent::__construct(self::DIGG_BASE_SHARE_URL, $url, $title, $description);
		$media = null;
		$topic = null;
	}

	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
	
	
	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################
	
	private function validateTitle($title){
		$charactersCount = mb_strlen($title);
		
		if($charactersCount <= 75){
			return true;
		} else {
			return false;
		}
	}
	
	private function validateDescription($description){
		$charactersCount = mb_strlen($description);
		if($charactersCount <= 350){
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Dohvaca punu URL adresu na servis za sharenje sadrzaja
	 * @return string
	 */
	public function GetShareServiceUrl() {		
		$queryStringArray = array(
			"url" => $this->GetUrl(),
			"title" => $this->GetTitle(),
			"bodytext" => $this->GetDescription()
		);
		
		if(!empty($this->media)){
			$queryStringArray["media"] = $this->media;
		}
		
		if(!empty($this->topic)){
			$queryStringArray["topic"] = $this->topic;
		}

		
		return $this->GetBasicShareServiceUrl() . http_build_query($queryStringArray);
	}
	
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
}

?>
