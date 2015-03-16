<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once ("PathManager.php");

/**
 * Predstavlja apstraktni razred za vlastito razvijene CI knjiznice
 * @author Željko Tepšić
 * @version 1.0.0
 *
 */
abstract class CILibrary {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	protected $CI;
	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################
	
	
	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################
	
	public function __construct () {
		$this->CI = &get_instance();
	}

	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
	
	
}

?>