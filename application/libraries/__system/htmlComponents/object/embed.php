<?php

require_once (LIBPATH . SYSPATH . "IStringRenderer.php");

class Embed implements IStringRenderer{

	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	/**
	 * Sirina flasha u px
	 * @var int
	 */
	private $width;
	
	/**
	 * Dohvaca sirinu flasha
	 * @return int
	 */
	public function GetWidth() {
		return $this->width;
	}

	/**
	 * Postavlja sirinu flasha
	 * @param int $width - sirina flasha
	 */
	public function SetWidth($width) {
		$this->width = (int) $width;
	}
	
	/**
	 * Visina flasha u px
	 * @var int
	 */
	private $height;
	
	/**
	 * Dohvaca visinu flasha
	 * @return int
	 */
	public function GetHeight() {
		return $this->height;
	}

	/**
	 * Postavlja visinu flasha
	 * @param int $height - visina flasha
	 */
	public function SetHeight($height) {
		$this->width = (int) $height;
	}
	
	/**
	 * Defines the MIME type of data specified in the data attribute
	 * @var string
	 */
	private $type;
	
	/**
	 * Dohvaca Defines the MIME type of data specified in the data attribute
	 * @return string
	 */
	public function GetType(){
		return $this->type;
	}
	
	/**
	 * Postavlja Defines the MIME type of data specified in the data attribute
	 * @param string $type
	 */
	public function SetType($type){
		$this->type = (string) $type;
	}
	
	
	/**
	 * URL of resource to be embedded
	 * @var string
	 */
	private $src;
	
	public function SetSrc($src){
		$this->src = (string) $src;
	}
	
	/**
	 * Identifikator
	 * @var string
	 */
	private $id;
	
	/**
	 * Postavlja identifikator
	 * @param string $id
	 */
	public function SetId($id){
		$this->id = $id;
	}
	
	/**
	 * Class
	 * @var string
	 */
	private $class;
	
	/**
	 * Postavlja class
	 * @param string $class
	 */
	public function SetClass($class){
		$this->class = $class;
	}
	
	/**
	 * Ostali atributi - key: attribute name, value: attribute value
	 * @var array<string, string>
	 */
	private $attributes;
	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################
	
	
	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################
	
	/**
	 * Konstruktor
	 */
	public function __construct($src, $width, $height){
		$this->src = $src;
		$this->width = $width;
		$this->height = $height;
		
		$this->SetType("application/x-shockwave-flash");
		
		$this->attributes = array();
	}
	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
	
	
	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################
	
	/**
	 * Dodaje atribut
	 * @param string $key
	 * @param string $value
	 */
	public function AddAttribute($key, $value){
		$this->attributes[$key] = $value;
	}
	
	/**
	 * Dodaje atribute
	 * @param array<string, string> $attributes
	 */
	public function AddAttributes($attributes){
		$this->attributes = array_merge($this->attributes, $attributes);
	}

	
	/**
	 * Iscrtavanje
	 * @return string
	 */
	public function Render(){
		$embed = '<embed';
		
		if(!empty($this->id)){
			$embed .= ' id="' . $this->id . '"';	
		}
		
		if(!empty($this->class)){
			$embed .= ' class="' . $this->class . '"';	
		}
		
		if(!empty($this->width)){
			$embed .= ' width="' . $this->width . '"';	
		}
		
		if(!empty($this->height)){
			$embed .= ' height="' . $this->height . '"';	
		}
		
		if(!empty($this->type)){
			$embed .= ' type="' . $this->type . '"';	
		}
		
		if(!empty($this->src)){
			$embed .= ' src="' . $this->src . '"';	
		}
		
		foreach($this->attributes as $key => $attribute){
			$embed .= ' ' . $key . '="' . $attribute . '"';
		}
		
		$embed .= ' />';
		
		return $embed;
	}
	
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
}

?>