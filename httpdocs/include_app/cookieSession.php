<?php
ini_set('session.use_only_cookies', '0');
session_name("xxxxx");
session_start();
if (!empty($_SERVER['HTTPS'])) {
	setcookie("useCookie", 1, 0, "", "", 1);
} else {
	setcookie("useCookie", 1);
}

if (!isset($_COOKIE['useCookie'])) {
	$urlSessionSet = session_name()."=".session_id();
} else {
	$urlSessionSet = "";
	session_regenerate_id(true);
}