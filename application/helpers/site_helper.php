<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Helper za opcenite stvari vezane za web site 
 * 
 * 
 * 
 */
/**
 * Dohvaca tekstualni zapis postojanja web stranice u godinama.
 * U obliku pocetna godina - trenutna godina
 *
 * @param string $since - datum postojanja stranice
 * @return string
 */
if ( ! function_exists('site_existance')) {
	function site_existance() {
		return date("Y", time());
	}
}

