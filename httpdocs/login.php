<?php
require_once(dirname(__FILE__).'/include_app/config.php');
require_once($realPath . $rootPath . "include_app/cookieSession.php");

$db = new dbc();

$fileName = pathinfo(__FILE__, PATHINFO_FILENAME);
$pageTitle = "Login to the admin page";

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

// Login processing
// Check login status
if (isset($_SESSION["USERID"])) {
	$db->disconnect();
}
if (isset($_GET["status"]) && (int)$_GET["status"] === 1) {
	$status = "Logged out.";
}
if (isset($_POST["id"], $_POST["pass"]) && strlen($_POST["id"]) > 0 && strlen($_POST["pass"]) > 0 ) {
	if (strlen($_POST["id"]) === 0) {
		$formname = "";
	} else {
		$formname = $_POST["id"];
	}
	$sql = "SELECT * FROM users WHERE name = ?";
	$sqlParam = array($formname);
	// Read database tables
	$result = $db->getRow($sql, $sqlParam);
	if (!empty($result) && password_verify($_POST["pass"], $result[0]["password"])) {
		foreach($result as $row) {
			$userId = $row["id"];
		}
		// Issue a new session ID
		session_regenerate_id(TRUE);
		$_SESSION["USERID"] = $userId;
		$db->disconnect();
		header("Location: /admin/index.php");
		exit;
	} else {
		$db->disconnect();
		$status = "The ID or password is incorrect.";
	}
} elseif (isset($_POST["id"], $_POST["pass"]) && strlen($_POST["id"]) > 0 && strlen($_POST["pass"]) === 0 ) {
	$db->disconnect();
	$status = "Password isn't entered.";
} elseif (isset($_POST["id"], $_POST["pass"]) && strlen($_POST["id"]) === 0 && strlen($_POST["pass"]) > 0 ) {
	$db->disconnect();
	$status = "ID isn't entered.";
} elseif (isset($_POST["id"], $_POST["pass"]) && strlen($_POST["id"]) === 0 && strlen($_POST["pass"]) === 0) {
	$db->disconnect();
	$status = "ID and password aren't entered.";
}
include_once($realPath.$viewDir."/".$fileName.$viewFileExt);
$db->disconnect();