<?php
if ($uaBrowserInfo["carrier"] === "docomo") {
 header('Content-Type: application/xhtml+xml');
}

// Copyright 2009 Google Inc. All Rights Reserved.
$GA_ACCOUNT = "xxxxx";
$GA_PIXEL = "/ga.php";

function googleAnalyticsGetImageUrl() {
	global $GA_ACCOUNT, $GA_PIXEL;
	$url = "";
	$url .= $GA_PIXEL . "?";
	$url .= "utmac=" . $GA_ACCOUNT;
	$url .= "&utmn=" . rand(0, 0x7fffffff);

	$referer = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
	$query = $_SERVER["QUERY_STRING"];
	$path = $_SERVER["REQUEST_URI"];

	if (empty($referer)) {
		$referer = "-";
	}
	$url .= "&utmr=" . urlencode($referer);

	if (!empty($path)) {
		$url .= "&utmp=" . urlencode($path);
	}

	$url .= "&guid=ON";

	return $url;
}

echo '<?xml version="1.0" encoding="Shift_JIS" ?>'."\n";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-Type" content="application/xhtml+xml; charset=Shift_JIS" />
<title><?php echo $pageTitle; ?>: <?php echo $siteName; ?></title>
<meta http-equiv="Content-Style-Type" content="text/css" />
</head>
<body>
<p><?php echo mb_convert_kana("EU-Create（イーユー・クリエイト）は、フリーランス（SOHO）で長野県東信地区を中心にWebサイト制作をしています。", "ka"); ?></p>
<h1><img src="<?php echo $viewPath; ?>/mobile/images/logo_m.gif" alt="EU-Create.net" width="220" height="65" /></h1>