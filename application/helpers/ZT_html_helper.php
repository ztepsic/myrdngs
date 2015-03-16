<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Generates meta tags from an array of key/values
 *
 * @access	public
 * @param	array
 * @return	string
 */
if ( ! function_exists('meta')) {
	function meta($name = '', $content = '', $type = 'name', $newline = "\n") {
		// Since we allow the data to be passes as a string, a simple array
		// or a multidimensional one, we need to do a little prepping.
		if ( ! is_array($name)) {
			$name = array(array('name' => $name, 'content' => $content, 'type' => $type, 'newline' => $newline));
		} else {
			// Turn single array into multidimensional
			if (isset($name['name'])) {
				$name = array($name);
			}
		}

		$str = '';
		foreach ($name as $meta) {
			$type 		= ( ! isset($meta['type'])) ? 'name' : $meta['type'];
			$name 		= ( ! isset($meta['name'])) 	? '' 	: $meta['name'];
			$content	= ( ! isset($meta['content']))	? '' 	: $meta['content'];
			$newline	= ( ! isset($meta['newline']))	? "\n"	: $meta['newline'];

			$str .= '<meta '.$type.'="'.$name.'" content="'.$content.'" />'.$newline;
		}

		return $str;
	}
}

/**
 * Script
 *
 * Generates script tag data
 *
 * @access	public
 * @param	mixed	stylesheet hrefs or an array
 * @param	string	type
 * @param	string	content
 * @param	boolean	should index_page be added to the css path
 * @return	string
 */
if ( ! function_exists('script_tag')) {
	function script_tag($src = "", $type="text/javascript", $content = "", $index_page = FALSE) {
		//<script src="http://www.google.com/jsapi" type="text/javascript"></script>
		$CI =& get_instance();

		$script = '<script ';

		if (is_array($src)) {
			foreach ($src as $k=>$v) {
				if ($k == 'src' AND strpos($v, '://') === FALSE) {
					if ($index_page === TRUE) {
						$script .= 'src="'.$CI->config->static_url($v).'" ';
					} else {
						$script .= 'src="'.$CI->config->static_url($v).'" ';
					}
				} elseif($k == "content") {
					$content = $v;
				} else {
					$script .= "$k=\"$v\" ";
				}
			}

			$script .= ">" . $content . "</script>"."\n";
		} else {
			if ( strpos($src, '://') !== FALSE) {
				$script .= 'src="'.$src.'" ';
			} elseif ($index_page === TRUE) {
				$script .= 'src="'.$CI->config->static_url($src).'" ';
			} else {
				$script .= 'src="'.$CI->config->static_url($src).'" ';
			}

			$script .= 'type="'.$type.'" ';

			$script .= '/>' . $content . '</script>'."\n";
		}


		return $script;
	}
}

/**
 * Link
 *
 * Generates link to a CSS file
 *
 * @access	public
 * @param	mixed	stylesheet hrefs or an array
 * @param	string	rel
 * @param	string	type
 * @param	string	title
 * @param	string	media
 * @param	boolean	should index_page be added to the css path
 * @return	string
 */
if ( ! function_exists('link_tag'))
{
	function link_tag($href = '', $rel = 'stylesheet', $type = 'text/css', $title = '', $media = '', $index_page = FALSE)
	{
		$CI =& get_instance();

		$link = '<link ';

		if (is_array($href))
		{
			foreach ($href as $k=>$v)
			{
				if ($k == 'href' AND strpos($v, '://') === FALSE)
				{
					if ($index_page === TRUE)
					{
						$link .= 'href="'.$CI->config->static_url($v).'" ';
					}
					else
					{
						$link .= 'href="'.$CI->config->static_url($v).'" ';
					}
				}
				else
				{
					$link .= "$k=\"$v\" ";
				}
			}

			$link .= "/>"."\n";
		}
		else
		{
			if ( strpos($href, '://') !== FALSE)
			{
				$link .= 'href="'.$href.'" ';
			}
			elseif ($index_page === TRUE)
			{
				$link .= 'href="'.$CI->config->static_url($href).'" ';
			}
			else
			{
				$link .= ' href="'.$CI->config->static_url($href).'" ';
			}

			$link .= 'rel="'.$rel.'" type="'.$type.'" ';

			if ($media	!= '')
			{
				$link .= 'media="'.$media.'" ';
			}

			if ($title	!= '')
			{
				$link .= 'title="'.$title.'" ';
			}

			$link .= '/>'."\n";
		}


		return $link;
	}
}

// ------------------------------------------------------------------------

