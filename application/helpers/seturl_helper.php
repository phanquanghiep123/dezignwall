<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('slugify'))
{
	function skin_url($url="")
	{ 
		return base_url("skins/".$url."");
	}
	
	function fake_url_image($url) 
	{
		return "http://media.dezignwall.com" . str_replace("/uploads/", "/", $url);
	}
}

