<?php

require_once (LIBPATH . SYSPATH . "IStringRenderer.php");

class Param implements IStringRenderer{

	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	/**
	 * Defines the name for a parameter (to use in script)
	 * @var string
	 */
	private $name;
	
	
	/**
	 * Specifies the value of a parameter
	 * @var string
	 */
	private $value;
	
	/**
	 * Specifies the MIME type for a parameter 
	 * @var unknown_type
	 */
	private $type;
	

	/**
	 * Specifies the type of the value
	 * data, ref or object
	 * @var string
	 */
	private $valueType;
	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################
	
	
	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################
	
	/**
	 * Konstruktor
	 */
	public function __construct($name, $value = null, $type = null, $valueType = null){
		$this->name = $name;
		$this->value = $value;
		$this->type = $type;
		$this->valueType = $valueType;
	}
	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
	
	
	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################
	
	/**
	 * Iscrtavanje
	 * <param name="Max" value="10" />
	 * @return string
	 */
	public function Render(){
		$param = '<param ';
		
		$param .= 'name="' . $this->name . '" ';
		
		if(isset($this->value)){
			$param .= 'value="' . $this->value . '" ';	
		}
		
		if(!empty($this->type)){
			$param .= 'type="' . $this->type . '" ';	
		}
		
		if(!empty($this->valueType)){
			$param .= 'valuetype="' . $this->valueType . '" ';	
		}
		
		$param .= '/>';
		
		return $param;
	}
	
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
}

?>