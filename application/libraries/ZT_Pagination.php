<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (LIBPATH . SYSPATH . "ci_library.php");

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Pagination Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Pagination
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/pagination.html
 */
class ZT_Pagination extends CILibrary {

	private $base_url			= ''; // The page we are linking to
	private $page_path  = ''; // metoda kontrolera koji obraduje stranice
	private $total_rows  		= ''; // Total number of items (database results)
	private $per_page	 		= 10; // Max number of items you want shown per page
	private $num_links			=  2; // Number of "digit" links to show before/after the currently viewed page
	private $cur_page	 		=  0; // The current page being viewed
	
	private $numberOfPages = 0; // broj stranica koje ce se izgenerirati
	
	private $first_link   		= '&lsaquo; First';
	private $next_link			= '&gt;';
	private $prev_link			= '&lt;';
	private $last_link			= 'Last &rsaquo;';
	private $uri_segment		= 3;
	private $full_tag_open		= '';
	private $full_tag_close		= '';
	private $first_tag_open		= '';
	private $first_tag_close	= '&nbsp;';
	private $last_tag_open		= '&nbsp;';
	private $last_tag_close		= '';
	private $cur_tag_open		= '&nbsp;<strong>';
	private $cur_tag_close		= '</strong>';
	private $next_tag_open		= '&nbsp;';
	private $next_tag_close		= '&nbsp;';
	private $prev_tag_open		= '&nbsp;';
	private $prev_tag_close		= '';
	private $num_tag_open		= '&nbsp;';
	private $num_tag_close		= '';
	private $page_query_string	= FALSE;
	private $query_string_segment = 'per_page';

	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 */
	public function __construct($params = array()) {
		parent::__construct();
		
		if (count($params) > 0){
			$this->Initialize($params);		
		}
		
		log_message('debug', "Pagination Class Initialized");
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Initialize Preferences
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 * @return	void
	 */
	public function Initialize($params = array()){
		if($this->CI->config->item("zt_pagination")){
			$params = array_merge($this->CI->config->item("zt_pagination"), $params);
		}
		
		if (count($params) > 0) {
			foreach ($params as $key => $val) {
				if (isset($this->$key)) {
					$this->$key = $val;
				}
			}
		}
		
		$this->calculateNumberOfPages();
		$this->determineCurrentPage();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Generate the pagination links
	 *
	 * @access	public
	 * @return	string
	 */	
	public function Create_links()	{
		
		// If our item count or per-page total is zero there is no need to continue.
		if ($this->total_rows == 0 OR $this->per_page == 0) {
		   return '';
		}

		

		// Is there only one page? Hm... nothing more to do here then.
		if ($this->numberOfPages == 1) {
			return '';
		}

		$this->num_links = (int)$this->num_links;
		
		if ($this->num_links < 1) {
			show_error('Your number of links must be a positive number.');
		}		
		
		// Calculate the start and end numbers. These determine
		// which number to start and end the digit links with
		$start = (($this->cur_page - $this->num_links) > 0) ? $this->cur_page - $this->num_links : 1;
		$end   = (($this->cur_page + $this->num_links) < $this->numberOfPages) ? $this->cur_page + $this->num_links : $this->numberOfPages;

		// Is pagination being used over GET or POST?  If get, add a per_page query
		// string. If post, add a trailing slash to the base URL if needed
		if ($this->CI->config->item('pagination_querysearch') && ($this->CI->config->item('enable_query_strings') === TRUE OR $this->page_query_string === TRUE)) {
			$this->base_url = rtrim($this->base_url).'&amp;'.$this->query_string_segment.'=';
			$this->page_path = rtrim($this->page_path).'&amp;'.$this->query_string_segment.'=';
		} else {
			$this->base_url = rtrim($this->base_url, '/') .'/';
			$this->page_path = rtrim($this->page_path, '/') .'/';
		}
		
		$queryString = $_SERVER["QUERY_STRING"];
		if(!empty($queryString)){
			$queryString = "/?" . $queryString;
		}

  		// And here we go...
		$output = '';

		// Render the "First" link
		if  ($this->cur_page > ($this->num_links + 1)) {
			//$output .= $this->first_tag_open.'<a href="'.$this->base_url.'1">'.$this->first_link.'</a>'.$this->first_tag_close;
			$output .= $this->first_tag_open.'<a href="'.$this->base_url.$queryString.'">'.$this->first_link.'</a>'.$this->first_tag_close;
		}

		// Render the "previous" link
		if  ($this->cur_page > 1) {
			$pageNumber = $this->cur_page - 1;
			$output .= $this->prev_tag_open.'<a href="'.$this->base_url.$this->page_path.$pageNumber.$queryString.'">'.$this->prev_link.'</a>'.$this->prev_tag_close;
		}

		// Write the digit links
		for ($i = $start; $i <= $end; $i++) {
			
			if($this->cur_page == $i) {
				$output .= $this->cur_tag_open.$i.$this->cur_tag_close; // Current page
			} else {
				$output .= $this->num_tag_open.'<a href="'.$this->base_url.$this->page_path.$i.$queryString.'">'.$i.'</a>'.$this->num_tag_close;
			}
			
		}

		// Render the "next" link
		if ($this->cur_page < $this->numberOfPages) {
			$output .= $this->next_tag_open.'<a href="'.$this->base_url.$this->page_path.($this->cur_page + 1).$queryString.'">'.$this->next_link.'</a>'.$this->next_tag_close;
		}

		// Render the "Last" link
		if (($this->cur_page + $this->num_links) < $this->numberOfPages) {
			$pageNumber = $this->numberOfPages;
			$output .= $this->last_tag_open.'<a href="'.$this->base_url.$this->page_path.$pageNumber.$queryString.'">'.$this->last_link.'</a>'.$this->last_tag_close;
		}

		// Kill double slashes.  Note: Sometimes we can end up with a double slash
		// in the penultimate link so we'll kill all double slashes.
		$output = preg_replace("#([^:])//+#", "\\1/", $output);

		// Add the wrapper HTML if exists
		$output = $this->full_tag_open.$output.$this->full_tag_close;
		
		return $output;		
	}
	
	public function GetOffset(){
		$offset = $this->per_page * ($this->cur_page - 1);
		return $offset;
	}
	
	private function calculateNumberOfPages(){
		// Calculate the total number of pages
		$this->numberOfPages = ceil($this->total_rows / $this->per_page);
		if($this->numberOfPages <= 0){
			$this->numberOfPages = 1;
		}
	}
	
	private function determineCurrentPage(){
		if ($this->CI->config->item('pagination_querysearch') && ($this->CI->config->item('enable_query_strings') === TRUE OR $this->page_query_string === TRUE)) {
			if ($this->CI->input->get($this->query_string_segment) != 0) {
				$this->cur_page = $this->CI->input->get($this->query_string_segment);
				
				// Prep the current page - no funny business!
				$this->cur_page = (int) $this->cur_page;
			}
		} else {
			if ($this->CI->uri->segment($this->uri_segment) != 0) {
				$this->cur_page = $this->CI->uri->segment($this->uri_segment);
				
				// Prep the current page - no funny business!
				$this->cur_page = (int) $this->cur_page;
			}
		}
		
		if (empty($this->cur_page) || $this->cur_page < 1) {
			$this->cur_page = 1;
		}
		
		// Is the page number beyond the result range?
		// If so we show the last page
		if(isset($this->numberOfPages)){
			if ($this->cur_page > $this->numberOfPages) {
				//show_404();
				
				// za trenutnu stranicu postavlja maksimalni broj stranica
				// npr. ako je trenutna stranica 10, a maksimalni broj stranica 3, tada se za url domena.com/test/page/10
				// dohvaca sadrzaj kao za url domena.com/test/page/3
				//$this->cur_page = $this->numberOfPages;
				
				
				$queryString = $_SERVER["QUERY_STRING"];
				if(!empty($queryString)){
					$queryString = "/?" . $queryString;
				}
				
				redirect($this->base_url . $queryString);
			}
		} else {
			throw new Exception("NumberOfPages must be first calculated.");
		}
		
		
	}
	
}
// END Pagination Class

/* End of file Pagination.php */
/* Location: ./system/libraries/Pagination.php */