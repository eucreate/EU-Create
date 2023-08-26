<?php
ini_set('session.use_only_cookies', '1');
ini_set('session.cookie_secure', '1');  // HTTPS接続の場合のみクッキーを送信
ini_set('session.cookie_httponly', '1'); // JavaScriptからのアクセスを防ぐ
session_name("EUCREATEWEBID");
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['useCookie'])) {
	$_SESSION['useCookie'] = true;
	$urlSessionSet = session_name() . "=" . session_id();
} else {
	$urlSessionSet = "";
	session_regenerate_id(true);
}