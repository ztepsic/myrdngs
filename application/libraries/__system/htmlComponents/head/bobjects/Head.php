<?php

require_once("Meta.php");
require_once("Link.php");
require_once("Script.php");

/**
 * Predstavlja model head djela HTML dokumenta
 * @author Željko Tepšić
 * @version 1.0.0
 *
 */
class Head {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	/**
	 * Naslov web stranice
	 * @var string
	 */
	private $title;
	
	/**
	 * Postavlja naslov web stranice
	 * @param $title the $title to set
	 */
	public function SetTitle ($title) {
		$this->title = $title;
	}

	/**
	 * Dohvaca naslov web stranice
	 * 
	 * @return string $title
	 */
	public function GetTitle () {
		return $this->title;
	}
	
	
	/**
	 * Meta tag opisa web stranice
	 * @var string
	 */
	private $description;
	
	/**
	 * Postavlja opis web stranice
	 * @param $description the $description to set
	 */
	public function SetDescription ($description) {
		$this->description = $description;
	}

	/**
	 * Dohvaca opis web stranice
	 * @return string $description
	 */
	public function GetDescription () {
		return $this->description;
	}
	
	
	/**
	 * Kljucne rijeci web stranice
	 * 
	 * @var string array
	 */
	private $keywords = array();
	
	/**
	 * Dohvaca kljucne rijeci web stranice
	 * @return string
	 */
	public function GetKeywords(){
		return $this->keywords;
	}
	
	/**
	 * Postavlja polje kljucnih rijeci
	 * @param array $keywords - kljucne rijeci
	 */
	public function SetKeywords(array $keywords){
		$this->keywords = $keywords;
	}

	
	/**
	 * Sadrzi meta tagove web stranice.
	 * Kljuc je atribut name, a vrijednost je atrubut content
	 * @var associative Meta array
	 */
	private $metaTags = array();
	
	/**
	 * Postavlja polje meta tagova
	 * 
	 * @param $metaTags the $metaTags to set
	 */
	public function SetMetaTags (array $metaTags) {
		$this->metaTags = $metaTags;
	}

	/**
	 * Dohvaca polje meta tagova
	 * 
	 * @return the $metaTags
	 */
	public function GetMetaTags () {
		return $this->metaTags;
	}
	
	
	/**
	 * Linkovi dokumenata
	 * @var Link array
	 */
	private $links = array();
	
	/**
	 * Postavlja linkove dokumenta
	 * 
	 * @param $links the $links to set
	 */
	public function SetLinks (array $links) {
		$this->links = $links;
	}

	/**
	 * Dohvaca linkove dokumenta
	 * 
	 * @return the $links
	 */
	public function GetLinks () {
		return $this->links;
	}
	
	
	/**
	 * Sadrzi script tag podatke
	 * @var array<Script>
	 */
	private $scripts = array();
	
	/**
	 * Postavlja polje script tag podataka
	 * 
	 * @param $scripts the $scripts to set
	 */
	public function SetScripts (array $scripts) {
		$this->scripts = $scripts;
	}

	/**
	 * Dohvaca polje script tag podataka
	 * 
	 * @return the $scripts
	 */
	public function GetScripts () {
		return $this->scripts;
	}
	
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
	 * Dodaje kljucnu rijec
	 * @param string $keyword - kljucna rijec
	 */
	public function AddKeyword($keyword){
		$this->keywords[] = $keyword;
	}
	
	/**
	 * Dodaje kljucne rijeci u obliku stringa, gdje je svaka rijec odvojena zarezom
	 * @param string $keywords
	 */
	public function AddKeywords($keywords){
		$keywordsExplode = explode(",", $keywords);
			
		$keywords = array();
		foreach($keywordsExplode as $keywordExplode){
			$this->AddKeyword(trim($keywordExplode));
		}
		
	}
	
	/**
	 * Dohvaca kljucnu rijec za zadani index
	 * @param int $index - zadani index
	 * @return string - kljucna rijec
	 */
	public function GetKeyword($index){
		return $this->keywords[$index];
	}
	
	/**
	 * Dodaje meta tag
	 * @param Meta $meta - meta tag
	 */
	public function AddMetaTag($meta){		foreach($this->metaTags as $existingMeta){			if($existingMeta->GetType() == $meta->GetType() && $existingMeta->GetTypeValue() == $meta->GetTypeValue()){				$existingMeta->SetContent($meta->GetContent());				return;			}		}				$this->metaTags[] = $meta;
	}
	
	
	/**
	 * Dodaje link
	 * @param Link $link
	 */
	public function AddLink(Link $link){
		$this->links[] = $link;
	}
	
	
	/**
	 * Dodaje script tag podatke
	 * @param Script $script - script tag podaci
	 */
	public function AddScript(Script $script){
		$this->scripts[] = $script;
	}
	
	/**
	 * Generiranje prikaza naslova
	 * @return string
	 */
	public function RenderTitle(){			
		return "<title>" . $this->title . "</title>\n";
	}
	
	/**
	 * Generiranje prikaza meta naslova
	 * @return string
	 */
	public function RenderMetaTitle(){		
		return meta("title", htmlspecialchars($this->title));
	}

	/**
	 * Generiranje prikaza opisa
	 * @return string
	 */
	public function RenderDescription(){
		return meta("description", htmlspecialchars($this->description));
	}
	
	/**
	 * Generiranje kljucnih rijeci
	 * @return string
	 */
	public function RenderKeywords(){
		$keywordsCount = count($this->keywords);
		if($keywordsCount == 0){
			return null;
		}
		
		$keywordsSequence = "";
		for($i=0; $i < $keywordsCount; $i++){
			$keywordsSequence .= $this->keywords[$i];
			
			if($i >= 0 && $i < $keywordsCount - 1){
				$keywordsSequence .= ", ";
			}
		}
		
		// <meta name="keywords" content="lektire, knjige, pisci, lektira, srednja, srednju, osnovna, osnovnu, škola, školu, download" />
		$meta = meta('keywords', $keywordsSequence);
		
		return $meta;
	}
	
	/**
	 * Generiranje prikaza meta tagova
	 * @return string
	 */
	public function RenderMetaTags(){
		$metaTagsCount = count($this->metaTags);
		if($metaTagsCount == 0){
			return null;
		}
		
		$metaTagsBuilder = "";
		foreach ($this->metaTags as $metaTag){
			$metaTagsBuilder .= $metaTag->ToString();
		}
		
		return $metaTagsBuilder;		
		
	}
	
	
	/**
	 * Generiranje prikaza css datoteka
	 * @return string
	 */
	public function RenderLinks(){
		$linksCount = count($this->links);
		if($linksCount == 0){
			return null;
		}
		
		$linksBuilder = "";
		foreach($this->links as $link){		
			$linksBuilder .= $link->ToString();
		}
		
		return $linksBuilder;
	}
		
	/**
	 * Generiranje prikaza js datoteka
	 * @return string
	 */
	public function RenderScripts(){
		$scriptsCount = count($this->scripts);
		if($scriptsCount == 0){
			return null;
		}
		
		$scriptsBuilder = "";
		foreach($this->scripts as $script){
			$scriptsBuilder .= $script->ToString();
		}
		
		return $scriptsBuilder;
	}
	
	/**
	 * Pretvaranje Head objekta u znakovni zapis
	 * @return string
	 */
	public function ToString(){
		$head = "";
		
		$head .= $this->RenderTitle();
		$head .= $this->RenderMetaTitle();
		$head .= $this->RenderDescription();
		$head .= $this->RenderKeywords();
		$head .= $this->RenderMetaTags();
		$head .= $this->RenderLinks();
		$head .= $this->RenderScripts();
		
		return $head;
	}

	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
}

?>