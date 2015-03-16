<?php

require_once (LIBPATH . SYSPATH . "ci_library.php");

/**
 * Razred koji predstavlja script tag sa pripadajucim sadrzajem
 * @author Željko Tepšić
 * @version 1.0.0
 */
class Script extends CILibrary {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	/**
	 * URL lokacija script datoteke
	 * @var string
	 */
	private $src;
	
	/**
	 * Postavlja URL lokaciju script datoteke
	 * 
	 * @param $src the $src to set
	 */
	public function SetSrc ($src) {
		$this->src = $src;
	}

	/**
	 * Dohvaca lokaciju URL script datoteke
	 * 
	 * @return the $src
	 */
	public function GetSrc () {
		return $this->src;
	}
	
	
	/**
	 * MIME tip script datotke
	 * 
	 * @var string
	 */
	private $type;
	
	/**
	 * Postavlja MIME tip script datoteke
	 * @param $type the $type to set
	 */
	public function SetType ($type) {
		$this->type = $type;
	}

	/**
	 * Dohvaca MIME tip script datoteke
	 * @return the $type
	 */
	public function GetType () {
		return $this->type;
	}
	
	
	/**
	 * Sadrzaj script taga
	 * @var string
	 */
	private $content;
	
	/**
	 * Postavlja sadrzaj script taga
	 * @param $content the $content to set
	 */
	public function SetContent ($content) {
		$this->content = $content;
	}

	/**
	 * Dohvaca sadrzaj script taga
	 * 
	 * @return the $content
	 */
	public function GetContent () {
		return $this->content;
	}
	
	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################
	
	
	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################
	

	/**
	 * Konstruktor
	 * @param $src - ukoliko se radi o datoteci potrebno je zadati stazu
	 * @param $content - sadrzaj unutar script tagova
	 * @param $type
	 */	
	public function __construct ($src = "", $content = "", $type="text/javascript") {
		parent::__construct();
		
		$this->type = $type;
		$this->content = $content;
		
		if(!empty($src)){
			$this->src = $src;
		}
		
		$this->CI->load->helper('html');
		
	}

	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################

	
	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################
	
	/**
	 * Stvara asocijativno polje temeljeno na clanskim varijablama pogodno za CI framework
	 * @return string associative array
	 */
	public function ToAssociativeArray(){
		$associativeArray = array();
		
		if(!empty($this->src)){
			$associativeArray["src"] = $this->src;	
		}
		
		if(isset($this->type)){
			$associativeArray["type"] = $this->type;
		}
		
		if(!empty($this->content)){
			$associativeArray["content"] = $this->content;
		}
		
		return $associativeArray;
				
	}
	
	/**
	 * Pretvaranje Script objekta u znakovni zapis
	 * @return string
	 */
	public function ToString(){
		return script_tag($this->ToAssociativeArray());
	}
	
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
}

?>