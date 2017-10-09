<?php
require_once __DIR__ . '/bootstrap.php';
$helper = $fb->getRedirectLoginHelper();
$permissions =['email', 'public_profile', 'user_friends']; 
$loginUrl = $helper->getLoginUrl('http://betadev.dezignwalldev.com/social/facebook_api/sdk/teturn.php', $permissions);
header('Location: '.$loginUrl.'');