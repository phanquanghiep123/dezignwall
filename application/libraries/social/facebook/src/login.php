<?php
if (!session_id()) {
    session_start();
}

if(!function_exists('hash_equals'))
{
    function hash_equals($str1, $str2)
    {
        if(strlen($str1) != strlen($str2))
        {
            return false;
        }
        else
        {
            $res = $str1 ^ $str2;
            $ret = 0;
            for($i = strlen($res) - 1; $i >= 0; $i--)
            {
                $ret |= ord($res[$i]);
            }
            return !$ret;
        }
    }
}

require_once 'Facebook/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '1462720257382966', // Replace {app-id} with your app id
  'app_secret' => '872d9255a0b04487b3c00a506ee3cf24',
  'default_graph_version' => 'v2.6',
  'persistent_data_handler'=>'session'
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://betadev.dezignwalldev.com/social/facebook/src/fb-callback.php', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';

?>