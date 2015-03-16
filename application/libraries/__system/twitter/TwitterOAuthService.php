<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (LIBPATH . SYSPATH . "ci_library.php");
require_once (LIBPATH . SYSPATH . "twitter/oauth/twitteroauth.php");
//include_once (LIBPATH . SYSPATH . "IStringRenderer.php");

class TwitterOAuthService extends CILibrary {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	/**
	 * Consumer key
	 * @var string
	 */
	private $consumerKey;
	
	/**
	 * Consumer secret
	 * @var string
	 */
	private $consumerSecret;
	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################
	
	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################
	
	/**
	 * Konstruktor
	 */
	public function __construct(){
		parent::__construct();
		
		$this->consumerKey = $this->CI->config->item("zt_twitter_consumer_key");
		$this->consumerSecret = $this->CI->config->item("zt_twitter_consumer_secret");
	}
	

	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
	
	
	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################
	
	public function CreateTwitterOAuthObject(){
		return new TwitterOAuth($this->consumerKey, $this->consumerSecret, $this->getOAuthAccessToken(), $this->getOAuthAccessTokenSecret());
		
	}
	
	public function Callback($oAuthTokenFromRequest){
		/* If the oauth_token is old redirect to the connect page. */
		if($oAuthTokenFromRequest !== $this->getOAuthRequestToken()){
			//$_SESSION['oauth_status'] = 'oldtoken';
  			//header('Location: ./clearsessions.php');
  			
			$this->load->helper('file');
			$data = "If the oauth_token is old redirect to the connect page" . "\r\n";
			$data .= "\r\n\r\n\r\n";
			write_file("twitter.txt", $data, "a");
			
  			echo "old ouauth_token";
  			exit;	
		}

		/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
		$twitterOAuth = new TwitterOAuth($this->consumerKey, $this->consumerSecret, $this->getOAuthRequestToken(), $this->getOAuthRequestTokenSecret());

		/* Request access tokens from twitter */
		$accessToken = $twitterOAuth->getAccessToken();		
		$this->saveAccessTokenDataToSession($accessToken);
		$this->deleteRequestTokenDataFromSession();
		
		$isOk = false;
		/* If HTTP response is 200 continue otherwise send to connect page to retry */
		switch ($twitterOAuth->http_code) {
		  case 200:
		    $isOk = true;
		    break;
		  default:
		    $isOk = false;
		    break;
		}
		
		return $isOk;
	}

	/**
	 * Spajanje aplikacije za korisnickim racunom.
	 * @return  Metoda vraca url adresu u slucaju uspjeha, inace null
	 */
	public function Connect(){
		/* Create TwitterOAuth object and get request token */
		$twitterOAuth = new TwitterOAuth($this->consumerKey, $this->consumerSecret);
		
		/* Get request token */
		$requestToken = $twitterOAuth->getRequestToken();

		$this->saveRequestTokenDataToSession($requestToken);
 
		$authorizationUrl = null;
		/* If last connection fails don't display authorization link */
		switch ($twitterOAuth->http_code) {
		  case 200:
		    /* Build authorize URL */
		    $authorizationUrl= $twitterOAuth->getAuthorizeURL($this->getOAuthRequestToken()); 
		    break;
		  default:
		    $authorizationUrl = null;
		    break;
		}
		
		return $authorizationUrl;
	}
	
	public function IsVerified(){
		$oAuthAccessToken = $this->getOAuthAccessToken();
		$oAuthAccessTokenSecret = $this->getOAuthAccessTokenSecret();
		//echo $this->CI->session->userdata('session_id');
		return (boolean) !empty($oAuthAccessToken) && !empty($oAuthAccessTokenSecret) ? true : false;
	}
	
	
	public function getOAuthAccessToken(){
		$sessionData = $this->CI->session->userdata("twitter_oauth_access_token");
		if($sessionData){
			return $sessionData;
		} else {
			return null;
		}
	}
	
	public function getOAuthAccessTokenSecret(){
		$sessionData = $this->CI->session->userdata("twitter_oauth_access_token_secret");
		if($sessionData){
			return $sessionData;
		} else {
			return null;
		}
	}
	
	private function saveAccessTokenDataToSession($accessTokenData){
		/* Save request token to session */
		$tokenDataForSession = array(
			"twitter_oauth_access_token"	=>	$accessTokenData["oauth_token"],
			"twitter_oauth_access_token_secret"	=>	$accessTokenData["oauth_token_secret"]
		);

		$this->CI->session->set_userdata($tokenDataForSession);
	}
	
	
	public function getOAuthRequestToken(){
		$sessionData = $this->CI->session->userdata("twitter_oauth_request_token");
		if($sessionData){
			return $sessionData;
		} else {
			return null;
		}
	}
	
	public function getOAuthRequestTokenSecret(){
		$sessionData = $this->CI->session->userdata("twitter_oauth_request_token_secret");
		if($sessionData){
			return $sessionData;
		} else {
			return null;
		}
	}
	
	private function saveRequestTokenDataToSession($requestTokenData){
		/* Save request token to session */
		$tokenDataForSession = array(
			"twitter_oauth_request_token"	=>	$requestTokenData["oauth_token"],
			"twitter_oauth_request_token_secret"	=>	$requestTokenData["oauth_token_secret"]
		);

		$this->CI->session->set_userdata($tokenDataForSession);
	}
	
	private function deleteRequestTokenDataFromSession(){
		$tokenDataToDelete = array("twitter_oauth_request_token" => "", "twitter_oauth_request_token_secret" => "");

		$this->CI->session->unset_userdata($tokenDataToDelete);
	}
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
}

?>
