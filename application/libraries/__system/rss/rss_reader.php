<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (LIBPATH . SYSPATH . "ci_library.php");

require_once("bobjects/RssChannel.php");
require_once("bobjects/RssChannelImage.php");
require_once("bobjects/RssChannelItem.php");
require_once("bobjects/RssChannelItemEnclosure.php");

/**
 * Razred zaduzen za citanje rss sadrzaja.
 * @author Željko Tepšić
 * @version 1.1.1
 *
 */
class Rss_reader extends CILibrary {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	/**
	 * Vrijeme cekanja u sekundama na udaljeni posluzitelj
	 */
	const TIME_OUT = 30;
	
	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################
	

	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################
	
	function __construct () {
		parent::__construct();
		
		$this->CI->load->library(SYSPATH . "tools/web_opener");
	}
	

	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
	

	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################
	
	/**
	 * Validacija rss dokumenta pomocu rss scheme
	 * @param $source - staza do xml dokumenta
	 * @param $rssSchema - staza do rss scheme
	 * @return boolean - true ako je validacija uspjela, inace false
	 */
	public function Validate(DOMDocument $xDoc, $rssSchema = null){
		if(empty($rssSchema)){
			$rssSchema = LIBPATH . SYSPATH . "rss/rss-2_0.xsd";
		}
		
		//Validate the XML file against the schema
		return $xDoc->schemaValidate($rssSchema);
		
	}
	
	/**
	 * Cita sadrzaj rss kanala
	 * @param $remoteUrl - URL adresa udaljenog resursa
	 * @return RssChannel
	 */
	public function Read($rssSource, $timeOut = Rss_reader::TIME_OUT){
		$fp = $this->CI->web_opener->OpenToFile($rssSource, $timeOut);
		$content = stream_get_contents($fp);
		
		if(empty($content)){
			return null;
		}
		
		$rssChannel = null;
		$xDoc = new DOMDocument();
		if(@$xDoc->loadXML($content)){
			//$this->Validate($xDoc);
		
			$xmlContent = simplexml_import_dom($xDoc);

			if($xmlContent){
				$rssChannel = $this->readChannel($xmlContent->channel);	
			} else {
				log_message("error", "Neispravni sadrzaj xml datoteke za " . $rssSource);
			}
		} 
		
		return $rssChannel;

	}
	
	/**
	 * Cita sadrzaj rss kanala
	 * @param $xmlChannel - xml sadrzaj rss kanala
	 * @return RssChannel
	 */
	private function readChannel($xmlChannel){
		$rssChannel = new RssChannel();
		
		// ### Required
		$rssChannel->SetTitle($xmlChannel->title);
		$rssChannel->SetLink($xmlChannel->link);
		$rssChannel->SetDescription($xmlChannel->description);
		$rssChannel->SetItems($this->readChannelItems($xmlChannel->item));
		
		// ### Optional
		$rssChannel->SetPubDate($xmlChannel->pubDate);
		$rssChannel->SetLastBuildDate($xmlChannel->lastBuildDate);
		$rssChannel->SetTtl($xmlChannel->ttl);
		$rssChannel->SetGenerator($xmlChannel->generator);
		$rssChannel->SetDocs($xmlChannel->docs);
		$rssChannel->SetLanguage($xmlChannel->language);
		$rssChannel->SetManagingEditor($xmlChannel->managingEditor);
		$rssChannel->SetWebMaster($xmlChannel->webMaster);
		$rssChannel->SetCopyright($xmlChannel->copyright);
		$rssChannel->SetImage($this->readChannelImage($xmlChannel->image));
		
		return $rssChannel;
	}
	
	/**
	 * Cita sliku kanala iz xml Channel->Image taga
	 * @param $xmlImage - xml sadrzaj
	 * @return RssChannelImage
	 */
	private function readChannelImage($xmlImage){
		$rssChannelImage = new RssChannelImage();
		
		// ### Required
		$rssChannelImage->SetUrl($xmlImage->url);
		$rssChannelImage->setTitle(trim($xmlImage->title));
		$rssChannelImage->SetLink($xmlImage->link);
		
		// ### Optional
		$rssChannelImage->SetWidth($xmlImage->width);
		$rssChannelImage->SetHeight($xmlImage->height);
		if(!empty($xmlImage->description)){
			$rssChannelImage->SetDescription(trim($xmlImage->description));	
		}
		
		
		return $rssChannelImage;
	}
	
	/**
	 * Cita elementa rss kanala
	 * @param $xmlItems - xml sadrzaj elemenata rss kanala
	 * @return array<RssChannelItem>
	 */
	private function readChannelItems($xmlItems){
		$rssChannelItems = array();
		
		$ns = array(
    			"content" => "http://purl.org/rss/1.0/modules/content/",
				"dc" => "http://purl.org/dc/elements/1.1/",
				"feedburner" => "http://rssnamespace.org/feedburner/ext/1.0"
		);
		
		$rssChannelItem = null;
		foreach($xmlItems as $xmlItem){
			$rssChannelItem = new RssChannelItem();
			
			$rssChannelItem->SetTitle(trim($xmlItem->title));
			
			if(isset($xmlItem->children($ns["feedburner"])->origLink)){
				$link = $xmlItem->children($ns["feedburner"])->origLink;
				$rssChannelItem->SetLink($link);
			} else {
				$rssChannelItem->SetLink($xmlItem->link);
			}
			
			if(!empty($xmlItem->description)){
				$rssChannelItem->SetDescription(trim(strip_tags($xmlItem->description)));	
			}
		
			
			$rssChannelItem->SetAuthor($xmlItem->author);
			
			if(!empty($xmlItem->guid)){
				$rssChannelItem->SetGuid($xmlItem->guid);
			} else {
				$rssChannelItem->SetGuid($rssChannelItem->GetLink());
			}
			
			if(empty($xmlItem->pubDate)){
				continue;
			}
			
			$rssChannelItem->SetPubDate($xmlItem->pubDate);
			
			$rssChannelItem->SetContentEncoded($xmlItem->children($ns["content"])->encoded);
			//$dc = $xmlItem->children($ns["dc"])->creator;
			
			$contentEncoded = $rssChannelItem->GetContentEncoded();
			if(!empty($xmlItem->enclosure["url"])){
				$enclosure = new RssChannelItemEnclosure($xmlItem->enclosure["url"], $xmlItem->enclosure["type"]);
			} else if(!empty($contentEncoded)) {
				$image = $this->getImageFromContentEncoded($rssChannelItem->GetContentEncoded());
				if(empty($image)){
					$image = null;
				}
				$enclosure = new RssChannelItemEnclosure($image, "image/jpeg");
			} else {
				$image = $this->getImageFromContentEncoded($xmlItem->description);
				if(empty($image)){
					$image = null;
				}
				$enclosure = new RssChannelItemEnclosure($image, "image/jpeg");
			}
				
			$rssChannelItem->SetEnclosure($enclosure);
			

			$rssChannelItems[] = $rssChannelItem;
		}
		
		return $rssChannelItems;
	}
	
	private function getImageFromContentEncoded($contentEncoded){
		preg_match('/src=[\"\']([^\"\']+)/', $contentEncoded, $result);
		if(!empty($result[1])){
			return $result[1];	
		} else {
			return null;
		}
		
	}
	
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################

}

?>