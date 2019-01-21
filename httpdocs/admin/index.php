<?php
$dbPath = "../";
require_once(dirname(__FILE__).'/../include_app/config.php');
require_once($realPath . $rootPath . "include_app/cookieSession.php");
$fileName = pathinfo(__FILE__, PATHINFO_FILENAME);
$pageTitle = "管理画面トップ";
// ログイン状態のチェック
if (!isset($_SESSION["USERID"])) {
  header("Location: /login.php");
  exit;
}
include_once($realPath."admin/".$viewDir."/".$fileName.$viewFileExt);