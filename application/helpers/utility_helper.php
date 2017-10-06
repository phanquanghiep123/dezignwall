<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * CodeIgniter Inflector Helpers
 *
 * Customised singular and plural helpers.
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team, stensi
 * @link		http://codeigniter.com/user_guide/helpers/inflector_helper.html
 */

// --------------------------------------------------------------------

/**
* Singular
*
* Takes a plural word and makes it singular (improved by stensi)
*
* @access	public
* @param	string
* @return	str
*/

if ( ! function_exists('backend_url')) {
	function backend_url($path='') {
		return base_url() . 'backend/' . $path;
	}
};


if ( ! function_exists('admin_url')) {
	function admin_url($path='') {
		return base_url() . 'admin/' . $path;
	}
}

if ( ! function_exists('get_extension_url')) {
	function get_extension_url($path='') {
		$info = getimagesize($path);
    	if ($info && !empty($info["mime"])) {
    		switch ($info["mime"]) {
    			case "image/jpeg":
    				return ".jpeg";
    			case "image/png":
    				return ".png";
    			case "image/bmp":
    				return ".bmp";
    		}
    		return ".png";
    	}
		return ".png";
	}
}













