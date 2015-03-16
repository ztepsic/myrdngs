<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(LIBPATH . SYSPATH . "language/LangService.php");

abstract class LangController extends ZT_Controller {

	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	/**
	 * Servis za jezik
	 * @var $langService LangService
	 */
	protected $langService = null;
	
	/**
	 * Callback
	 * @var string
	 */
	private $callback = null;
	
	/**
	 * Postavlja callback te opcionalno i parametre
	 * @param $callback 
	 * @param array $params - opcionalni parametri
	 */
	public function SetCallbackForLangLink($callback, array $params = null){
		$this->callback = $callback;
		$this->callbackParams = $params;
	}
	
	/**
	 * Calback dodatni parametri
	 * @var array
	 */
	private $callbackParams;

	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################


	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################

	public function __construct(){
		parent::__construct();
		
		$this->langService = LangService::GetInstance();
		if($this->langService->IsNeededRedirect()){
			$this->langService->RedirectToCorrectLangUrl();
		}

		$this->head_generator = new Head_generator($this->langService);

	}


	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################


	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################

	
	/**
	 * Iscrtava stranicu
	 *
	 * @param array<string> $data - dodatni podaci koje je potrebno iscrtati
	 */
	public function Render($data){
		$data['lang'] = $this->langService->GetPrimaryWithSubLangCode();
		$data['langService'] = $this->langService;
		$pageUrls = array();
		foreach ($this->langService->GetSupportedLanguages() as $langCode){
			//$pageUrls[$langCode]["url"] = str_replace("%lang%", "black", "<body text='%body%'>");
			if(isset($this->callbackParams)){
				$pageUrls[$langCode]["url"] = call_user_func($this->callback, $langCode, $this->langService, $this->callbackParams);
			} else {
				$pageUrls[$langCode]["url"] = call_user_func($this->callback, $langCode, $this->langService);	
			}
			
			$pageUrls[$langCode]["lang"] = ucfirst($this->langService->GetLanguageFromLangCode($langCode));
		}
		
		$data['pageUrls'] = $pageUrls;
		
		parent::Render($data);

	}

	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
	
}



?>