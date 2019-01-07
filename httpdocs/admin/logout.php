<?php
//logout.php
include_once(dirname(__FILE__)."/../include_app/cookieSession.php");

// セッション変数のクリア
$_SESSION = array();
// クッキーの破棄
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
// セッションクリア
@session_destroy();
$status = 1;
header("Location: /login.php?status=" . $status);
exit;