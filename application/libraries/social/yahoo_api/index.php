<?php
require_once('globals.php'); 
require_once('oauth_helper.php');
 $callback    =    "http://betadev.dezignwalldev.com/social/yahoo_api/yahoo_callback.php";
 // Get the request token using HTTP GET and HMAC-SHA1 signature 
 $retarr = get_request_token(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, $callback, false, true, true);

if (! empty($retarr)){ 
	list($info, $headers, $body, $body_parsed) = $retarr; 
	if ($info['http_code'] == 200 && !empty($body)) { 
		$_SESSION['request_token']  = $body_parsed['oauth_token'];
		$_SESSION['request_token_secret']  = $body_parsed['oauth_token_secret']; 
		$_SESSION['oauth_verifier'] = $body_parsed['oauth_token']; 
		echo  '<a href="'.urldecode($body_parsed['xoauth_request_auth_url']).'" >Yahoo Contact list</a>';
	} 
}
?> 