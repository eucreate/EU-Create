<?php
$realPath = substr(dirname(__FILE__), 0, -strlen(basename(dirname(__FILE__))));
$rootPath = "";
$realPathPrivate = "xxxx/"; // In the specified folder, it's recommended the restriction of access in the .htaccess.

require_once($realPath . $rootPath . "include_app/function.php");
require_once($realPath . $rootPath . "include_app/database.php");

$viewDir = "view";
$viewPath = $rootPath.$viewDir;
$viewFileExt = ".tpl";

if ($_SERVER['SERVER_NAME'] === "xxx.test" || $_SERVER['SERVER_NAME'] === "xxx.example") {
  // For test
  $emailAddress = "yyy@yyy.yyy";
} else {
  // For production
  $emailAddress = "xxx@xxx.xxx";
}

$pageType = array(1 => "Responsive", "Mobile");

$siteName = "Site Name";
$description = "Description of your site.";

$customHeader = null;
$backUrlReferer = false;

// Database
define('dbType', "sqlite"); // MySQL(MariaDB) or sqlite
define('dbServer', "");
define('dbUser', "");
define('dbPass', "");
define('dbName', "");
define('dbSqlite', "xxx.xx");
define('sqlitePath', $realPathPrivate);
