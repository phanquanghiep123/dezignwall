<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/Facebook/autoload.php';
$fb = new Facebook\Facebook([
  'app_id' => '1728376397375375',
  'app_secret' => 'd560c8806af1c82d71fef55124c22185',
  'default_graph_version' => 'v2.6',
]);