<?php
//logout.php
include_once(dirname(__FILE__)."/../include_app/cookieSession.php");

// セッションを開始
session_start();

// セッション変数のクリア
$_SESSION = array();

// セッションを破棄
session_destroy();

// セッションクッキーの削除
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// ヘッダーの送信前に出力バッファをクリア
ob_clean();

$status = 1;
header("Location: /login.php?status=" . $status);
exit;