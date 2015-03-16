<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('latinDerivedCharactersWebEnabled')) {
	function latinDerivedCharactersWebEnabled($string) {
		$patterns = array();
		$replacements = array();
		
		/*
			Á 	À 	Â 	Ä 	Ǎ 	Ă 	Ā 	Ã 	Å 	Ǻ 	Ą 	Æ 	Ǽ 	Ǣ 	Ɓ 	Ć 	Ċ 	Ĉ 	Č 	Ç 	Ď 	Ḍ 	Đ 	Ɗ 	Ð 	É 	È 	Ė 	Ê 	Ë 	Ě 	Ĕ 	Ē 	Ę 	Ẹ 	Ǝ 	Ə 	Ɛ 	Ġ 	Ĝ 	Ǧ 	Ğ 	Ģ 	Ɣ
			á 	à 	â 	ä 	ǎ 	ă 	ā 	ã 	å 	ǻ 	ą 	æ 	ǽ 	ǣ 	ɓ 	ć 	ċ 	ĉ 	č 	ç 	ď 	ḍ 	đ 	ɗ 	ð 	é 	è 	ė 	ê 	ë 	ě 	ĕ 	ē 	ę 	ẹ 	ǝ 	ə 	ɛ 	ġ 	ĝ 	ǧ 	ğ 	ģ 	ɣ
		 */
		
		$patterns[] = "Ë";
		$replacements[] = "E";

		$patterns[] = "ë";
		$replacements[] = "e";
		
		$patterns[] = "É";
		$replacements[] = "E";

		$patterns[] = "é";
		$replacements[] = "e";
		
		$patterns[] = "Č";
		$replacements[] = "C";

		$patterns[] = "č";
		$replacements[] = "c";

		$patterns[] = "Ć";
		$replacements[] = "C";

		$patterns[] = "ć";
		$replacements[] = "c";

		$patterns[] = "Đ";
		$replacements[] = "D";

		$patterns[] = "đ";
		$replacements[] = "d";
		
		$patterns[] = "Å";
		$replacements[] = "A";
		
		$patterns[] = "å";
		$replacements[] = "a";
		
		$patterns[] = "Ä";
		$replacements[] = "A";
		
		$patterns[] = "ä";
		$replacements[] = "a";
		
		$patterns[] = "Â";
		$replacements[] = "A";
		
		$patterns[] = "â";
		$replacements[] = "a";
		
		$patterns[] = "À";
		$replacements[] = "A";
		
		$patterns[] = "à";
		$replacements[] = "a";
		
		$patterns[] = "Á";
		$replacements[] = "A";
		
		$patterns[] = "á";
		$replacements[] = "a";
		
		$patterns[] = "ă";
		$replacements[] = "a";
		
		
		/*
		 	Ĥ 	Ḥ 	Ħ 	I 	Í 	Ì 	İ 	Î 	Ï 	Ǐ 	Ĭ 	Ī 	Ĩ 	Į 	Ị 	Ĳ 	Ĵ 	Ķ 	Ƙ 	Ĺ 	Ļ 	Ľ 	Ŀ 	ʼN 	Ń 	N̈ 	Ň 	Ñ 	Ņ 	Ŋ 	Ó 	Ò 	Ô 	Ö 	Ǒ 	Ŏ 	Ō 	Õ 	Ő 	Ọ 	Ø 	Ǿ 	Ơ 	Œ
			ĥ 	ḥ 	ħ 	ı 	í 	ì 	i 	î 	ï 	ǐ 	ĭ 	ī 	ĩ 	į 	ị 	ĳ 	ĵ 	ķ 	ƙ 	ĺ 	ļ 	ľ 	ŀ 	ŉ 	ń 	n̈ 	ň 	ñ 	ņ 	ŋ 	ó 	ò 	ô 	ö 	ǒ 	ŏ 	ō 	õ 	ő 	ọ 	ø 	ǿ 	ơ 	œ
		 */
		
		
		$patterns[] = "Ł";
		$replacements[] = "L";
		
		$patterns[] = "ł";
		$replacements[] = "l";
		
		$patterns[] = "Ó";
		$replacements[] = "O";
		
		$patterns[] = "ó";
		$replacements[] = "o";
		
		$patterns[] = "Ö";
		$replacements[] = "O";
		
		$patterns[] = "ö";
		$replacements[] = "o";
		
		$patterns[] = "Ï";
		$replacements[] = "I";
		
		$patterns[] = "ï";
		$replacements[] = "i";
		
		
		/*
		 	Ŕ 	Ř 	Ŗ 	Ś 	Ŝ 	Š 	Ş 	Ș 	Ṣ 	ẞ 	Ť 	Ţ 	Ṭ 	Ŧ 	Þ 	Ú 	Ù 	Û 	Ü 	Ǔ 	Ŭ 	Ū 	Ũ 	Ű 	Ů 	Ų 	Ụ 	Ư 	Ẃ 	Ẁ 	Ŵ 	Ẅ 	Ƿ 	Ý 	Ỳ 	Ŷ 	Ÿ 	Ȳ 	Ỹ 	Ƴ 	Ź 	Ż 	Ž 	Ẓ
			ŕ 	ř 	ŗ 	ś 	ŝ 	š 	ş 	ș 	ṣ 	ß 	ť 	ţ 	ṭ 	ŧ 	þ 	ú 	ù 	û 	ü 	ǔ 	ŭ 	ū 	ũ 	ű 	ů 	ų 	ụ 	ư 	ẃ 	ẁ 	ŵ 	ẅ 	ƿ 	ý 	ỳ 	ŷ 	ÿ 	ȳ 	ỹ 	ƴ 	ź 	ż 	ž 	ẓ
		 */
		
		$patterns[] = "Ż";
		$replacements[] = "Z";
		
		$patterns[] = "ż";
		$replacements[] = "z";
		
		$patterns[] = "Ů";
		$replacements[] = "ů";
		
		$patterns[] = "ü";
		$replacements[] = "u";
		
		$patterns[] = "Ü";
		$replacements[] = "U";
		
		$patterns[] = "ü";
		$replacements[] = "u";
		
		$patterns[] = "Š";
		$replacements[] = "S";

		$patterns[] = "š";
		$replacements[] = "s";
		
		$patterns[] = "Ž";
		$replacements[] = "Z";

		$patterns[] = "ž";
		$replacements[] = "z";
		

		$newString = str_replace($patterns, $replacements, $string);

		return $newString;
	}
}

/**
 * Create URL Title
 *
 * Takes a "title" string as input and creates a
 * human-friendly URL string with either a dash
 * or an underscore as the word separator.
 *
 * @access	public
 * @param	string	the string
 * @param	string	the separator: dash, or underscore
 * @return	string
 */
if(!function_exists('url_title')){
	function url_title($str, $separator = 'dash', $lowercase = FALSE) {
		$str = trim($str);
		$latinDerivedCharactersWebEnabled = latinDerivedCharactersWebEnabled($str);
		
		$str = $latinDerivedCharactersWebEnabled;
		
		if ($separator == 'dash') {
			$search		= '_';
			$replace	= '-';
		} else {
			$search		= '-';
			$replace	= '_';
		}

		$trans = array(
						'&\#\d+?;'				=> '',
						'&\S+?;'				=> '',
						'\s+'					=> $replace,
						'[^a-z0-9\-\._]'		=> '',
						$replace.'+'			=> $replace,
						$replace.'$'			=> $replace,
						'^'.$replace			=> $replace,
						'\.+$'					=> ''
					  );

		$str = strip_tags($str);

		foreach ($trans as $key => $val) {
			$str = preg_replace("#".$key."#i", $val, $str);
		}

		if ($lowercase === TRUE){
			$str = strtolower($str);
		}
		
		return trim(stripslashes($str));
	}
}


if ( ! function_exists('hrCharactersWebEnabledDiacritic')) {
	function hrCharactersWebEnabledDiacritic($string) {
		$patterns = array();
		$replacements = array();

		$patterns[] = "Ž";
		$replacements[] = "ZH";

		$patterns[] = "ž";
		$replacements[] = "zh";

		$patterns[] = "Č";
		$replacements[] = "CCH";

		$patterns[] = "č";
		$replacements[] = "cch";

		$patterns[] = "Ć";
		$replacements[] = "CH";

		$patterns[] = "ć";
		$replacements[] = "ch";

		$patterns[] = "Đ";
		$replacements[] = "DJ";

		$patterns[] = "đ";
		$replacements[] = "dj";

		$patterns[] = "Š";
		$replacements[] = "SH";

		$patterns[] = "š";
		$replacements[] = "sh";


		$newString = str_replace($patterns, $replacements, $string);

		return $newString;
	}
}

if ( ! function_exists('hr_diacritic_url_title')) {
	function hr_diacritic_url_title($string, $delimiter = "dash", $forcedLowercase = FALSE) {
		$string = trim($string);
		$hrCharactersWebEnabled = hrCharactersWebEnabledDiacritic($string);
		$newString = url_title($hrCharactersWebEnabled, $delimiter, $forcedLowercase);

		return $newString;
	}
}

/**
 * @deprecated Koristiti url_title
 */
if ( ! function_exists('hr_url_title')) {
	function hr_url_title($string, $delimiter = "dash", $forcedLowercase = TRUE) {
		$string = trim($string);
		$newString = url_title($string, $delimiter, $forcedLowercase);

		return $newString;
	}
}

/**
 * Za zadani alias i id, vraca pogodan url oblik
 */
if ( ! function_exists('aliasid_url_title')) {
	function aliasid_url_title($string, $id, $aliasIdDelimiter = "slash", $delimiter = "dash", $urlTitleType = "hr_url_title", $forcedLowercase = TRUE) {
		$string = trim($string);
		if($urlTitleType == "hr_url_title"){
			$alias = hr_url_title($string, $delimiter, $forcedLowercase);
		} else if($urlTitleType == "hr_diacritic_url_title"){
			$alias = hr_diacritic_url_title($string, $delimiter, $forcedLowercase);
		} else {
			$alias = url_title($string, $delimiter, $forcedLowercase);
		}
		
		$aliasIdString = "";
		if($aliasIdDelimiter == "slash"){
			$aliasIdString = $alias . "/" . $id;
		} else if($aliasIdDelimiter == "dash") {
			$aliasIdString = $alias . "-" . $id;
		} else if($aliasIdDelimiter == "underscore"){
			$aliasIdString = $alias . "_" . $id;
		}
		
		return $aliasIdString;
		
	}
}

/**
 * Za zadani id i alias, vraca pogodan url oblik
 */
if ( ! function_exists('idalias_url_title')) {
	function idalias_url_title($id, $string, $aliasIdDelimiter = "slash", $delimiter = "dash", $urlTitleType = "hr_url_title", $forcedLowercase = TRUE) {
		$string = trim($string);
		if($urlTitleType == "hr_url_title"){
			$alias = hr_url_title($string, $delimiter, $forcedLowercase);
		} else if($urlTitleType == "hr_diacritic_url_title"){
			$alias = hr_diacritic_url_title($string, $delimiter, $forcedLowercase);
		} else {
			$alias = url_title($string, $delimiter, $forcedLowercase);
		}
		
		$aliasIdString = "";
		if($aliasIdDelimiter == "slash"){
			$aliasIdString = $id . "/" . $alias;
		} else if($aliasIdDelimiter == "dash") {
			$aliasIdString = $id . "-" . $alias;
		} else if($aliasIdDelimiter == "underscore"){
			$aliasIdString = $id . "_" . $alias;
		}
		
		return $aliasIdString;
		
	}
}

/**
 * Za zadani dio url-a vraca identifikator para alias-id
 */
if ( ! function_exists('get_id_dashed_aliasid_url_title')) {
	function get_id_dashed_aliasid_url_title($string) {
		$pattern = "/[0-9]+$/";
		preg_match($pattern, $string, $matches);
		if(isset($matches[0])){
			return $matches[0];
		} else {
			return 0;
		}
	}
}


/**
 * Site URL za staticki sadrzaj
 *
 * Create a local URL based on your basepath. Segments can be passed via the
 * first parameter either as a string or an array.
 *
 * @access	public
 * @param	string
 * @return	string
 */
if ( ! function_exists('static_url')) {
	function static_url($url) {
		$CI =& get_instance();
		return $CI->config->static_url($url);
	}
}

/**
 * Site URL
 *
 * Create a local URL based on your basepath. Segments can be passed via the
 * first parameter either as a string or an array.
 *
 * @access	public
 * @param	string
 * @return	string
 */
if ( ! function_exists('site_url'))
{
	function site_url($uri = '', $withUrlSuffix = false)
	{
		$CI =& get_instance();
		return $CI->config->site_url($uri, $withUrlSuffix);
	}
}


/**
 * Za zadani url vraca njegov host dio url-a
 */
if ( ! function_exists('host_url')) {
	function host_url($url) {
		$parsedUrlArray = parse_url($url);
		$host = isset($parsedUrlArray["host"]) ? $parsedUrlArray["host"] : "";
		return $host;
	}
}

?>