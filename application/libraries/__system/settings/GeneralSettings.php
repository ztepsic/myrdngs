<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (LIBPATH . SYSPATH . "ci_library.php");

/**
 * Opcenita postavke.
 * Podatke dohvaca iz baze podataka, ukoliko baze nema podatke pokusava dohvatiti iz konfiguracijske datoteke
 * @author Željko Tepšić
 *
 */
class GeneralSettings extends CILibrary {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	/**
	 * Sadrzi informaciju da li je web sjediste omoguceno
	 * @var boolean
	 */
	private $isSiteEnabled;
	
	/**
	 * Dohvaca informaciju da li je web sjediste omoguceno
	 * @return boolean
	 */
	public function GetIsSiteEnabled() {
		return $this->isSiteEnabled;
		
	}
	
	/**
	 * Sadrzi naslov za onemoguceno web sjediste
	 * @var string
	 */
	private $siteDisabledTitle;
	
	/**
	 * Dohvaca naslov za onemoguceno web sjediste
	 * @return string
	 */
	public function GetSiteDisabledTitle(){
		return $this->siteDisabledTitle;
	}
	
	/**
	 * Sadrzi poruku za onemoguceno web sjediste
	 * @var string
	 */
	private $siteDisabledMsg;
	
	/**
	 * Dohvaca pruku za onemoguceno web sjediste
	 * @return string
	 */
	public function GetSiteDisabledMsg(){
		return $this->siteDisabledMsg;
	}
	
	
	/**
	 * Naziv web sjedista
	 * @var string
	 */
	private $siteTitle;
	
	/**
	 * Dohvaca naziv web sjedista
	 * @return string
	 */
	public function GetSiteTitle(){
		return $this->siteTitle;
	}
	
	
	/**
	 * Opis web sjedista
	 * @var string
	 */
	private $siteDescription;
	
	/**
	 * Dohvaca opis web sjedista
	 * @return string
	 */
	public function GetSiteDescription(){
		return $this->siteDescription;
	}
	
	/**
	 * Kljucne rijeci web sjedista
	 * @var string
	 */
	private $siteKeywords;
	
	/**
	 * Dohvaca kljucne rijeci web sjedista
	 * @return string
	 */
	public function GetSiteKeywords(){
		return $this-siteKeywords;
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
	public function __construct(){
		parent::__construct();
		
		// ako baze nema pokusaj sa konfiguracijskom datotekom
		$this->loadConfigFileData();
	}
	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
	
	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################
	
	/**
	 * Ucitava podatke iz konfiguracijske datoteke
	 * @return string
	 */
	private function loadConfigFileData(){
		$this->isSiteEnabled = $this->CI->config->item("zt_site_enabled");
		
	if($this->CI->config->item("zt_site_disabled_title")){
			$this->siteDisabledTitle = $this->CI->config->item("zt_site_disabled_title");	
		} else {
			throw new Exception("Config propery \"zt_site_disabled_title\" must be set.");
		}
		
		if($this->CI->config->item("zt_site_disabled_msg")){
			$this->siteDisabledMsg = $this->CI->config->item("zt_site_disabled_msg");	
		} else {
			throw new Exception("Config propery \"zt_site_disabled_msg\" must be set.");
		}
		
		if($this->CI->config->item("zt_site_title")){
			$this->siteTitle = $this->CI->config->item("zt_site_title");	
		} else {
			throw new Exception("Config propery \"zt_site_title\" must be set.");
		}
		
		if($this->CI->config->item("zt_site_description")){
			$this->siteDescription = $this->CI->config->item("zt_site_description");	
		} else {
			throw new Exception("Config propery \"zt_site_description\" must be set.");
		}
		
		if($this->CI->config->item("zt_site_keywords")){
			$this->siteKeywords = $this->CI->config->item("zt_site_keywords");
		} else {
			throw new Exception("Config propery \"zt_site_keywords\" must be set.");
		}

	}	
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################

}

?>