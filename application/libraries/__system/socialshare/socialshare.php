<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (LIBPATH . SYSPATH . "ci_library.php");
//include_once (LIBPATH . SYSPATH . "IStringRenderer.php");

abstract class Socialshare extends CILibrary {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	/**
	 * Url adresa servisa preko kojeg se moze sharati sadrzaj
	 * @var string
	 */
	private $basicShareServiceUrl;
	
	/**
	 * Dohvaca adresu servisa preko kojeg se moze sharati sadrzaj
	 * @return unknown_type
	 */
	public function GetBasicShareServiceUrl(){
		return $this->basicShareServiceUrl;
	}
	
	/**
	 * Url adresa sadrzaja kojeg se zeli sherati
	 * @var string
	 */
	private $url;
	
	/**
	 * Dohvaca URL adresu sadrzaja kojeg se zeli sherati
	 * @return string
	 */
	public function GetUrl(){
		return $this->url;
	}
	
	/**
	 * Postavlja URL adresu sadrzaja kojeg se zeli sherati
	 * @param $url
	 */
	public function SetUrl($url){
		$this->url = (string) $url;
	}
	
	/**
	 * Naziv sadrzaja kojeg se zeli sherati
	 * @var string
	 */
	private $title;
	
	/**
	 * Dohvaca naziv sadrzaja kojeg se zeli sherati
	 * @return string
	 */
	public function GetTitle(){
		return $this->title;
	}
	
	/**
	 * Postavlja naziv sadrzaja kojeg se zeli sherati
	 * @param $title
	 * @return string
	 */
	public function SetTitle($title){
		$this->title = (string) strip_tags($title);
	}
	
	/**
	 * Opis sadrzaja kojeg se zeli sherati
	 * @var string
	 */
	private $description;
	
	/**
	 * Dohvaca opis sadrzaja koejg se zeli sherati
	 * @return string
	 */
	public function GetDescription(){
		return $this->description;
	}
	
	/**
	 * Postavlja opis sadrzaja kojeg se zeli sherati
	 * @param string $description
	 */
	public function SetDescription($description){
		$this->description = (string) strip_tags($description);
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
	public function __construct($basicShareServiceUrl, $url, $title, $description = null){
		$this->basicShareServiceUrl = (string) $basicShareServiceUrl;
		$this->SetUrl($url);
		$this->SetTitle($title);
		$this->SetDescription($description);
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
	public abstract function GetShareServiceUrl();
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
}

?>
