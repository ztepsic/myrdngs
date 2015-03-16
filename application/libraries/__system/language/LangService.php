<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (LIBPATH . SYSPATH . "PathManager.php");

/**
 * Razred koji predstavlja servis za jezike, odnosno određivanje lokalizacije
 * @author Željko Tepšić
 *
 */
class LangService {

	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	const COOKIE_EXPIRATION = "2592000"; // 1 mjesec u sekundama
	
	const DEFAULT_LANG_CODE = "en"; // defaultni lang kod
	
	/**
	 * Referenca na CI sustav/knjiznicu
	 * @var unknown_type
	 */
	protected $CI;
	
	/**
	 * Instanca
	 * @var LangService
	 */
	private static $instance;
	
	/**
	 * Dohvaca instancu LangService
	 * @return LangService
	 */
	public static function GetInstance(){
		if(!isset(self::$instance)){
			self::$instance = new LangService();
		}
		
		return self::$instance;
	}
	
	/**
	 * Podrzani jezici
	 * @var $supportedLanguages array<string>
	 */
	private $supportedLanguages = array(self::DEFAULT_LANG_CODE);
	
	/**
	 * Dohvaca podrzane jezike
	 */
	public function GetSupportedLanguages(){
		return $this->supportedLanguages;
	}

	/**
	 * Sadrzi informaciju o jezicnom kodu
	 * @var string
	 */
	private $langCode;
	
	/**
	 * Dohvaca jezicni kod
	 */
	public function GetLangCode(){
		return $this->langCode;
	}
	
	public function SetLangCode($langCode){
		if(in_array($langCode, $this->supportedLanguages)){
			$this->langCode = $langCode;
		} else {
			throw new Exception("Unsupported language code - " . $langCode . ".");
		}
	}
	
	
	/**
	 * Da li je potreban redirect
	 * @var bool
	 */
	private $needToRedirect = false;
	
	/**
	 * Dohvaca da li je potreban redirect
	 * @return bool
	 */
	public function IsNeededRedirect(){
		return $this->needToRedirect;
	}

	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################

	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################

	/**
	 * Konstruktor
	 */
	private function __construct(){
		$this->CI = &get_instance();
		
		$this->CI->load->helper('cookie');
		$this->CI->load->library('user_agent');
		
		$this->supportedLanguages = array_merge($this->supportedLanguages, $this->CI->config->item("zt_supported_lang"));
		$this->supportedLanguages = array_unique($this->supportedLanguages);
		
		$this->DetermineLanguage();
	}
	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################

	
	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################
	
	/*
	 * Dohvaca defaultni lang code
	 * @return string
	 */
	public function GetDefaultLangCode(){
		$defaultSiteLangCode = $this->CI->config->item("zt_site_lang");
		return !empty($defaultSiteLangCode) ? $defaultSiteLangCode : self::DEFAULT_LANG_CODE;
	}
	
	/**
	 * Ukoliko postoji dohvaca primarni jezicni kod zajedno sa pod jezicnim kodom
	 * npr. en-US
	 * @return string
	 */
	public function GetPrimaryWithSubLangCode(){
		if($this->GetLangCode() === "en"){
			return "en-US";
		} else {
			return $this->GetLangCode();
		}
	}
	
	
	/**
	 * Dohvaca informaciju da li je trenutno odabran jezik ujedno defaultni jezik
	 * @return boolean
	 */
	public function IsDefaultSelected(){
		return $this->GetLangCode() === $this->GetDefaultLangCode();
	}
	
	/**
	 * Dohvaca jezik
	 */
	public function GetLanguage(){
		return $this->GetLanguageFromLangCode($this->GetLangCode());
	}
	
	/**
	 * Dohvaca prefix urla za odredeni jezik
	 */
	public function GetLangUrl(){
		return $this->getLangUrlFromLangCode($this->GetLangCode());
	}
	
	public function GetLangUrlFromLangCode($langCode){
		return $langCode === $this->GetDefaultLangCode() ? "" : $langCode . "/";
	}
	
	/**
	 * Dohvaca text/prijevod za kljuc
	 * @param string $key
	 * @return string text/prijevod
	 */
	public function GetText($key){
		return $this->CI->lang->line($key);
	}
	
	/**
	 * Dohvaca text/prijevod za zadni kljuc i kod jezika
	 * @param $key - kljuc za dohvacanje prijevoda
	 * @param $langCode - jezicni kod (na kojem jeziku ce biti prijevod)
	 */
	public function GetTextFromLangCode($key, $langCode){
		$lang = new CI_Language();
		$lang->load("site", $this->GetLanguageFromLangCode($langCode)); 
		return $lang->line($key);
	}
	
	/**
	 * Obavlja redirect na ispravan lang url
	 */
	public function RedirectToCorrectLangUrl(){
		$this->needToRedirect = false;
		redirect($this->GetLangUrl());
	}
	
	/**
	 * Odreduje jezik po sljedecem principu
	 * 1. Odrediti jezik iz sessiona/cookie
	 * 2. Odrediti jezik iz URL-a
	 * 3. Odrediti jezik iz browsera
	 */
	public function DetermineLanguage(){
		$urlLangCode = $this->getLangCodeFromUrl();
		$this->SetLangCode($urlLangCode);
		
		$cookieLangCode = $this->getLangCodeFromCookie();
		$browserLangCode = $this->getLangCodeFromBrowser();
		
		$isCookieSet = !empty($cookieLangCode);
		$isCookieDiffLangCode = $isCookieSet && $urlLangCode != $cookieLangCode ? true : false;
		$isBrowserLangDiff = !empty($browserLangCode) && $urlLangCode != $browserLangCode ? true : false; 
		
		// Ako je korisnik došao sa vanjske stranice na početnu stranicu te ako ima postavljan cookie jezicni kod koji se razlikuje
		// od jezicnog koda u URL-u potrebno je napraviti redirect na ispravan jezik ili 
		// ako je korisnik došao sa vanjske stranice na početnu stranicu te ako nema postavljen cookie jezični kod ali browser podržava
		// neki određeni jezični kod koji je različiti od jezičnog koda u URL-u potrebno je napraviti redirect na ispravan jezik
		if(($isCookieDiffLangCode || (!$isCookieSet && $isBrowserLangDiff))
			&& $this->isFromAnotherSite() 
			&& $this->isBaseUrl()){
				
			$isCookieSet ? $this->SetLangCode($cookieLangCode) : $this->SetLangCode($browserLangCode);
			$this->needToRedirect = true;
		}
		
		$this->SetLangCodeToCookie($this->GetLangCode());
		$this->CI->lang->load("site", $this->GetLanguage());
		
	}
	
	private function isBaseUrl(){
		$baseUrl =  base_url();
		$pattern = "#^" . $baseUrl . "(";
		$isFirst = true;
		foreach($this->supportedLanguages as $langCode){
			if($isFirst){
				$isFirst = false;
			} else {
				$pattern .= "|";
			}
			$pattern .= $langCode;
		}
		$pattern .= ")?/?$#";
		$currentUrl = current_url();
		$result = preg_match($pattern, $currentUrl, $matches);
		if($result == 1){
			return true;
		} else {
			return false;
		}
	}
	
	private function isFromAnotherSite(){
		$referer = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : "";
		$baseUrl = base_url();
		$pattern = "#(" . $baseUrl . "){1}.*#";
		$result = preg_match($pattern, $referer, $matches);
		return $result == 0 ? true : false;
	}
	
	/**
	 * Dohvaca jezicni kod iz browsera
	 * @return string
	 */
	private function getLangCodeFromBrowser(){
		$languages = array();	
	
		if((count($languages) == 0) AND isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) AND $_SERVER['HTTP_ACCEPT_LANGUAGE'] != ''){
			$languages = preg_replace('/(;q=[0-9\.]+)/i', '', strtolower(trim($_SERVER['HTTP_ACCEPT_LANGUAGE'])));
			$languages = explode(',', $languages);
		}
		
		foreach($this->supportedLanguages as $langCode){
			return (in_array(strtolower($langCode), $languages, TRUE)) ? $langCode : null;	
		}
		
		return null;
		
	}
	
	/**
	 * Dohvaca jezicni kod iz URL-a
	 * @return string
	 */
	private function getLangCodeFromUrl(){
		$urlLangCode = $this->CI->uri->segment(1);
		$pattern = "/^(";
		$isFirst = true;
		foreach($this->supportedLanguages as $langCode){
			if($isFirst){
				$isFirst = false;
			} else {
				$pattern .= "|";
			}
			$pattern .= $langCode;
		}
		$pattern .= "){1}$/";
		$result = preg_match($pattern, $urlLangCode, $matches);
		if($result == 1){
			return trim($urlLangCode);
		} else {
			// ako je URL prazan, odnosno nema jezika, onda je to defaultni jezik
			return $this->GetDefaultLangCode();
		}
	}
	
	
	/**
	 * Dohvaca jezicni kod iz cookie
	 * @return string
	 */
	private function getLangCodeFromCookie(){
		$langCode = get_cookie("language");

		if($langCode != false){
			return $langCode;	
		} else {
			return null;
		}
	}
	
	/**
	 * Postavlja jezicni kod u cookie
	 */
	public function SetLangCodeToCookie($langCode){
		if(in_array($langCode, $this->supportedLanguages)){
			$cookie = array(
                   "name"   => "language",
                   "value"  => $langCode,
                   "expire" => self::COOKIE_EXPIRATION
               );

			set_cookie($cookie); 
		} else {
			throw new Exception("Unsupported language code.");
		}
		
	}
	
	
	/**
	 * Dohvaca naziv jezika na temelju kratice
	 * @param $langCode
	 * @return string jezik
	 */
	public static function GetLanguageFromLangCode($langCode){
		
		if($langCode === "hr"){
			return "croatian";
		} else if($langCode === "es"){
			return "spanish";
		} else if($langCode === "fr"){
			return "french";
		} else if($langCode === "de"){
			return "german";
		} else if($langCode === "it"){
			return "italian";
		} else if($langCode === "ru"){
			return "russian";
		} else {
			return "english";
		}
		
	}



	// ###############################
	// ###### METHODS ##### END ######
	// ###############################

}

?>