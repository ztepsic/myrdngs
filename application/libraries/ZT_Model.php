<?php

/**
 * Razred koji predstavlja nadogradnju CI Model klase.
 * Definira apstraktne metode za stvaranje objekata i polja objekata koje
 * je potrebno implementirati.
 *
 */
abstract class ZT_Model extends Model {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################	
	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################
	
	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################

	/**
	 * Konstruktor
	 *
	 */
	public function __construct(){
		parent::Model();
	}

	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
	
	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################

	/**
	 * Stvara std_class objekt na temelju rezultata upita
	 *
	 * @param std_class $queryRow - jedna n-torka upita
	 * @param array $includes - imena ovisnosti razreda
	 * @return std_class
	 */
    abstract public function CreateObject($queryRow, $includes = null);

    /**
	 * Stvara polje std_class objekata na temelju rezultata upita
	 *
	 * @param std_class $queryResult - rezultati upita, vise n-torki
	 * @param array $includes - imena ovisnosti razreda
	 * @return std_class array - polje objekata
	 */
    abstract public function CreateObjectArray($QueryResult, $includes = null);
    
    // ###############################
	// ###### METHODS ##### END ######
	// ###############################



}


?>