<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ZT CodeIgniter
 *
 *
 * @package		ZT CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2009, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Config Class
 *
 * This class contains functions that enable config files to be managed
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/config.html
 */
class ZT_Config extends CI_Config {
	
	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################
	
	/**
	 * Site URL
	 *
	 * @access public
	 * @param string	the URI string
	 * @param boolean $withUrlSufix - false bez URL sufiksa, true sa URL sufiksom
	 * @return string
	 */
	public function site_url($uri = '', $withUrlSuffix = false){
		if (is_array($uri))	{
			$uri = implode('/', $uri);
		}

		if ($uri == ''){
			return $this->slash_item('base_url').$this->item('index_page');
		} else {
			if($withUrlSuffix){
				$suffix = ($this->item('url_suffix') == FALSE) ? '' : $this->item('url_suffix');	
			} else {
				$suffix = "";
			}
			
			return $this->slash_item('base_url').$this->slash_item('index_page').trim($uri, '/').$suffix; 
		}
	}

	/**
	 * Site URL za staticki sadrzaj.
	 *  
	 *
	 * @access	public
	 * @param string/array $url - URL parametri
	 * @return	string
	 */
	public function static_url($url) {
		$staticUrls = $this->item("zt_static_urls");
		
		// ako nema parametara, obavi klasican site_url
		if(empty($staticUrls)){
			return $this->site_url($url);	
		}
		
		// prebroji koliko ima hostova, max broj dozvoljenih hostova je 15
		$numberOfStaticUrls = count($staticUrls);
		if($numberOfStaticUrls > 15){
			throw new Exception("Maximal number of static hostnames is 15");
		}
		
		
		// odredi nacin odredivanja hostova
		if(is_array($staticUrls[0])){
			$staticHostDetermination = "filetype";
		} else {
			$staticHostDetermination = "hash";
		}
		
		if ($staticHostDetermination == "hash") {
			return $this->hashStaticHostDetermination($url, $staticUrls);
		} else if($staticHostDetermination == "filetype") {
			return $this->filetypeStaticHostDetermination($url, $staticUrls);
		} else {
			throw new Exception("Parameter staticHostDetermination = $staticHostDetermination is not valid.");
		}
	}
	
	
	/**
	 * Odreduje staticke hostove na temelju parametara danih 
	 * @param $url - URL parametri
	 * @param $staticUrls - mapa ekstenzija = staticki host
	 * @return string - staticki host url
	 */
	private function filetypeStaticHostDetermination($url, $staticUrls){
		if (is_array($url)) {
			$serializedUrl = implode('/', $url);
		} else {
			$serializedUrl = $url;
		}
		
		
		$nbrOfMatch = 0;
		foreach($staticUrls as $staticUrl){
			$pattern = "/.*(" . $staticUrl["extensions"] . "){1}$/";
			$nbrOfMatch = preg_match($pattern , $url);
			if($nbrOfMatch > 0){
				return $staticUrl["host"].trim($url, '/');
			}
		}
		
		if($nbrOfMatch <= 0){
			return $this->site_url($url);
		}
		
	}
	
	/**
	 * Odreduje staticke hostove na temelju preslikavanja ekstenzija datoteka u staticki host
	 * @param $url - URL parametri
	 * @param $staticUrls - staticki hostovi
	 * @return string - staticki host url
	 */
	private function hashStaticHostDetermination($url, $staticUrls){
		if (is_array($url)) {
			$serializedUrl = implode('/', $url);
		} else {
			$serializedUrl = $url;
		}
		
		$urlDigest = md5($serializedUrl);
		$lastHexDigit = substr($urlDigest, -1);
		$numberOfStaticUrls = count($staticUrls);
		$staticNumber = hexdec($lastHexDigit) % $numberOfStaticUrls;
		
		$staticUrl = $staticUrls[$staticNumber];
		
		return $staticUrl.trim($serializedUrl, '/');
	}
	
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################


}

// END CI_Config class

/* End of file Config.php */
/* Location: ./system/libraries/Config.php */