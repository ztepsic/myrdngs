<?php

require_once (LIBPATH . SYSPATH . "ci_library.php");

/**
 * Razred koji predstavlja podatke meta taga
 * @author Željko Tepšić
 * @version 1.1.0
 */
class Link extends CILibrary {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	/**
	 * Lokacija linkanog dokumenta
	 * @var string
	 */
	private $href;
	
	/**
	 * Postavlja lokaciju linkanog dokumenta
	 * 
	 * @param $href the $href to set
	 */
	public function SetHref ($href) {
		$this->href = $href;
	}

	/**
	 * Dohvaca lokaciju linkanog dokumenta
	 * 
	 * @return the $href
	 */
	public function GetHref () {
		return $this->href;
	}
	
	
	/**
	 * Veza izmedju linkanog dokumenta i trenutnog dokumenta
	 * @var string
	 */
	private $rel;
	
	/**
	 * Postavlja vezu izmedju linkanog dokumenta i trenutnog dokumenta
	 * 
	 * @param $rel the $rel to set
	 */
	public function SetRel ($rel) {
		$this->rel = $rel;
	}

	/**
	 * Dohvaca vezu izmedju linkanog dokumenta i trenutnog dokumenta
	 * 
	 * @return the $rel
	 */
	public function GetRel () {
		return $this->rel;
	}
	

	/**
	 * MIME tip linkanog dokumenta
	 * 
	 * @var string
	 */
	private $type;
	
	/**
	 * Postavlja MIME tip linkanog dokumenta
	 * @param $type the $type to set
	 */
	public function SetType ($type) {
		$this->type = $type;
	}

	/**
	 * Dohvaca MIME tip linkanog dokumenta
	 * @return the $type
	 */
	public function GetType () {
		return $this->type;
	}
	
	
	/**
	 * Naziv
	 * @var string
	 */
	private $title;
	
	/**
	 * Postavlja naziv
	 * 
	 * @param $title the $title to set
	 */
	public function SetTitle ($title) {
		$this->title = $title;
	}

	/**
	 * Dohvaca naziv
	 * 
	 * @return the $title
	 */
	public function GetTitle () {
		return $this->title;
	}
	
	
	/**
	 * Definira medij na kojemu ce se prikazati dokument 
	 * @var string
	 */
	private $media;
	
	/**
	 * Postavlja medij na kojemu ce se prikazati dokument
	 * 
	 * @param $media the $media to set
	 */
	public function SetMedia ($media) {
		$this->media = $media;
	}

	/**
	 * Dohvaca medij na kojemu ce se prikazati dokument
	 * 
	 * @return the $media
	 */
	public function GetMedia () {
		return $this->media;
	}
	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################
	
	
	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################
	
	public function __construct ($href, $rel = "stylesheet", $type = "text/css", $media = "all") {
		parent::__construct();
		
		$this->CI->load->helper('html');
		
		$this->href = $href;
		$this->rel = $rel;
		$this->type = $type;
		$this->media = $media;

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
		
		if(isset($this->href)){
			$associativeArray["href"] = $this->href;	
		}
		
		if(isset($this->rel)){
			$associativeArray["rel"] = $this->rel;	
		}
		
		if(isset($this->type) && !empty($this->type)){
			$associativeArray["type"] = $this->type;
		}
		
		if(isset($this->title)){
			$associativeArray["title"] = $this->title;
		}
		
		if(isset($this->media) && !empty($this->media)){
			$associativeArray["media"] = $this->media;
		}
		
		return $associativeArray;
				
	}
	
	/**
	 * Pretvaranje Link objekta u znakovni zapis
	 * @return string
	 */
	public function ToString(){
		return link_tag($this->ToAssociativeArray());
	}
	
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
}

?>