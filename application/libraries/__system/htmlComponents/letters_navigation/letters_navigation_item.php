<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Predstavlja dio navigacije slovima
 *
 */
class LettersNavigationItem {


	/**
	 * Adresa na koju ce pokazivati navigacija
	 *
	 * @var string
	 */
	private $uri;

	/**
	 * Dohvaca URI
	 *
	 * @return string
	 */
	public function GetUri(){
		return $this->uri;
	}

	/**
	 * Postavlja URI
	 *
	 * @param unknown_type $uri
	 */
	public function SetUri($uri){
		$this->uri = $uri;
	}


	/**
	 * Naziv linka
	 *
	 * @var unknown_type
	 */
	private $title;

	/**
	 * Dohvaca naziv
	 *
	 * @return unknown
	 */
	public function GetTitle(){
		return $this->title;
	}

	/**
	 * Postavlja naziv
	 *
	 * @param string $title
	 */
	public function SetTitle($title){
		$this->title = $title;
	}


	public function __construct($uri, $title){
		$this->uri = $uri;
		$this->title = $title;

	}

}

?>