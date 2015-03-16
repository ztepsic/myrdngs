<?php
require_once (LIBPATH . SYSPATH . "ci_library.php");
/**
 * Razred koji predstavlja podatke meta taga
 * @author Željko Tepšić
 * @version 1.0.0
 */
class Meta extends CILibrary {
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################	
	const TYPE_HTTP_EQUIV = "http-equiv";
	const TYPE_NAME = "name";
	
	/**
	 * Sadrzaj/opis podatka
	 * @var string
	 */
	private $content;
	/**
	 * Postavlja sadrzaj/opis podatka
	 * 
	 * @param $content the $content to set
	 */
	public function SetContent ($content) {
		$this->content = $content;
	}
	/**
	 * Dohvaca sadrzaj/opis podatka
	 * 
	 * @return the $content
	 */
	public function GetContent () {
		return $this->content;
	}
	/**
	 * Tip meta podatka
	 * @var string
	 */
	private $type;	
	/**
	 * Postavlja tip meta podatka
	 * 
	 * @param $type the $type to set
	 */
	public function SetType ($type) {
		$this->type = $type;
	}
	/**
	 * Dohvaca tip meta podatka
	 * 
	 * @return the $type
	 */
	public function GetType () {
		return $this->type;
	}

	/**
	 * Vrijednost tipa podatka
	 * @var string
	 */
	private $typeValue;
	
	/**
	 * Postavlja vrijednost tipa meta podatka
	 * 
	 * @param $typeValue the $typeValue to set
	 */
	public function SetTypeValue ($typeValue) {
		$this->typeValue = $typeValue;
	}
	/**
	 * Dohvaca vrijednost tipa meta podatka
	 * 
	 * @return the $typeValue
	 */
	public function GetTypeValue () {
		return $this->typeValue;
	}	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################	
	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################	
	public function __construct ($type, $typeValue, $content) {
		parent::__construct();
		$this->type = $type;
		$this->typeValue = $typeValue;		$this->content = $content;
		$this->CI->load->helper('html');
	}	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################

	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################
	/**
	 * Pretvaranje Meta objekta u znakovni zapis
	 * @return string
	 */
	public function ToString(){
		return meta($this->typeValue, htmlspecialchars($this->content), $this->type);
	}
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
}
?>