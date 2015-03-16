<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once("letters_navigation_item.php");
require_once(LIBPATH . SYSPATH . "ci_library.php");
include_once (LIBPATH . SYSPATH . "IStringRenderer.php");

class Letters_navigation extends CILibrary implements IStringRenderer {

	/**
	 * Osnovna URI adresa za navigaciju slovima
	 *
	 * @var String
	 */
	private $baseUri;

	/**
	 * Da li se se prikazati 0-9 ili ne
	 *
	 * @var boolean
	 */
	private $showNum;

	/**
	 * Naziv navigacije
	 *
	 * @var String
	 */
	private $title;

	/**
	 * Polje djelova navigacije
	 *
	 * @var LettersNavigationItem
	 */
	private $items;
	
	
	/**
	 * Aktivno slovo
	 * @var string
	 */
	private $activeLetter;
	
	/**
	 * Dohvaca aktivno slovo
	 * @return string
	 */
	public function GetActiveLetter(){
		return $this->activeLetter;
	}
	
	/**
	 * Postavlja aktivno slovo
	 * @param string $activeLetter
	 */
	public function SetActiveLetter($activeLetter){
		$this->activeLetter = $activeLetter;
	}

	/**
	 * Konstruktor
	 *
	 * @param array $params - polje parametara
	 * 	- uri
	 *  - show_num - true/false
	 *
	 */
	public function __construct($params){
		if(!array_key_exists("uri", $params)){
			throw  new Exception("Wrong or non existing parameter uri");
		} else if(!array_key_exists("show_num", $params)){
			throw  new Exception("Wrong or non existing parameter show_num");
		} else if(!array_key_exists("title", $params)){
			throw  new Exception("Wrong or non existing parameter title");
		}
		
		parent::__construct();

    	$this->items = array();
		$this->title = $params["title"];
    	$this->uri = base_url() . $params["uri"];
    	$this->showNum = $params["show_num"];
    	$this->generateItems();

	}

	/**
	 * Generira djelove navigacije
	 *
	 */
	private function generateItems(){
		if($this->showNum){
			$letters = array("0-9", "A", "B", "C", "Č", "Ć", "D", "Dž", "Đ", "E", "F", "G", "H", "I", "J", "K", "L", "Lj", "M", "N", "Nj", "O", "P", "Q", "R", "S", "Š", "T", "U", "V", "W", "X", "Y", "Z", "Ž");
		} else {
			$letters = array("A", "B", "C", "Č", "Ć", "D", "Dž", "Đ", "E", "F", "G", "H", "I", "J", "K", "L", "Lj", "M", "N", "Nj", "O", "P", "Q", "R", "S", "Š", "T", "U", "V", "W", "X", "Y", "Z", "Ž");
		}


		foreach ($letters as $letter){
			$this->items[] = new LettersNavigationItem(
				$this->uri . hr_diacritic_url_title($letter, "dash", true),
				$letter
			);
		}

	}


	/**
	 * Iscrtavanje navigacija
	 *
	 * @return string - iscrtana navigacija
	 */
	public function Render(){
		$renderData['items'] = $this->items;
		$renderData['title'] = $this->title;
		$renderData['activeLetter'] = $this->activeLetter;
		return $this->CI->load->view(PathManager::GetSystemPath("letters_navigation/letters_navigation_view"), $renderData, true);

	}

	/**
	 * Pretvara URI slovo u pravo slovo
	 *
	 * @param String $uriLetter - slovo koje treba pretvoriti
	 * @return String
	 */
	public function ConvertUriLetter($uriLetter){
		$patterns = array();
		$replacements = array();

		$patterns[] = "zh";
		$replacements[] = "ž";


		$patterns[] = "cch";
		$replacements[] = "č";


		$patterns[] = "ch";
		$replacements[] = "ć";


		$patterns[] = "dj";
		$replacements[] = "đ";

		$patterns[] = "sh";
		$replacements[] = "š";


		$letter = str_replace($patterns, $replacements, $uriLetter);

		return $letter;

	}


}

?>