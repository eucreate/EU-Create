<?php
$realPath = substr(dirname(__FILE__), 0, -strlen(basename(dirname(__FILE__))));
$rootPath = "";
$realPathPrivate = substr($realPath, 0, -9)."private/";

require_once($realPath . $rootPath . "include_app/function.php");
require_once($realPath . $rootPath . "include_app/database.php");

$viewDir = "view";
$viewPath = $rootPath.$viewDir;
$viewFileExt = ".tpl";

if ($_SERVER['SERVER_NAME'] == "xxx.test" || $_SERVER['SERVER_NAME'] == "xxx.example") {
	// テスト用
	$emailAddress = "yyy@yyy.yyy";
} else {
	// 本番用
	$emailAddress = "xxx@xxx.xxx";
}

$pageType = array(1 => "PC &amp; Smartphone", "Mobile");

$siteName = "Site Name";

$customHeader = null;
$backUrlReferer = false;

// データベース
define('dbServer', "sqlite_db_name.filename_extension");
define('dbName', "");
define('dbUser', "");
define('dbPass', "");
$dbPath = "sqlite:" . $realPathPrivate . dbServer;