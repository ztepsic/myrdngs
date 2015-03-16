<?php

class Sitemap extends Controller {
	
	const GAMES = "sitemap_games";
	const CATEGORIES = "sitemap_categories";
	const SITEMAP = "sitemap";
	
  public function __construct() {
      parent::Controller();
      
      $this->load->helper(array('text','url'));
      $this->load->library(SYSPATH . "googlesitemap/googlesitemap");
      
      $this->load->model("lektire/books_model", "booksModel");
   }
   
  
  public function index() {
  	$sitemap = new GoogleSitemap(); //Create a new Sitemap Object
    
    // naslovnica
    $item = new google_sitemap_item(base_url(),
    		date("Y-m-d"),
    	 'weekly',
    	 '1' ); //Create a new Item
    $sitemap->add_item($item); //Append the item to the sitemap object
    
    // tv kanali - stranica
    $item = new google_sitemap_item(site_url("lektire"),
    		date("Y-m-d"),
    	 'weekly',
    	 '0.9' ); //Create a new Item
    $sitemap->add_item($item); //Append the item to the sitemap object
    
      // tv kanali - stranica
    $item = new google_sitemap_item(site_url("pisci"),
    		date("Y-m-d"),
    	 'weekly',
    	 '0.9' ); //Create a new Item
    $sitemap->add_item($item); //Append the item to the sitemap object
    
    // sve igrice
    $books = $this->booksModel->GetBooks();
    
    foreach($books as $book){
    	$item = new google_sitemap_item(site_url("lektira/" . idalias_url_title($book->GetId(), $book->GetTitle())),
    		date("Y-m-d"),
    	 'weekly',
    	 '0.8' ); //Create a new Item
    	$sitemap->add_item($item); //Append the item to the sitemap object
    	
    }
    
   	// sve igrice
    $authors = $this->authorsModel->GetAuthors();
    
    foreach($authors as $author){
    	$item = new google_sitemap_item(site_url("pisac/" . idalias_url_title($author->GetId(), $author->GetFullName())),
    		date("Y-m-d"),
    	 'weekly',
    	 '0.8' ); //Create a new Item
    	$sitemap->add_item($item); //Append the item to the sitemap object
    	
    }
    
    
    
    
      $sitemap->build("./" . self::SITEMAP . ".xml"); //Build it...
            
     //Let's compress it to gz
    $data = implode("", file("./" . self::SITEMAP . ".xml"));
    $gzdata = gzencode($data, 9);
    $fp = fopen("./" . self::SITEMAP . ".xml.gz", "w");
    fwrite($fp, $gzdata);
    fclose($fp);

    //Let's Ping google
    $this->pingGoogleSitemaps(base_url()."/". self::SITEMAP . ".xml.gz");
  }

    private function pingGoogleSitemaps( $url_xml ) {
       $status = 0;
       $google = 'www.google.com';
       if( $fp=@fsockopen($google, 80) ) {
          $req =  'GET /webmasters/sitemaps/ping?sitemap=' .
                  urlencode( $url_xml ) . " HTTP/1.1\r\n" .
                  "Host: $google\r\n" .
                  "User-Agent: Mozilla/5.0 (compatible; " .
                  PHP_OS . ") PHP/" . PHP_VERSION . "\r\n" .
                  "Connection: Close\r\n\r\n";
          fwrite( $fp, $req );
          while( !feof($fp) ) {
             if( @preg_match('~^HTTP/\d\.\d (\d+)~i', fgets($fp, 128), $m) ) {
                $status = intval( $m[1] );
                break;
             }
          }
          fclose( $fp );
       }
       return( $status );
    }

}

?>