<?php

class LangLink {
	
	
	// #################################
	// ###### MEMBERS ##### BEGIN ######
	// #################################
	
	
	// ###############################
	// ###### MEMBERS ##### END ######
	// ###############################
	
	// ###############################################
	// ###### CONSTRUCTORS AND INIT ##### BEGIN ######
	// ###############################################
	
	// #############################################
	// ###### CONSTRUCTORS AND INIT ##### END ######
	// #############################################
	
	
	
	// #################################
	// ###### METHODS ##### BEGIN ######
	// #################################
	
	/**
	 * Metoda koja generira
	 */
	public static function HomePageLink($langCode, $langService) {
		return site_url($langService->GetLangUrlFromLangCode($langCode), $langCode);
    }
    
    public static function InfoFaqPageLink($langCode, $langService){
    	return site_url($langService->GetLangUrlFromLangCode($langCode) . $langService->GetTextFromLangCode("tvt_route_infofaq", $langCode));
    }
    
    public static function InfoAboutUsPageLink($langCode, $langService){
    	return site_url($langService->GetLangUrlFromLangCode($langCode) . $langService->GetTextFromLangCode("tvt_route_infoaboutus", $langCode));
    }
    
	public static function InfoPPPageLink($langCode, $langService){
    	return site_url($langService->GetLangUrlFromLangCode($langCode) . $langService->GetTextFromLangCode("tvt_route_infopp", $langCode));
    }
    
	public static function InfoTOSPageLink($langCode, $langService){
    	return site_url($langService->GetLangUrlFromLangCode($langCode) . $langService->GetTextFromLangCode("tvt_route_infotos", $langCode));
    }
    
	public static function InfoContactPageLink($langCode, $langService){
    	return site_url($langService->GetLangUrlFromLangCode($langCode) . $langService->GetTextFromLangCode("tvt_route_infocontact", $langCode));
    }
    
	public static function SearchPageLink($langCode, $langService){
    	return site_url($langService->GetLangUrlFromLangCode($langCode) . $langService->GetTextFromLangCode("tvt_route_search", $langCode));
    }
    
	public static function TvChPageLink($langCode, $langService, $params){
		if($params["country"] == null){
			return site_url($langService->GetLangUrlFromLangCode($langCode) . $langService->GetTextFromLangCode("tvt_route_tvch", $langCode));	
		} else {
			return site_url($langService->GetLangUrlFromLangCode($langCode) . $langService->GetTextFromLangCode("tvt_route_tvchcountry", $langCode) . $params["country"]->GetLangAlias($langCode));
		}
    	
    }
    
	public static function TvChPPageLink($langCode, $langService, $params){
		if($params["country"] == null){
			return site_url(
    		$langService->GetLangUrlFromLangCode($langCode) .
    		$langService->GetTextFromLangCode("tvt_route_tvch", $langCode) . 
    		$langService->GetTextFromLangCode("tvt_route_page", $langCode) .
    		"/" . $params['pageNumber']
    		);	
		} else {
			return site_url(
    		$langService->GetLangUrlFromLangCode($langCode) .
    		$langService->GetTextFromLangCode("tvt_route_tvchcountry", $langCode) .
    		$params["country"]->GetLangAlias($langCode) .
    		"/" . $langService->GetTextFromLangCode("tvt_route_page", $langCode) .
    		"/" . $params['pageNumber']
    		);
		}
		
    	
    }
    
	public static function TvChCatPageLink($langCode, $langService, $params){
		if($params["country"] == null){
			return site_url(
    		$langService->GetLangUrlFromLangCode($langCode) .
    		$langService->GetTextFromLangCode("tvt_route_tvch", $langCode) .
    		$params['tvCategory']->GetLangAlias($langCode)
    		);
		} else {
			return site_url(
    		$langService->GetLangUrlFromLangCode($langCode) .
    		$langService->GetTextFromLangCode("tvt_route_tvch", $langCode) .
    		$params['tvCategory']->GetLangAlias($langCode) .
    		"/" .  $langService->GetTextFromLangCode("tvt_route_country", $langCode) . "/" . $params["country"]->GetLangAlias($langCode)
    		);
		}
    	
    }
    
	public static function TvChCatPPageLink($langCode, $langService, $params){
		if($params["country"] == null){
			return site_url(
	    		$langService->GetLangUrlFromLangCode($langCode) .
	    		$langService->GetTextFromLangCode("tvt_route_tvch", $langCode) .
	    		$params['tvCategory']->GetLangAlias($langCode) .  "/" .
	    		$langService->GetTextFromLangCode("tvt_route_page", $langCode) .
	    		"/" . $params['pageNumber']
    		);
		} else {
			return site_url(
	    		$langService->GetLangUrlFromLangCode($langCode) .
	    		$langService->GetTextFromLangCode("tvt_route_tvch", $langCode) .
	    		$params['tvCategory']->GetLangAlias($langCode) .
    			"/" . $langService->GetTextFromLangCode("tvt_route_country", $langCode) . "/" . $params["country"]->GetLangAlias($langCode) .
	    		"/" . $langService->GetTextFromLangCode("tvt_route_page", $langCode) .
	    		"/" . $params['pageNumber']
    		);
		}
    	
    }
    
	public static function TvChWatchPageLink($langCode, $langService, $params){
    	return site_url(
    		$langService->GetLangUrlFromLangCode($langCode) .
    		$langService->GetTextFromLangCode("tvt_route_tvchwatch", $langCode) .
    		$params['id'] .
    		"/" . $params['alias']
    		);
    }
    
    
    
    
    
    
	
	// ###############################
	// ###### METHODS ##### END ######
	// ###############################
}

?>