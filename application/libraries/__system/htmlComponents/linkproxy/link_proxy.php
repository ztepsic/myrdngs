<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once (LIBPATH . SYSPATH . "ci_library.php");
include_once (LIBPATH . SYSPATH . "IStringRenderer.php");

/**
 * Razred koji implementiry proxy za linkove
 * @author Željko Tepšić
 * @version 1.1.0
 *
 */
class Link_proxy extends CILibrary implements IStringRenderer {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	const HEADER_ROWS = 140;
	
	/**
	 * URL adresa s koje ce se prikazivati sadrzaj
	 * @var string
	 */
	private $url;
	
	/**
	 * Postavlja URL adresu s koje ce se prikazivati sadrzaj
	 * 
	 * @param $url the $url to set
	 */
	public function SetUrl ($url) {
		$this->url = $url;
	}

	/**
	 * Dohvaca URL adresu s koje ce se prikazivati sadrzaj
	 * 
	 * @return the $url
	 */
	public function GetUrl () {
		return $this->url;
	}
	
	
	/**
	 * Naziv kontrolera koji implementira Header metodu
	 * @var string
	 */
	private $controllerName;
	
	/**
	 * Postavlja naziv kontrolera koji implementira Header metodu
	 * 
	 * @param $controllerName the $controllerName to set
	 */
	public function SetControllerName ($controllerName) {
		$this->controllerName = $controllerName;
	}

	/**
	 * Dohvaca naziv kontrolera koji implementira Header metodu
	 * 
	 * @return the $controllerName
	 */
	public function GetControllerName () {
		return $this->controllerName;
	}
	
	
	/**
	 * Genericki identifikator, koji ovisi o implementacije metode Header
	 * @var int
	 */
	private $genericId;
	
	/**
	 * Postavlja genricicki identifikator
	 * 
	 * @param $genericId the $genericId to set
	 */
	public function SetGenericId ($genericId) {
		$this->genericId = $genericId;
	}

	/**
	 * Dohvaca genericki identifikator
	 * 
	 * @return the $genericId
	 */
	public function GetGenericId () {
		return $this->genericId;
	}

	
	/**
	 * Sadrzaj head taga
	 * @var string
	 */
	private $head_generator;
	
	/**
	 * Postavlja sadrzaj head taga
	 * 
	 * @param $head the $head to set
	 */
	public function SetHead ($head) {
		$this->head_generator = $head;
	}

	/**
	 * Dohvaca sadrzaj head taga
	 * 
	 * @return the $head
	 */
	public function GetHead () {
		return $this->head_generator;
	}

	
	/**
	 * Sadrzaj u tagu noframes
	 * @var string
	 */
	private $noFrames;
	
	/**
	 * Postavlja sadrzaj u tagu Noframes
	 * 
	 * @param $noFrames the $noFrames to set
	 */
	public function SetNoFrames ($noFrames) {
		$this->noFrames = $noFrames;
	}

	/**
	 * Dohvaca sadrzaj u tagu Noframes
	 * 
	 * @return the $noFrames
	 */
	public function GetNoFrames () {
		return $this->noFrames;
	}
	
	/**
	 * Broj redaka headera
	 * @var int
	 */
	private $headerRows;
	
	/*
	 * Dohvaca broj redaka headera
	 * 
	 * @return int
	 */
	public function GetHeaderRows(){
		return $this->headerRows;
	}
	
	
	/*
	 * Postavlja broj redaka headera
	 * 
	 * @param int $headerRows
	 */
	public function SetHeaderRows($headerRows){
		$this->headerRows = $headerRows;
	}
	
	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################
	
	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################
	
	public function __construct ($params) {
		parent::__construct();
		
		$this->CI->load->helper('url');

		$this->init($params);
		
	}
	
	private function init($params){
		if(isset($params["url"])){
			$this->url = $params["url"];
		} else {
			throw new Exception("\"url\" parameter is not defined.");
		}
		
		if(isset($params["controllerName"])){
			$this->controllerName = $params["controllerName"];
		} else {
			throw new Exception("\"conrollerName\" parameter is not defined.");
		}
		
		if(isset($params["head"])){
			$this->head_generator = $params["head"];
		} else {
			throw new Exception("\"head\" parameter is not defined.");
		}
		
		if(isset($params["genericId"])){
			$this->genericId = $params["genericId"];
		}
		
		if(isset($params["noFrames"])){
			$this->noFrames = $params["noFrames"];
		}
		
		if(isset($params["headerRows"])){
			$this->headerRows = $params["headerRows"];
		} else {
			$this->headerRows = self::HEADER_ROWS;
		}
		
		
	}

	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
	
	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################
	
	/**
	 * Iscrtava prikaz proxy-a
	 * @return string
	 */
	public function Render(){
		$proxyData["head"] = $this->head_generator;
		$proxyData["url"] = prep_url($this->url);
		$proxyData["noFrames"] = isset($this->noFrames) ? $this->noFrames : "";
		$proxyData["headerRows"] = $this->headerRows;
		
		if(isset($this->genericId)){
			$proxyData["headerUrl"] = site_url($this->controllerName . "/header/" . $this->genericId);
		} else {
			$proxyData["headerUrl"] = site_url($this->controllerName . "/header");	
		}
		
		return $this->CI->load->view(PathManager::GetSystemPath("linkproxy/template"), $proxyData, true);
	}
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
}

?>