<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PathManager {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	const SHARED_VIEW_FOLDER = "_shared";
	const SYSTEM_FOLDER = "__system";
	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################
	

	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################
	
	public function __construct () {
		
	}
	

	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
	

	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################
	
	/**
	 * Dohvaca punu stazu do trazene datoteke u shared folderu
	 * @param $filePath - staza do trazene datoteke
	 * @return string
	 */
	public static function GetSharedPath($filePath){
		return self::SHARED_VIEW_FOLDER . "/" . $filePath;
	}
	
	/**
	 * Dohvaca punu stazu do trazene datoteke u system folderu
	 * @param $filePath - staza do trazene datoteke
	 * @return string
	 */
	public static function GetSystemPath($filePath){
		return self::SYSTEM_FOLDER . "/" . $filePath;
	}
	
	/**
	 * Dohvaca stazu do trazene datoteke
	 * @param $packageName - naziv paketa
	 * @param $filePath - naziv trazene datoteke
	 * @return string
	 */
	public static function GetPackagePath($packageName, $filePath){
		return $packageName . "/" . $filePath;
	}
	
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################

}

?>