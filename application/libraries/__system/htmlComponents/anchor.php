<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (LIBPATH . SYSPATH . "ci_library.php");

/**
 * Razred zaduzen za generiranje anchora
 * @author Željko Tepšić
 * @version 1.0.0
 *
 */
class Anchor extends CILibrary {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	/**
	 * URI adresa
	 * @var string
	 */
	private $uri;
	
	/**
	 * Dohvaca URI adresu
	 * @return string
	 */
	public function GetUri(){
		return $this->uri;
	}
	
	/**
	 * Postavlja URI adresu
	 * @param string $uri
	 */
	public function SetUri($uri){
		$this->uri = $uri;
	}
	
	/**
	 * Naziv linka
	 * @var string
	 */
	private $title;
	
	/**
	 * Dohvaca naziv linka
	 * @return string
	 */
	public function GetTitle(){
		return $this->title;
	}
	
	/**
	 * Postavlja naziv linka
	 * @param string $title
	 */
	public function SetTitle($title){
		$this->title = $title;
	}
	
	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################
	

	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################
	
	/**
	 * Konstruktor
	 * @param string $title - naziv linka
	 * @param string $uri - uri adresa
	 */
	function __construct ($title, $uri) {
		parent::__construct();
		
		$this->title = $title;
		$this->uri = $uri;
		
	}
	

	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
	

	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################
	
	/**
	 * Stvara html anchor tag
	 * @param $attributes - atributi anchor taga
	 * @return string
	 */
	public function GetAnchor($attributes = null){
		$this->CI->load->helper("url");
		
		$attributes["title"] = $this->title;
		
		return anchor($this->uri, $this->title, $attributes);
	}
	
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
	
}

?>