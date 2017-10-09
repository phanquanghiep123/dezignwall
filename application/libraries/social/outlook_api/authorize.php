<?php
  session_start();
  require_once('oauth.php');
  $auth_code = $_GET['code'];
  $redirectUri = 'https://dezignwall.com/social/authorize.php';

  $tokens = oAuthService::getTokenFromAuthCode($auth_code, $redirectUri);

  if ($tokens['access_token']) {
    $_SESSION['access_token'] = $tokens['access_token'];

      // Get the user's email from the ID token
  	$user_email = oAuthService::getUserEmailFromIdToken($tokens['id_token']);
  	$_SESSION['user_email'] = $user_email;

  	if (!isset($page)) {
  		$page = "home";
  	}

    // Redirect back to home page
    header("Location: https://www.dezignwall.com/social/contacts.php");
  }
  else
  {
    echo "<p>ERROR: ".$tokens['error']."</p>";
  }
?>