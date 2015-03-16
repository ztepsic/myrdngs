<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (LIBPATH . SYSPATH . "ci_library.php");
include_once (LIBPATH . SYSPATH . "IStringRenderer.php");
include_once (LIBPATH . SYSPATH . "htmlComponents/head/head_generator.php");

class Star_rating extends CILibrary implements IStringRenderer {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	/**
	 * Generator Head djela HTML dokumenta
	 * @var Head_generator
	 */
	private $headGenerator;
	
	/**
	 * Tekstualni zapis vrijednosti
	 * parovi key: redni broj vrijednosti, value: tekstualni zapis vrijednosti
	 * @var array<int, string>
	 */
	private $ratingNames;
	
	/**
	 * Vrijednosti za rating
	 * parovi key: redni broj vrijednosti, value: vrijednost
	 * @var array<int, mixed(int, string)>
	 */
	private $ratingValues;
	
	/**
	 * Info o tome da li je polje ratingNames za 1 vece od ratingValues 
	 * @var unknown_type
	 */
	private $isRatingNamesPlusOne;
	
	/**
	 * Vrijednost koja odreduje da li ce se rating racunati prema cijeli rating, half, quater
	 * @var int
	 */
	private $halfRatings;
	
	/**
	 * Da li je kontrola omogucena ili onemogucena
	 * @var boolean
	 */
	private $disabled;
	
	/**
	 * Dohvaca da li je kontrola omogucena ili onemogucena
	 * @return boolean
	 */
	public function GetDisabled(){
		return $this->disabled;
	}
	
	/**
	 * Postavlja info da li je kontrola omogucena ili onemogucena
	 * @param boolean $disabled
	 */
	public function SetDisabled($disabled){
		$this->disabled = (boolean) $disabled;
	}
	
	/**
	 * Trenutno odabrani rating
	 * @var mixed(int, string)
	 */
	private $rating;
	
	/**
	 * Dohvaca trenutni rating kontrole
	 * @return mixed(int, string)
	 */
	public function GetRating(){
		return $this->rating;
	}
	
	/**
	 * Postavlja trenutni rating kontrole
	 * @param mixed(int, float, string) $rating
	 */
	public function SetRating($rating){
		$this->rating = $this->calculateStarRatingValue($rating);
	}
	
	/**
	 * Naziv input-a
	 * @var string
	 */
	private $inputName;
	
	/**
	 * Class input-a
	 * @var string
	 */
	private $inputClass;
	
	public function GetRatingName(){
		if($this->ratingNames != null){
			$indexValue = array_search($this->rating, $this->ratingValues);
			if($indexValue !== false){
				if($this->isRatingNamesPlusOne){
					return $this->ratingNames[$indexValue+1];	
				} else {
					return $this->ratingNames[$indexValue];
				}
			} else {
				return $this->ratingNames[0];
			}
		} else {
			return null;
		}
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
	public function __construct(Head_generator $headGenerator, $ratingValues, $inputName, $ratingNames = null, $inputClass = "star", $halfRatings = 1){
		parent::__construct();
		
		$this->headGenerator = $headGenerator;
		
		if(is_array($ratingValues) && is_array($ratingNames)){
			$ratingValuesCount = count($ratingValues);
			$ratingNamesCount = count($ratingNames);
			
			if($ratingValuesCount + 1 == $ratingNamesCount){
				$this->isRatingNamesPlusOne = true;
			} else if($ratingValuesCount == $ratingNamesCount) {
				$this->isRatingNamesPlusOne = false;
			} else {
				throw new Exception("Arrays ratingValues and ratingNames has not having equals elements.");	
			}
		} else {
			$this->isRatingNamesPlusOne = false;
		}
		
		$this->ratingValues = $ratingValues;
		$this->ratingNames = $ratingNames;
		$this->halfRatings = $halfRatings;
		$this->inputClass = $inputClass;
		$this->inputName = $inputName;
		
		$this->rating = 0;
		$this->disabled = false;
		
		$this->populateHead();
	}
	
	private function populateHead(){
		$this->headGenerator->AddHeadLink(new Link("js/star-rating/jquery.rating.css"));
		$this->headGenerator->AddHeadScript(new Script("js/star-rating/jquery.rating.js"));
	}
	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
	
	
	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################
	
	/**
	 * Za predanu vrijednost rating-a vraca vrijednost ratinga za star rating kontrolu
	 * @param mixed $rating
	 * @return mixed
	 */
	private function calculateStarRatingValue($rating){
		if(is_float($rating)){
			$ratingOnTwoDecimals = round($rating, 2);
			$ratingOnZeroDecimals = round($ratingOnTwoDecimals, 0);
			return (int) $ratingOnZeroDecimals;	
		} else {
			return $rating;
		}
	}

	
	/**
	 * Iscrtavanje head djela HTML dokumenta
	 * @return string
	 */
	public function Render(){
		$disabled = '';
		if($this->disabled) {
			$disabled = 'disabled="disabled"';
		}
		
		$ratingControl = '';
		foreach ($this->ratingValues as $key => $ratingValue){
			$class = $this->inputClass;
			if($this->halfRatings > 1){
				$class .= '  {split:' . $this->halfRatings . '}';  
			}
			
			$title = '';
			if($this->ratingNames != null){
				if($this->isRatingNamesPlusOne){
					$title = 'title="' . $this->ratingNames[$key+1] . '"';	
				} else {
					$title = 'title="' . $this->ratingNames[$key] . '"';
				}
				
			}
			
			$checked = '';
			if($ratingValue == $this->rating){
				$checked = 'checked="checked"';
			}
			
			$ratingControl .= '<input name="' . $this->inputName . '" class="' . $class . '" type="radio"  value="' . $ratingValue . '" ' . $title . ' ' . $checked . ' ' . $disabled .' />'; 
		}
		
		return $ratingControl;
	}
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
}

?>
