<?php
require_once(dirname(__FILE__).'/include_app/config.php');

require_once($realPath . $rootPath . "include_app/cookieSession.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require('./lib/PHPMailer/PHPMailer.php');
require('./lib/PHPMailer/Exception.php');
require('./lib/PHPMailer/SMTP.php');

require './lib/PHPMailer/language/phpmailer.lang-ja.php';

$mail = new PHPMailer(true);
$mailReturn = new PHPMailer(true);

$fileName = pathinfo(__FILE__, PATHINFO_FILENAME);
$pageTitle = "お問い合わせ";

list($uaBrowserInfo, $viewDir) = getBrowserInfo($viewDir);
$backUrlReferer = true;

$errorName = false;
$errorNameFurigana = false;
$errorEmail = false;
$errorEmailCheck = false;
$errorMessage = false;

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

if (isset($_POST['check'], $_SESSION['ticket'], $_POST['ticket']) && $_POST['check'] === "OK" && $_SESSION['ticket'] != $_POST['ticket']) {
	$mailStatus = 2;
	$_SESSION['mailStatus'] = $mailStatus;
	$url = "/contactFin.php";
	if ($urlSessionSet != "") {
		$url .= "?".$urlSessionSet;
	}
	header("Location: ". $url);
	exit;
} elseif (isset($_POST['check'], $_SESSION['ticket'], $_POST['ticket']) && $_POST['check'] === "OK" && $_SESSION['ticket'] === $_POST['ticket']) {
	// メール送信処理
	mb_language("japanese");
	mb_internal_encoding("UTF-8");
	$formEmail = $_POST['email'];
	$to = $emailAddress;
	$subject = "お問い合わせ";
	$message = "お問い合わせがありました。\n\n";
	$message .= "お名前：{$_POST['name']}
ふりがな：{$_POST['nameFurigana']}
メールアドレス：{$formEmail}
メッセージ：
{$_POST['message']}";
	$message .= "\n\n" . $_SERVER['HTTP_USER_AGENT'];
	$message .= "\n" . $_SERVER["REMOTE_ADDR"];
	$from = "From:".mb_encode_mimeheader($_POST['name'])."<".$formEmail.">";
	$from .= "\nX-Mailer: EU-Create Form Mail";
	$from .= "\nReturn-Path:" . $_POST['email'];
	// mobile
	if ($uaBrowserInfo["type"] === "mobile") {
	//	mb_language("uni");
		$message = "お問い合わせがありました。\n\n";
		$message .= "お名前：".mb_convert_encoding($_POST['name'], "UTF-8", "SJIS-win")."
ふりがな：".mb_convert_encoding($_POST['nameFurigana'], "UTF-8", "SJIS-win")."
メールアドレス：{$formEmail}
メッセージ：
".mb_convert_kana(mb_convert_encoding($_POST['message'], "UTF-8", "SJIS-win"), "KV");
		$from = "From:".mb_encode_mimeheader(mb_convert_encoding($_POST['name'], "UTF-8", "SJIS-win"))."<".$formEmail.">";
	}
	// if (mb_send_mail($to, $subject, $message, $from, '-f'.$emailAddress)) {
	// 	$mailStatus = 1;
	// } else {
	// 	$mailStatus = 0;
	// }
	$mail->setLanguage('ja', './lib/PHPMailer/language/');
	try {
		$mail->isSMTP();
		$mail->HOST = MAIL_HOST;
		$mail->SMTPAuth = MAIL_SMTPAUTH;
		$mail->Username = MAIL_USERNAME; //アカウント名
		$mail->Password = MAIL_PASSWORD; //アカウントのパスワード
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  // 暗号化を有効に
		$mail->SMTPOptions = array(
			'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
			)
		);
		$mail->SMTPSecure = MAIL_SMTPSECURE;  // 暗号化を有効（tls or ssl）無効の場合はfalse
		$mail->Port = MAIL_PORT;
		$mail->XMailer = 'EU-Create Form Mail';

		$mail->CharSet = "utf-8";
    	$mail->Encoding = "base64";
		$mail->setFrom($formEmail, $_POST['name']);
		$mail->addAddress($to, 'EU-Create');
		$mail->Subject = $subject;
		$mail->Body = $message;

		$mail->Send();

		$mailStatus = 1;
	} catch (Exception $e) {
		echo 'メール送信に失敗しました [Error: '.$mail->ErrorInfo.']';
		$mailStatus = 0;
	}
	// ChatWork
	$token = 'xxxxxxxxxxxxxxxxxx';
	$room = 'xxxxxxxxx';
	$cwmsg = "eu-create.netのお問い合わせフォームからお問い合わせがありました。\n";
	$cwmsg .= "[info][title]お問い合わせ[/title]お問い合わせがありました。\n\n";
	$cwmsg .= "お名前：{$_POST['name']}
ふりがな：{$_POST['nameFurigana']}
メールアドレス：{$formEmail}
メッセージ：
{$_POST['message']}";
	$cwmsg .= "\n\n" . $_SERVER['HTTP_USER_AGENT'];
	$cwmsg .= "\n" . $_SERVER["REMOTE_ADDR"] . "[/info]";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HTTPHEADER,
		array('X-ChatWorkToken: '.$token));
	curl_setopt($ch, CURLOPT_URL, "https://api.chatwork.com/v2/rooms/".$room."/messages");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, array('body' => $cwmsg, 'self_unread' => 1));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$messageId = curl_exec($ch);
	curl_close($ch);
	// お問い合わせした方へのメール送信
	$from = "From:".mb_encode_mimeheader($siteName)."<".$emailAddress.">";
	$from .= "\nX-Mailer: EU-Create Form Mail";
	$from .= "\nReturn-Path: " . $emailAddress;
	$to = $_POST['email'];
	$subject = "お問い合わせを受け付けました";
	$message = "{$_POST['name']} 様\n\nお問い合わせを受け付けました。\n\n";
	$message .= "お名前：{$_POST['name']}
ふりがな：{$_POST['nameFurigana']}
メールアドレス：{$formEmail}
メッセージ：
{$_POST['message']}

-- 
{$siteName}
http://{$_SERVER['SERVER_NAME']}/
{$emailAddress}";
	// mobile
	if ($uaBrowserInfo["type"] === "mobile") {
	//	mb_language("uni");
		$message = mb_convert_encoding($_POST['name'], "UTF-8", "SJIS-win")." 様\n\nお問い合わせを受け付けました。\n\n";
		$message .= "お名前：".mb_convert_encoding($_POST['name'], "UTF-8", "SJIS-win")."
ふりがな：".mb_convert_encoding($_POST['nameFurigana'], "UTF-8", "SJIS-win")."
メールアドレス：{$formEmail}
メッセージ：
".mb_convert_kana(mb_convert_encoding($_POST['message'], "UTF-8", "SJIS-win"), "KV");
	}
	$pEmailAddress = '-f' . $emailAddress;
	//mb_send_mail($to, $subject, $message, $from, $pEmailAddress);
	$mailReturn->setLanguage('ja', './lib/PHPMailer/language/');
	try {
		$mailReturn->isSMTP();
		$mailReturn->HOST = MAIL_HOST;
		$mailReturn->SMTPAuth = MAIL_SMTPAUTH;
		$mailReturn->Username = MAIL_USERNAME; //アカウント名
		$mailReturn->Password = MAIL_PASSWORD; //アカウントのパスワード
		$mailReturn->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  // 暗号化を有効に
		$mailReturn->SMTPOptions = array(
			'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
			)
		);
		$mailReturn->SMTPSecure = MAIL_SMTPSECURE;  // 暗号化を有効（tls or ssl）無効の場合はfalse
		$mailReturn->Port = MAIL_PORT;
		$mailReturn->XMailer = 'EU-Create Form Mail';

		$mailReturn->CharSet = "utf-8";
    	$mailReturn->Encoding = "base64";
		$mailReturn->setFrom($emailAddress, 'EU-Create');
		$mailReturn->addAddress($_POST['email'], $_POST['name']);
		$mailReturn->Subject = $subject;
		$mailReturn->Body = $message;

		$mailReturn->Send();
	} catch (Exception $e) {
		echo 'メール送信に失敗しました [Error: '.$mailReturn->ErrorInfo.']';
	}
	$_SESSION['mailStatus'] = $mailStatus;
	$url = "/contactFin.php";
	if ($urlSessionSet != "") {
		$url .= "?".$urlSessionSet;
	}
	header("Location: ". $url);
	exit;
} elseif ($_POST && !isset($_POST['check'])) {
	// 入力チェックと確認画面
	$pageTitle .= "（確認）";
	if ($_POST['name'] == "") {
		$errorName = true;
		$errorNameValue = "お名前が未入力です。";
	}
	if ($_POST['nameFurigana'] == "") {
		$errorNameFurigana = true;
		$errorNameFuriganaValue = "ふりがなが未入力です。";
	}
	if ($_POST['message'] == "" || $_POST['message'] === "メッセージを入力してください。") {
		$errorMessage = true;
		$errorMessageValue = "メッセージ本文が未入力です。";
	}
	if ($_POST['email'] == "") {
		$errorEmail = true;
		$errorEmailValue = "メールアドレスが未入力です。";
	} elseif (preg_match("/^[a-zA-Z0-9_\.\-]+?@[A-Za-z0-9_\.\-]+$/", $_POST['email']) === 0) {
		$errorEmail = true;
		$errorEmailValue = "メールアドレスが正しく入力されていません。";
	}
	if ($errorName || $errorEmail || $errorMessage) {
	$customHeader = <<<EOF
<script>
<!--
function foc() {    //テキストエリア内が初期文字列の場合　クリア
	if(document.mailForm.message.value == "メッセージを入力してください。") {
		document.mailForm.message.value = "";
	}
}
//-->
</script>
EOF;
	} else {
		$_SESSION['ticket'] = md5(uniqid(rand(), true));
	}
	include_once($realPath.$viewDir."/".$fileName."Conf".$viewFileExt);
} else {
	// 入力画面
	$customHeader = <<<EOF
<script>
<!--
function foc() {    //テキストエリア内が初期文字列の場合　クリア
	if(document.mailForm.message.value == document.mailForm.message.defaultValue) {
		document.mailForm.message.value = "";
	}
}
//-->
</script>
EOF;
	if (!empty($_SERVER['HTTP_REFERER'])) {
		$refererParse = parse_url($_SERVER['HTTP_REFERER']);
//		if ($refererParse === $_SERVER['SERVER_NAME']) {
			$_SESSION['refererUrl'] = $_SERVER['HTTP_REFERER'];
			$_SESSION['refererTitle'] = getPageTitle($_SERVER['HTTP_REFERER']);
//		}
	} else {
		$_SESSION['refererUrl'] = "";
		$_SESSION['refererTitle'] = "";
	}
	include_once($realPath.$viewDir."/".$fileName.$viewFileExt);
}