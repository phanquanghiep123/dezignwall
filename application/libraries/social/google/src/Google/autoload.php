<?php

/**
 * THIS FILE IS FOR BACKWARDS COMPATIBLITY ONLY
 *
 * If you were not already including this file in your project, please ignore it
 */
/*$file = __DIR__ . '/../../vendor/autoload.php';

if (!file_exists($file)) {
  $exception = 'This library must be installed via composer or by downloading the full package.';
  $exception .= ' See the instructions at https://github.com/google/google-api-php-client#installation.';
  throw new Exception($exception);
}

$error = 'google-api-php-client\'s autoloader was moved to vendor/autoload.php in 2.0.0. This ';
$error .= 'redirect will be removed in 2.1. Please adjust your code to use the new location.';
trigger_error($error, E_USER_DEPRECATED);

require_once $file;
*/

function google_api_php_client_autoload($className) {
  $classPath = explode('_', $className);
  if ($classPath[0] != 'Google') {
    return;
  }
  // Drop 'Google', and maximum class file path depth in this project is 3.
  $classPath = array_slice($classPath, 1, 2);
  $filePath = dirname(__FILE__) . '/' . implode('/', $classPath) . '.php';
  if (file_exists($filePath)) {
    require_once($filePath);
  }
}
spl_autoload_register('google_api_php_client_autoload');