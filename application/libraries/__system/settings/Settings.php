<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once ("GeneralSettings.php");

class Settings {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	/**
	 * Opcenite konfuguracijske postavke
	 * @var GeneralSettings
	 */
	private static $general;
	
	/**
	 * Dohvaca opcenite konfiguracijske postavke
	 * @return GeneralSettings
	 */
	public function GetGeneral(){
		return self::$general;
	}
	
	/**
	 * Sadrzi instancu objekta
	 * @var string
	 */
	private static $instance;
	
    /**
     * Singleton methoda, za dohvacanje instance
     * @return Config
     */
    public static function Instance() {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
            
            self::$general = new GeneralSettings();
        }

        return self::$instance;
    }
	
	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################
	
	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################

	
	/**
	 * Privatni konstruktor. Sprecava direktno sttvaranje objekta
	 */
	final private function __construct(){
	}
	
	
  	/**
  	 * Sprecava stvaranje klonirane instance
  	 */
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }
	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
	
	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################
	
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################

}

?>