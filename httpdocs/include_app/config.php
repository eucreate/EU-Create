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
  define('MAIL_SMTPAUTH', false);
  define('MAIL_HOST', 'example.com');
  define('MAIL_USERNAME', 'example.com');
  define('MAIL_PASSWORD', 'examplepassword');
  define('MAIL_PORT', 25);
  define('MAIL_SMTPSECURE', false);
} else {
  // For production
  $emailAddress = "xxx@xxx.xxx";
  define('MAIL_SMTPAUTH', true);
  define('MAIL_HOST', 'xxx.xxx.xxx');
  define('MAIL_USERNAME', 'xxx@xxx.xxx');
  define('MAIL_PASSWORD', 'Password');
  define('MAIL_PORT', 465);
  define('MAIL_SMTPSECURE', 'ssl');
}

$pageType = array(1 => "Responsive", "Mobile");

$customHeader = null;
$backUrlReferer = false;

$langID = array("ja", "en-US", "zh-cmn-Hans");

// Database
define('dbType', "MySQL"); // MySQL(MariaDB) or sqlite
define('dbServer', "localhost");
define('dbUser', "Database user name");
define('dbPass', "Database password");
define('dbName', "Database name");
define('dbCharset', "utf8mb4");
define('dbSqlite', "xxx.xx");
define('sqlitePath', $realPathPrivate);

// Retrieve configuration information from database
$db = new dbc();
$getConfigSql = "SELECT * FROM siteConfig";
$configResult = $db->getRow($getConfigSql);
$configDB = array_column($configResult, 'configValue');
$siteName = $configDB[0];
$description = $configDB[1];
$db->disconnect();