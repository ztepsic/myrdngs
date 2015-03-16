<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (LIBPATH . SYSPATH . "ci_library.php");

class Web_opener extends CILibrary {
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	/**
	 * Ekstenzija za cache datoteke
	 * @var string
	 */
	const EXT = ".cache";
	
	/**
	 * Vrijeme u sekundama za provjeru dostupnosti udaljenog resursa
	 * @var int
	 */
	const CHECK_TIME_OUT = 10;
	
	/**
	 * Poruka za iznimku kada nije prodadjena funkcija za dohvat udaljenog resursa
	 * @var string
	 */
	const OPEN_EXCEPTION_MESSAGE = "ERROR - there's no working opening method.";
	
	/**
	 * Staza do cache direktorija
	 * @var string
	 */
	private $cachePath;
	
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
	public function __construct () {
		parent::__construct();
		
		$path = $this->CI->config->item('cache_path');
		$this->cachePath = empty($path) ? BASEPATH . 'cache/' : $path;
		
	}

	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
	
	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################
	
	/**
	 * Binds a named resource, specified by filename, to a stream.
	 *
	 * @param string $remoteUrl - url ciji sadrzaj se preuzima
	 * @param int $timeOut - vrijeme cekanja u sekundama na udaljeni posluzitelj
	 * @param string $chacheTime  - vrijeme cuvanja lokalnog sadrzaja u minutama
	 * @return file pointer resource on success, or FALSE on error.
	 */
	public function OpenToFile($remoteUrl, $timeOut = Web_opener::CHECK_TIME_OUT, $chacheTime = 30){
		$remoteUrl = prep_url($remoteUrl);
		
		$localFile = $this->cachePath . preg_replace("/[^A-Za-z0-9_\\.]/", "_", $remoteUrl) . Web_opener::EXT;

		if (file_exists($localFile)){

			$localFileStat = stat($localFile);
			if ($localFileStat['mtime'] < strtotime("-" . $chacheTime . " minutes")){
				if(function_exists("curl_init")){
					$this->writeToFileCurl($remoteUrl, $timeOut, $localFile);
				} else if(ini_get("allow_url_fopen")){
					$fp = fopen($remoteUrl, "rb");
					$content = stream_get_contents($fp);
					fclose($fp);
					
					$fp = fopen($localFile, "w");
					fwrite($fp, $content);
					fclose($fp);
				} else {
					throw new Exception(Web_opener::OPEN_EXCEPTION_MESSAGE);	
				}
			}
		} else {
			if(function_exists("curl_init")){
				$this->writeToFileCurl($remoteUrl, $timeOut, $localFile);
			} else if(ini_get("allow_url_fopen")){
				$fp = fopen($remoteUrl, "rb");
				$content = stream_get_contents($fp);
				fclose($fp);
				
				$fp = fopen($localFile, "w");
				fwrite($fp, $content);
				fclose($fp);
			} else {
				throw new Exception(Web_opener::OPEN_EXCEPTION_MESSAGE);	
			}
		}
		
		$handle = fopen($localFile, "r");
		return $handle;
	}
	
	
	/**
	 * Otvaranje udaljene datoteke u varijablu
	 * @param $remoteUrl - URL udaljena datoteka
	 * @param $timeOut - vrijeme cekanja
	 * @return string
	 */
	public function Open($remoteUrl, $timeOut = Web_opener::CHECK_TIME_OUT){
		$remoteUrl = prep_url($remoteUrl);

		if(function_exists("curl_init")){
			return $this->openCurl($remoteUrl, $timeOut);
		} else if(ini_get("allow_url_fopen")){
			$fp = fopen($remoteUrl, "rb");
			$content = stream_get_contents($fp);
			fclose($fp);
			
			return $content;
			
		} else {
			throw new Exception(Web_opener::OPEN_EXCEPTION_MESSAGE);	
		}
	}
	
	private function writeToFileCurl($remoteUrl, $timeOut, $localFile){
		if (self::CheckRemoteSourceCurl($remoteUrl, $timeOut) == 200) {
			$ch = curl_init($remoteUrl);
			$fp = fopen($localFile, "w");

			curl_setopt($ch, CURLOPT_FILE, $fp);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_exec($ch);
			curl_close($ch);
			fclose($fp);
		} else {
			touch($localFile);
		}

	}
	
	/**
	 * Otvaranje udaljene datoteke preko CURL funckija
	 * @param $remoteUrl - URL udaljena adresa
	 * @param $timeOut - vrijeme cekanja
	 * @return string
	 */
	private function openCurl($remoteUrl, $timeOut){
		if(self::CheckRemoteSourceCurl($remoteUrl, $timeOut) == 200){
			$ch = curl_init($remoteUrl);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
	    	$response = curl_exec($ch);
	    	return $response;
		 }
		 
		 return null;
	}

	
	/**
	 * Provjerava status odaljenog resursa
	 * @param $remoteUrl - URL adresa
	 * @param $timeOut - vrijeme cekanja
	 * @return int - http status kod
	 */
	public static function CheckRemoteSourceCurl($remoteUrl, $timeOut = Web_opener::CHECK_TIME_OUT){				
		$chresponse = curl_init($remoteUrl);
		$ret = curl_setopt($chresponse, CURLOPT_HEADER, TRUE);
		//$ret = curl_setopt($chresponse, CURLOPT_CUSTOMREQUEST, 'HEAD');
		$ret = curl_setopt($chresponse, CURLOPT_NOBODY, TRUE);
		$ret = curl_setopt($chresponse, CURLOPT_FOLLOWLOCATION, 1);
		$ret = curl_setopt($chresponse, CURLOPT_TIMEOUT, $timeOut);
		$ret = curl_setopt($chresponse, CURLOPT_RETURNTRANSFER, 1);
		$ret = curl_exec($chresponse);
		
		if(empty($ret)){
		   	die(curl_error($chresponse));
		   	curl_close($chresponse);
		   	return 503;
		} else {
			$info = curl_getinfo($chresponse);
		 	curl_close($chresponse);
		 	
		 	return (int) $info['http_code'];
		}
	}
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
	
}

?>