<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (LIBPATH . SYSPATH . "ci_library.php");
require_once (LIBPATH . SYSPATH . "htmlComponents/anchor.php");
include_once (LIBPATH . SYSPATH . "IStringRenderer.php");

/**
 * Razred zaduzen za generiranje breadcrumbsa
 * @author Željko Tepšić
 * @version 1.0.0
 *
 */
class Breadcrumbs extends CILibrary implements IStringRenderer {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	/**
	 * Home anchor
	 * @var Anchor
	 */
	private $homeElement;
	
	/**
	 * Dohvaca Home anchor
	 * @return Anchor
	 */
	public function GetHomeElement(){
		return $this->homeElement;
	}
	
	/**
	 * Naziv posljednjeg elementa
	 * @var string
	 */
	private $lastElement;
	
	/**
	 * Dohvaca naziv posljednjeg elementa
	 * @return string
	 */
	public function GetLastElement(){
		return $this->lastElement;
	}
	
	/**
	 * Postavlja naziv posljednjeg elementa
	 * @param string $lastElement
	 */
	public function SetLastElement($lastElement){
		$this->lastElement = (string) $lastElement;
	}
	
	/**
	 * Anchor elementi
	 * @var array<Anchor>
	 */
	private $middleElements;
	
	/**
	 * Dohvaca elemente u sredini
	 * @return array<Anchor>
	 */
	public function GetMiddleElements(){
		return $this->middleElements;
	}
	
	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################
	

	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################
	
	/**
	 * Konstruktor
	 * @param string $homeElementName - naziv za home stranicu
	 * @param string $lastElement - posljednji element
	 */
	function __construct ($homeElementName, $lastElement) {
		parent::__construct();
		
		$this->CI->load->helper("url");
		
		if(empty($homeElementName)){
			throw new Exception("Home element name must be non empty value.");
		} else {
			$this->homeElement = new Anchor($homeElementName, base_url());	
		}
		
		if(empty($lastElement)){
			throw new Exception("Last element name must be non empty value.");
		} else {
			$this->lastElement = $lastElement;	
		}
		
		
		$this->middleElements = array();
		
		
	}
	

	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
	

	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################
	
	/**
	 * Resetira sve elemente osim home
	 */
	public function Reset(){
		$middleElements = array();
		$lastElement = "";
	}
	

	/**
	 * Dodaje anchor u elemente u sredini
	 * @param Anchor $anchor
	 */
	public function AddMiddleElement(Anchor $anchor){
		$this->middleElements[] = $anchor;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see application/libraries/__system/IStringRenderer#Render()
	 */
	public function Render(){
		$renderData["homeElementAnchor"] = $this->homeElement;
		$renderData["middleElements"] = $this->middleElements;
		$renderData["lastElement"] = $this->lastElement;
		
		return $this->CI->load->view(PathManager::GetSystemPath("breadcrumbs/breadcrumbs_view"), $renderData, true);
	}
	
	
	
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################

}

?>