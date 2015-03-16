<?php

class RssChannelImage {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	/**
	 * URL adresa GIF, JPEG ili PNG slike koja predstavlja kanal
	 *
	 * @var string
	 */
	private $url;
	
	/**
	 * Dohvaca URL adresu slike
	 * 
	 * @return string
	 */
	public function GetUrl () {
		return $this->url;
	}
	
	/**
	 * Postavlja URL adresu slike
	 * 
	 * @param string $url
	 */
	public function SetUrl ($url) {
		$this->url = $url;
	}
	
	
	/**
	 * Opisuje sliku. Sadrzaj se koristi u ALT HTML atributu.
	 *
	 * @var string
	 */
	private $title;
	
	/**
	 * Dohvaca opis slike
	 * 
	 * @return string
	 */
	public function GetTitle () {
		return $this->title;
	}
	
	/**
	 * Postavlja opis slike
	 * 
	 * @param string $title
	 */
	public function SetTitle ($title) {
		$this->title = $title;
	}
	
	
	/**
	 * URL adresa glavne web stranice ciji se sadrzaj prikazuje u kanalu
	 *
	 * @var string
	 */
	private $link;
	
	/**
	 * Dohvaca URL adresu web stranice
	 * 
	 * @return string
	 */
	public function GetLink () {
		return $this->link;
	}
	
	/**
	 * Postavlja URL adresu web stranice
	 * 
	 * @param string $link
	 */
	public function SetLink ($link) {
		$this->link = $link;
	}
	
	
	/**
	 * Sirina slike u pixelima
	 *
	 * @var int
	 */
	private $width;
	
	/**
	 * Dohvaca sirinu slike u pixelima
	 * 
	 * @return int
	 */
	public function GetWidth () {
		return $this->width;
	}
	
	/**
	 * Postavlja sirinu slike u pixelima. Maksimalna sirina slike je
	 * 144px.
	 * 
	 * @param int $width
	 */
	public function SetWidth ($width) {
		if($width <= 144){
			$this->width = $width;
		} else {
			throw new Exception("Sirina slike je prevelika. Makismalna sirina slike mora biti 144px.");
		}
		
	}
	
	
	/**
	 * Visina slike
	 *
	 * @var int
	 */
	private $height;
	
	/**
	 * Dohvaca visinu slike
	 * 
	 * @return int
	 */
	public function GetHeight () {
		return $this->height;
	}
	
	/**
	 * Postavlja visinu slike
	 * 
	 * @param int $height
	 */
	public function SetHeight ($height) {
		if($height <= 400){
			$this->height = $height;	
		} else {
			throw new Exception("Visina slike je prevelika. Maksimalna visina slike je 400px.");
		}
		
	}
	
	
	/**
	 * Opis slike koji se nalazi u TITLE HTML atributu
	 *
	 * @var string
	 */
	private $description;
	
	/**
	 * Dohvaca opis liske
	 * 
	 * @return string
	 */
	public function GetDescription () {
		return $this->description;
	}
	
	/**
	 * Postavlja opis slike
	 * 
	 * @param string $description
	 */
	public function SetDescription ($description) {
		$this->description = $description;
	}

	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################
	

	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################
	
	function __construct () {
	
	}
	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
}

?>