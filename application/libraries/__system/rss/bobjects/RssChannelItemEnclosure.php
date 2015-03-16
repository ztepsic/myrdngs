<?php

class RssChannelItemEnclosure {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	/**
	 * URL adresa
	 *
	 * @var string
	 */
	private $url;
	
	/**
	 * Dohvaca URL adresu
	 * 
	 * @return string
	 */
	public function GetUrl () {
		return (string) $this->url;
	}
	
	/**
	 * Postavlja URL adresu
	 * 
	 * @param string $url
	 */
	public function SetUrl ($url) {
		$this->url = (string) $url;
	}
	
	
	/**
	 * Tip
	 *
	 * @var string
	 */
	private $type;
	
	/**
	 * Dohvaca tip
	 * 
	 * @return string
	 */
	public function GetType () {
		return (string) $this->type;
	}
	
	/**
	 * Postavlja tip
	 * 
	 * @param string $type
	 */
	public function SetType ($type) {
		$this->type = (string) $type;
	}
	
	

	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################
	

	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################
	
	function __construct ($url, $type) {
		$this->url = $url;
		$this->type = $type;
	
	}
	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
}

?>