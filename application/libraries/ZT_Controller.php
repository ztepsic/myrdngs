<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once (LIBPATH . SYSPATH . "htmlComponents/head/bobjects/Head.php");require_once (LIBPATH . SYSPATH . "PathManager.php");require_once (LIBPATH . SYSPATH . "settings/Settings.php");require_once(LIBPATH . SYSPATH . "htmlComponents/head/head_generator.php");
abstract class ZT_Controller extends Controller {
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	/**
	 * Postavke web sjedista
	 * @var Config
	 */
	private $settings;
	
	/**
	 * Dohvaca postavke web sjedista
	 * @return Settings
	 */
	protected function GetSettings(){
		return $this->settings;
	}		/**	 * Head generator	 * @var Head_generator	 */	protected $head_generator;	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################

	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################
	public function __construct(){
		parent::Controller();
		$this->settings = Settings::Instance();
		if(!$this->settings->GetGeneral()->GetIsSiteEnabled()){
			show_error($this->settings->GetGeneral()->GetSiteDisabledMsg(), $this->settings->GetGeneral()->GetSiteDisabledTitle());
		}
		$this->head_generator = new Head_generator();
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
		$data['head'] = $this->head_generator->Render();
		$data['footer'] = $this->load->view(PathManager::GetSharedPath("footer_view"), null, true);
		$data['googleAnalytics'] = $this->config->item("zt_google_analytics");
		$this->load->view(PathManager::GetSharedPath("site_master_view"), $data);
	}
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################	
}

?>