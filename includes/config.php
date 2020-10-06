<?php
$testMode = true;
if ($testMode) {
  error_reporting(-1);
  ini_set("display_errors", 1);
  define("DBHOST", "127.0.0.1");
  define("DBUSER", "root");
  define("DBPASS", "");
  define("DBDATABASE", "restapi");
} else {
  error_reporting(-1);
  ini_set("display_errors", 1);
  define("DBHOST", "cpsrv52.misshosting.com");
  define("DBUSER", "ehgzrrai_bjorn");
  define("DBPASS", "skoterleif01");
  define("DBDATABASE", "ehgzrrai_restapi");
}

/*Autoload of classes*/
spl_autoload_register('myAutoClass');
function myAutoClass($className) {  

  $path = 'classes/';
  $extension = '.class.php';
  $fileName = $path . $className . $extension;

  if (!file_exists($fileName)) {
    return false;
  }
  include_once $path . $className . $extension;
}
