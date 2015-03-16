<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (LIBPATH . SYSPATH . "ci_library.php");
require_once ("bobjects/Head.php") ;
include_once (LIBPATH . SYSPATH . "IStringRenderer.php");require_once(LIBPATH . SYSPATH . "language/LangService.php");
class Head_generator extends CILibrary implements IStringRenderer {	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	/**
	 * Head
	 * @var Head
	 */
	private $head;
	
	/**
	 * Postavlja head
	 *
	 * @param $head the $head to set
	 */
	public function SetHead ($head) {
		$this->head = $head;
	}			/**	 * Servis za jezik	 * @var $langService LangService	 */	private $langService;

	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################
	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################
	/**
	 * Konstruktor
	 * @param HeadModel $headModel - head model
	 */
	public function __construct (LangService $langService = null) {
		parent::__construct();
		$this->CI->load->helper('html');
		$this->head = new Head();		$this->langService =$langService;
		$this->init();
	}
	/**
	 * Inicijalizacija prije iscrtavanja
	 * Ucitava podatke iz konfiguracijske datoteke zt_config.php
	 */
	private function init(){
		$this->readDescriptionConfig();
		$this->readKeywordsConfig();
		$this->readMetaConfig();
		$this->readLinksConfig();
		$this->readScriptsConfig();
	}
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################
	/**
	 * Iscrtavanje head djela HTML dokumenta
	 * @return string
	 */
	public function Render(){
		if($this->head == null){
			throw new Exception("HeadModel can't be null.");
		}
		$this->appendMasterTitle();
		return $this->head->ToString();
	}
	
	/**
	 * Dodaje master naslov originalnom naslovu
	 * @return string
	 */
	private function appendMasterTitle(){
		$title = $this->head->GetTitle() != null ? $this->head->GetTitle() . " | " : "";		$titleExtension = "";		if(empty($this->langService) || $this->langService->IsDefaultSelected()){			$titleExtension = $this->CI->config->item("zt_site_title") . " - " . $this->CI->config->item("zt_site_slogan");			} else {			$titleExtension = $this->CI->config->item("zt_site_title") . " - " . $this->CI->config->item("zt_site_slogan_" . $this->langService->GetLangCode());		}		$title .= $titleExtension;
		return $this->head->SetTitle($title);
	}
	
	/**
	 * Ucitava meta podatak opisa iz konfiguracijske datoteke zt_config.php
	 */
	private function readDescriptionConfig(){		if(empty($this->langService) || $this->langService->IsDefaultSelected()){			if(empty($this->langService) || $this->CI->config->item("zt_site_description")){				$description = $this->CI->config->item("zt_site_description");				$this->head->SetDescription($description);			}			} else {			if($this->CI->config->item("zt_site_description_" . $this->langService->GetLangCode())){				$description = $this->CI->config->item("zt_site_description_" . $this->langService->GetLangCode());				if(empty($description)){					$description = $this->CI->config->item("zt_site_description");					}								$this->head->SetDescription($description);			}		}
	}
	/**
	 * Ucitava kljucne rijeci iz konfiguracijske zt_config.php datoteke
	 */
	private function readKeywordsConfig(){		if(empty($this->langService) || $this->langService->IsDefaultSelected()){			if($this->CI->config->item("zt_site_keywords")){				$keywords = $this->CI->config->item("zt_site_keywords");				$this->head->AddKeywords($keywords);			}		} else {			if($this->CI->config->item("zt_site_keywords_" . $this->langService->GetLangCode())){				$keywords = $this->CI->config->item("zt_site_keywords_" . $this->langService->GetLangCode());				if(empty($keywords)){					$keywords = $this->CI->config->item("zt_site_keywords");				}				$this->head->AddKeywords($keywords);			}		}
	}
	
	/**
	 * Cita podatke o meta podacima iz konfiguracijske datoeke zt_config.php
	 */
	private function readMetaConfig(){
		if($this->CI->config->item('zt_head_meta')){
			$metaTags = $this->CI->config->item('zt_head_meta');
			$meta = null;
			foreach($metaTags as $metaTag){
				if(isset($metaTag["type"])){					if(isset($metaTag["lang"]) && $metaTag["lang"] && !empty($this->langService)){						$meta = new Meta($metaTag["type"], $metaTag["name"], $this->langService->GetPrimaryWithSubLangCode());						} else {						$meta = new Meta($metaTag["type"], $metaTag["name"], $metaTag["content"]);						}
				} else {
					$meta = new Meta(Meta::TYPE_NAME, $metaTag["name"], $metaTag["content"]);
				}
				$this->head->AddMetaTag($meta);
			}
		}
	}
	private function readLinksConfig(){
		if($this->CI->config->item("zt_head_links")){
			$configLinks = $this->CI->config->item("zt_head_links");
			foreach($configLinks as $configLink){				if(isset($configLink["lang"]) && $configLink["lang"] && !empty($this->langService)){					$pathParts = pathinfo($configLink["href"]);					$link = new Link(						$pathParts["dirname"] .						"/" .						$pathParts["filename"] .						"_" .						$this->langService->GetLangCode() .						"." .						$pathParts["extension"]);					} else {					$link = new Link($configLink["href"]);					}
				if(isset($configLink["rel"])){
					$link->SetRel($configLink["rel"]);	
				}
				if(isset($configLink["type"])){
					$link->SetType($configLink["type"]);
				}
				if(isset($configLink["title"])){
					$link->SetTitle($configLink["title"]);
				}
				if(isset($configLink["media"])){
					$link->SetMedia($configLink["media"]);
				}
				$this->head->AddLink($link);
			}
		}
	}

	/**
	 * Cita script tag podatke iz konfiguracijske datoteke zt_config.php
	 */
	private function readScriptsConfig(){
		if($this->CI->config->item("zt_head_scripts")){
			$configScripts = $this->CI->config->item("zt_head_scripts");
			foreach($configScripts as $configScript){
				$script = new Script();
				if(isset($configScript["type"])){
					$script->SetType($configScript["type"]);
				}
				if(isset($configScript["src"])){
					if(isset($configScript["lang"]) && $configScript["lang"] && !empty($this->langService)){						$pathParts = pathinfo($configScript["src"]);						$scriptPath = 							$pathParts["dirname"] .							"/" .							$pathParts["filename"] .							"_" .							$this->langService->GetLangCode() .							"." .							$pathParts["extension"];						$script->SetSrc($scriptPath);					} else {						$script->SetSrc($configScript["src"]);						}	
				}
				if(isset($configScript["content"])){
					$script->SetContent($configScript["content"]);	
				}
				$this->head->AddScript($script);
			}
		}
	}
	
	// ##########################################
	// ###### HEAD METHODS ##### BEGIN ######
	// ##########################################
	/**
	 * Dodaje Headu kljucnu rijec
	 * @param string $keyword - kljucna rijec
	 */
	public function AddHeadKeyword($keyword){
		$this->head->AddKeyword($keyword);
	}

	/**
	 * Dodaje kljucne rijeci Headu u obliku stringa, gdje je svaka rijec odvojena zarezom
	 * @param string $keywords
	 */
	public function AddHeadKeywords($keywords){
		$this->head->AddKeywords($keywords);
	}
	/**
	 * Dodaje Headu meta tag
	 * @param Meta $meta - meta tag
	 */
	public function AddHeadMetaTag($meta){
		$this->head->AddMetaTag($meta);
	}

	/**
	 * Dodaje Headu link
	 * @param Link $link
	 */
	public function AddHeadLink(Link $link){
		$this->head->AddLink($link);
	}
	/**
	 * Dodaje Headu script tag podatke
	 * @param Script $script - script tag podaci
	 */
	public function AddHeadScript(Script $script){
		$this->head->AddScript($script);
	}
	/**
	 * Postavlja naslov web stranice
	 * @param $title the $title to set
	 */
	public function SetHeadTitle ($title) {
		$this->head->SetTitle($title);
	}
	/**
	 * Postavlja opis web stranice
	 * @param $description the $description to set
	 */
	public function SetHeadDescription ($description) {
		$this->head->SetDescription($description);
	}
	// ########################################
	// ###### HEAD METHODS ##### END ######
	// ########################################
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
}
?>