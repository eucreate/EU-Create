<?php
require_once(dirname(__FILE__).'/include_app/config.php');

require_once($realPath . $rootPath . "include_app/cookieSession.php");

$db = new dbc();

$fileName = pathinfo(__FILE__, PATHINFO_FILENAME);
$pageTitle = "管理画面へログイン";

list($uaBrowserInfo, $viewDir) = getBrowserInfo($viewDir);

if ($uaBrowserInfo["type"] === "mobile") {
	mb_language("ja");
	mb_internal_encoding("UTF-8");
	mb_http_input("auto");
	mb_http_output("SJIS-win");
	ob_start("mb_output_handler");
} else {
	if (empty($_SERVER['HTTPS'])) {
		header("Location: https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}");
		exit;
	}
}

$status = "";

// ログイン処理
// ログイン状態のチェック
if (isset($_SESSION["USERID"])) {
	$db->Disconnect();
}
if (isset($_GET["status"]) && $_GET["status"] === 1) {
	$status = "ログアウトしました。";
}
if (isset($_POST["id"], $_POST["pass"]) && strlen($_POST["id"]) > 0 && strlen($_POST["pass"]) > 0 ) {
	if (strlen($_POST["id"]) === 0) {
		$formname = "";
	} else {
		$formname = $_POST["id"];
	}
	$formpass = hash("Hash algorithm", $_POST["pass"]);
	for ($i=0; $i<XXX; $i++) { // XXX is the hash stretching count
		$formpass = hash("Hash algorithm", $formpass);
	}
	$sql = "SELECT * FROM users WHERE name = ? AND password = ?";
	$sqlParam = array($formname, $formpass);
	$rowSql = "SELECT COUNT(*) FROM users WHERE name = ? AND password = ?";
	// テーブル読み込み
	$result = $db->getRow($sql, $sqlParam);
	$rows = $db->getRowSelect($rowSql, $sqlParam);
	if ($rows > 0) {
		foreach($result as $row) {
			$userId = $row["id"];
		}
		// セッションIDを新規に発行する
		session_regenerate_id(TRUE);
		$_SESSION["USERID"] = $userId;
		$db->Disconnect();
		header("Location: /admin/index.php");
		exit;
	} else {
		$db->Disconnect();
		$status = "IDまたはパスワードが正しくありません。";
	}
} elseif (isset($_POST["id"], $_POST["pass"]) && strlen($_POST["id"]) > 0 && strlen($_POST["pass"]) === 0 ) {
	$db->Disconnect();
	$status = "パスワードが入力されていません。";
} elseif (isset($_POST["id"], $_POST["pass"]) && strlen($_POST["id"]) === 0 && strlen($_POST["pass"]) > 0 ) {
	$db->Disconnect();
	$status = "IDが入力されていません。";
} elseif (isset($_POST["id"], $_POST["pass"]) && strlen($_POST["id"]) === 0 && strlen($_POST["pass"]) === 0) {
	$db->Disconnect();
	$status = "IDとパスワードが入力されていません。";
}
include_once($realPath.$viewDir."/".$fileName.$viewFileExt);
$db->Disconnect();