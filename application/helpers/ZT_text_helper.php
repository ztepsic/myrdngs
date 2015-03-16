<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Character Limiter
 *
 * Limits the string based on the character count.  Preserves complete words
 * so the character count may not be exactly as specified.
 *
 * @access	public
 * @param	string
 * @param	integer
 * @param	string	the end character. Usually an ellipsis
 * @return	string
 */	
if ( ! function_exists('character_limiter')) {
	function character_limiter($str, $n = 500, $end_char = '&#8230;') {
		$n -= mb_strlen($end_char);
		
		if (mb_strlen($str) < $n) {
			return $str;
		}
		
		$str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));

		if (mb_strlen($str) <= $n) {
			return $str;
		}

		$lastGoodOut = "";
		$iterationOut = "";
		foreach (explode(' ', trim($str)) as $val) {
			$iterationOut .= $val.' ';
			
			if (mb_strlen($iterationOut) >= $n) {
				$lastGoodOut = trim($lastGoodOut);
				return (mb_strlen($lastGoodOut) == mb_strlen($str)) ? $lastGoodOut : $lastGoodOut.$end_char;
			} else {
				$lastGoodOut = $iterationOut;
			}		
		}
	}
}