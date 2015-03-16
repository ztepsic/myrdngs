<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (LIBPATH . SYSPATH . "socialshare/socialshare.php");

class Croportal_socialshare extends Socialshare {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	const CROPORTAL_BASE_SHARE_URL = "http://www.croportal.net/submit?";
	
	/**
	 * Category
	 * @var string
	 */
	private $category;
	
	/**
	 * Dohvaca kategoriju
	 * @return string
	 */
	public function GetCategory(){
		return $this->category;
	}
	
	/**
	 * Postavlja kategoriju
	 * @param string $category
	 */
	public function SetCategory($category){
		$this->category = $category;
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
		if(!$this->validateTitle($title)){
			throw new Exception("Title has to many characters.");
		}
		
		if(!$this->validateDescription($description)){
			throw new Exception("Description has to many characters.");
		}
		
		parent::__construct(self::CROPORTAL_BASE_SHARE_URL, $url, $title, $description);
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
		$charactersCount = strlen($title);
		
		if($charactersCount <= 75){
			return true;
		} else {
			return false;
		}
	}
	
	private function validateDescription($description){
		$charactersCount = strlen($description);
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
			"abstract" => $this->GetDescription()
		);
		
		if(!empty($this->category)){
			$queryStringArray["category"] = $this->category;
		}
		
		return $this->GetBasicShareServiceUrl() . http_build_query($queryStringArray);
	}
	
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
}

?>