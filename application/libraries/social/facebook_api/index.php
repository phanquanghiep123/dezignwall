<?php
require 'src/facebook.php';
$facebook = new Facebook(array(
    'appId' => '845300492232336',
    'secret' => '6e553b2d41c3e934fcd7c16f7634113b',
    'cookie' => true,
));

$user       = $facebook->getUser();
$loginUrl   = $facebook->getLoginUrl(
        array(
            'scope' => 'email'
        )
);

if ($user) {
  try {
    $user_profile = $facebook->api('/me');
    $user_friends = $facebook->api('/me/friends');//taggable_friends
    $access_token = $facebook->getAccessToken();
  } catch (FacebookApiException $e) {
    d($e); 
    $user = null;
  }
}

var_dump($user_profile);

if (!$user) {
    echo "<script type='text/javascript'>top.location.href = '$loginUrl';</script>";
    exit;
}
echo '<pre>';
print_r($user_friends);

$total_friends = count($user_friends['data']);
echo 'Total friends: '.$total_friends.'.<br />';
$start = 0;
while ($start < $total_friends) {
    echo $user_friends['data'][$start]['name'];
    echo '<br />';
    $start++;
}



/* Get list friends */
/*
// get all friends who has given our app permissions to access their data
$fql = "SELECT uid, first_name, last_name, email FROM user "
     . "WHERE is_app_user = 1 AND uid IN (SELECT uid2 FROM friend WHERE uid1 = ".$user_profile['id'].")";
$friends = $facebook->api(array(
  'method'       => 'fql.query',
  'access_token' => $access_token,
  'query'        => $fql,
));

// make an array of all friend ids
$friendIds = array();
foreach ($friends as $friend) {
  $friendIds[] = $friend['uid'];
}

// get info of all the friends without using any access token
$friendIds = implode(',', $friendIds);
$fql = "SELECT uid, first_name, last_name, email FROM user WHERE uid IN ($friendIds)";
$friends = $friends->api(array(
  'method' => 'fql.query',
  'query'  => $fql,
  // don't use an access token
));

// we should now have a list of friend infos with their email addresses
print_r($friends);

*/









/*
if ($facebook->getUser() == 0) {
    $login = $facebook->getLoginUrl(array('scope' => 'email,user_birthday,user_friends'));
    echo "<a href= '$login'>Login with Facebook</a>";
} else {
    $user_profile = $facebook->api('/me');

    $user_friends = $facebook->api('/me/friends/');
    $access_token = $facebook->getAccessToken();

    echo "<pre>";
    print_r($user_profile);
    echo "</pre>";
    echo "<br/>";
    echo "<pre>";
    print_r($user_friends);
    echo "</pre>";
}
*/
?>