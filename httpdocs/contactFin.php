<?php
require_once(dirname(__FILE__).'/include_app/config.php');

require_once($realPath . $rootPath . "include_app/cookieSession.php");

$fileName = pathinfo(__FILE__, PATHINFO_FILENAME);
$pageTitle = "お問い合わせ（完了）";

list($uaBrowserInfo, $viewDir) = getBrowserInfo($viewDir);

$mailStatus = array('メールが送信できませんでした。','メールを送信しました。','メールは送信済みか、不正なアクセスです。');

if ($uaBrowserInfo["type"] === "mobile") {
	mb_language("ja");
	mb_internal_encoding("UTF-8");
	mb_http_input("auto");
	mb_http_output("SJIS-win");
	ob_start("mb_output_handler");
}

unset($_SESSION['ticket']);

include($realPath.$viewDir."/".$fileName.$viewFileExt);
/*
unset($_SESSION['mailStatus']);
unset($_SESSION['refererUrl']);
unset($_SESSION['refererTitle']);*/