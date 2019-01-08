<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title><?php echo $pageTitle . ": " . $siteName; ?></title>
<meta name="viewport" content="width=device-width">
<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" href="/<?php echo $viewPath; ?>/css/common.css" media="all">
<?php if ($_SERVER['SCRIPT_NAME'] === "/index.php") { ?><link rel="stylesheet" href="/<?php echo $viewPath; ?>/css/top.css" media="all"><?php } else { ?><link rel="stylesheet" href="/<?php echo $viewPath; ?>/css/style.css" media="all"><?php } echo "\n"; ?>
<?php if ($_SERVER["SERVER_NAME"] === "xxx.xxx" || $_SERVER["SERVER_NAME"] === "www.xxx.xxx") {?>
<script>

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'xxxxxx']);
  _gaq.push(['_setDomainName', 'xxx.xxx']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<?php }
if ($customHeader != null || $customHeader != "") { echo $customHeader."\n"; } ?>
</head>
<body>
<?php if ($backUrlReferer == true ) {
	$backUrl = $_SESSION['refererUrl'];
} else {
	$backUrl = "http://" . $_SERVER['SERVER_NAME'] . "/";
}
?>
<header>
	<div id="headerUpper">
		<div id="headerUpperInner">
			<p>Description of your site</p>
		<!-- /#headerUpper --></div>
	<!-- /#headerUpperInner --></div>
	<div id="headerUnder">
		<div id="headerUnderInner">
			<h1><a href="<?php echo $backUrl; ?>"><img src="/<?php echo $viewPath; ?>/images/logo.gif" alt="Your site name"></a></h1>
		<!-- /#headerUnderInner --></div>
	<!-- /#headerUnder --></div>
</header>
<div id="contents">
