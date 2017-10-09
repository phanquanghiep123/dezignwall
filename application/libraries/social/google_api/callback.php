<?php
session_start();

//google response with contact. We set a session and redirect back
if (isset($_GET['code'])) {
	$auth_code = $_GET["code"];
	$_SESSION['google_code'] = $auth_code;
	header('Location: http://betadev.dezignwalldev.com/social/google_api/index.php');
}

?>