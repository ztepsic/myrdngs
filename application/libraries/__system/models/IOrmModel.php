<?php

/**
 * Sucelje za objektno relacijsko mapiranje. Definira metode za stvaranje objekata i polja objekata koje
 * je potrebno implementirati.
 * @author Željko Tepšić <ztepsic@gmail.com>
 * @since 2009-12-22
 * @version 1.0.0
 *
 */
interface IOrmModel {
	
	/**
	 * Stvara std_class objekt na temelju rezultata upita
	 *
	 * @param std_class $queryRow - jedna n-torka upita
	 * @param array $includes - imena ovisnosti razreda
	 * @return std_class
	 */
    public function CreateObject($queryRow, $includes = null);

    /**
	 * Stvara polje std_class objekata na temelju rezultata upita
	 *
	 * @param std_class $queryResult - rezultati upita, vise n-torki
	 * @param array $includes - imena ovisnosti razreda
	 * @return std_class array - polje objekata
	 */
    public function CreateObjectArray($QueryResult, $includes = null);
    
}

?>