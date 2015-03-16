<?php

require_once (LIBPATH . SYSPATH . "rss/bobjects/RssChannelItem.php");
require_once (LIBPATH . SYSPATH . "rss/bobjects/RssChannel.php");

class ZtRssChannelItem extends RssChannelItem {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	/**
	 * Identifikator elementa
	 * @var int
	 */
	private $id;
	
	/**
	 * Dohvaca identifikator elementa
	 * 
	 * @return int
	 */
	public function GetId () {
		return $this->id;
	}
	
	/**
	 * Postavlja identifikator elementa
	 * 
	 * @param int $id - identifikator elementa
	 */
	public function SetId ($id) {
		$this->id = $id;
	}
	
	
	/**
	 * Rss kanal
	 * 
	 * @var RssChannel
	 */
	private $channel;
	
	/**
	 * Postavlja Rss kanal
	 * 
	 * @param $channel the $channel to set
	 */
	public function SetChannel ($channel) {
		$this->channel = $channel;
	}

	/**
	 * Dohvaca rss kanal
	 * 
	 * @return the $channel
	 */
	public function GetChannel () {
		return $this->channel;
	}
	

	/**
	 * Url slike
	 * @var string
	 */
	private $image;
	
	/**
	 * Postavlja url slike
	 * @param $image the $image to set
	 */
	public function SetImage ($image) {
		$this->image = $image;
	}

	/**
	 * Dohvaca rule slike
	 * @return the $image
	 */
	public function GetImage () {
		return $this->image;
	}
	
	
	

	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################
	

	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################
	
	function __construct () {
		parent::__construct();
	
	}
	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
	
	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################
	

	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
}

?>