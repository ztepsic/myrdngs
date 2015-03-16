<?php
require_once (LIBPATH . SYSPATH . "IStringRenderer.php");require_once (LIBPATH . SYSPATH . "/htmlComponents/object/param.php");require_once (LIBPATH . SYSPATH . "/htmlComponents/object/embed.php");
class Object implements IStringRenderer{
	// #################################	// ###### MEMBERS ##### BEGIN ######	// #################################
	/**	 * Sirina flasha u px	 * @var int	 */	private $width;
		/**	 * Dohvaca sirinu flasha	 * @return int	 */	public function GetWidth() {		return $this->width;	}
	/**	 * Postavlja sirinu flasha	 * @param int $width - sirina flasha	 */
	public function SetWidth($width) {		$this->width = (int) $width;	}
	
	/**
	 * Visina flasha u px
	 * @var int
	 */
	private $height;

	/**	 * Dohvaca visinu flasha	 * @return int	 */
	public function GetHeight() {
		return $this->height;
	}

	/**
	 * Postavlja visinu flasha
	 * @param int $height - visina flasha
	 */
	public function SetHeight($height) {
		$this->height = (int) $height;
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
	 * Parametri
	 * @var Param
	 */
	private $params;
	public function SetParams(array $params){
		$this->params = $params;
	}
	
	/**
	 * Embed
	 * @var Embed
	 */
	private $embed;
	public function GetEmbed(){
		return $this->embed;
	}
	public function SetEmbed(Embed $embed){
		$this->embed = $embed;
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
	 * Ostali atributi object taga - key: attribute name, value: attribute value
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
	public function __construct(Embed $embed = null){
		$this->param = array();
		$this->attributes = array();
		if(!empty($embed)){
			$this->width = $embed->GetWidth();
			$this->height = $embed->GetHeight();
			$this->embed = $embed;	
		}
	}
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################
	/**
	 * Dodaje parametre
	 * @param Param $param
	 */
	public function AddParam(Param $param){
		$this->params[] = $param;
	}
	
	/**	 * Dodaje atribut	 * @param string $key	 * @param string $value	 */
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

	/**	 * Iscrtavanje	 * @return string	 */
	public function Render(){		$object = '<object';
		if(!empty($this->id)){			$object .= ' id="' . $this->id . '"';			}
		if(!empty($this->class)){			$object .= ' class="' . $this->class . '"';			}
		if(!empty($this->width)){			$object .= ' width="' . $this->width . '"';			}
				if(!empty($this->height)){			$object .= ' height="' . $this->height . '"';			}
			if(!empty($this->type)){			$object .= ' type="' . $this->type . '"';			}
		foreach($this->attributes as $key => $attribute){			$object .= ' ' . $key . '="' . $attribute . '"';		}
		$object .= '>';
		foreach($this->params as $param){			$object .= "\n\t" . $param->Render();		}
				if(!empty($this->embed)){			$object .= "\n\t" . $this->embed->Render();			}
				$object .= "\n\t" . '</object>';
		return $object;
	}

	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
}

?>