<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<?php
if ($_SERVER["SCRIPT_NAME"] === "/news.php") {
  $categoryName = "News - ";
} elseif (isset($categoriesName) && $categoriesName !== "top" && $categoriesName !== "") {
  $categoryName = " - " . $categoriesTitle;
} else {
  $categoryName = "";
}
?>
<title><?php echo $pageTitle . $categoryName . ": " . $siteName; ?></title>
<meta name="viewport" content="width=device-width">
<meta name="format-detection" content="telephone=no">
<meta property="og:type" content="website">
<meta property="og:title" content="<?php echo $pageTitle . ": " . $siteName; ?>">
<meta property="og:url" content="https://www.xxx.xxx<?php echo $_SERVER["REQUEST_URI"]; ?>">
<?php
  if (isset($pagesOgpDescription) && $pagesOgpDescription != "") {
    echo "<meta property=\"og:description\" content=\"" . $pagesOgpDescription . "\">\n";
  } else {
    echo "<meta property=\"og:description\" content=\"" . $description . "\">\n";
  }
?>
<meta property="og:image" content="https://www.xxx.xxx/assets/images/common/ogp.png">
<meta property="og:site_name" content="<?php echo htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="twitter:card" content="summary">
<?php
date_default_timezone_set('Asia/Tokyo');
$commonCssFile = '/' . $viewPath . '/css/common.css';
$commonCssFilePath = '.' . $commonCssFile;
?>
<link rel="stylesheet" href="<?php echo $commonCssFile . '?' . date("YmdHis", filemtime($commonCssFilePath)); ?>" media="all">
<?php if ($_SERVER['SCRIPT_NAME'] === "/contact.php") { ?><link rel="stylesheet" href="/<?php echo $viewPath; ?>/css/style.css" media="all"><?php } ?>
<?php if ($_SERVER["SERVER_NAME"] === "xxx.xxx" || $_SERVER["SERVER_NAME"] === "www.xxx.xxx") {?>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=xxxxxx"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'xxxxxx');
</script>
<?php } ?>
<script src="/<?php echo $viewPath; ?>/js/common.js"></script>
<?php if ($customHeader != null || $customHeader != "") { echo $customHeader."\n"; } ?>
</head>
<body>
<?php if ($backUrlReferer == true ) {
	$backUrl = $_SESSION['refererUrl'];
} else {
	$backUrl = "http://" . $_SERVER['SERVER_NAME'] . "/";
}
?>
<header>
<?php if (isset($pagesDescriptionFlag) && $pagesDescriptionFlag > 0) { ?>
  <div id="headerUpper">
    <div id="headerUpperInner">
      <p><?php echo $description; ?></p>
      <!-- /#headerUpper --></div>
    <!-- /#headerUpperInner --></div>
<?php } ?>
  <div id="headerUnder">
    <div id="headerUnderInner">
      <h1><a href="<?php echo $backUrl; ?>"><img src="/<?php echo $viewPath; ?>/images/logo.svg" alt="<?php echo $siteName; ?>" width="220"></a></h1>
      <div id="search">
        <form action="/search.php" method="post">
          <input type="search" name="words" placeholder="Word (multiple search with single-byte space)">
          <select name="mode" id="selectMode">
            <option value="1">Page</option>
            <option value="2">News</option>
          </select>
          <input type="submit" value="Search">
        </form>
      </div>
      <!-- /#headerUnderInner --></div>
  <!-- /#headerUnder --></div>
  <div class="headerMenu">
    <details>
	<summary>メニュー</summary>
    <p>テーマ：
    <label><input type="radio" name="themeMode" value=""> システム</label>
    <label><input type="radio" name="themeMode" value="オリジナル"> オリジナル</label>
    <label><input type="radio" name="themeMode" value="ダーク"> ダーク</label>
    </p>
    <ul>
      <li><a href="/production.html">ホームページの制作について</a></li>
      <li><a href="/coding-rule.html">コーディングルール</a></li>
      <li><a href="/about.html">EU-Create概要</a></li>
      <li><a href="/about/law.html">特定商取引法に基づく開示</a></li>
      <li><a href="/certificate.html">電子証明書について</a></li>
      <li><a href="/contact.php">お問い合わせ</a></li>
      <li><a href="https://lin.ee/7MCjQr0"><img src="https://scdn.line-apps.com/n/line_add_friends/btn/ja.png" alt="友だち追加" height="36" border="0"></a></li>
      <li><a href="/blog/">ブログ</a></li>
    </ul>
    </details>
  </div>
</header>
<div id="contents">
<?php
  if (isset($pagesTopicPath) && (int)$pagesTopicPath === 1) {
    if (isset($pagesCategoriesID) && (int)$pagesCategoriesID === 1) {
      echo "<p class=\"topicPath\"><a href=\"/\">" . $siteName . "</a>&nbsp;&gt;&nbsp;" . $pageTitle . "</p>\n";
    } else {
      echo "<p class=\"topicPath\"><a href=\"/\">" . $siteName . "</a>&nbsp;&gt;&nbsp;<a href=\"/" . $categoriesName . ".html\">" . $categoriesTitle . "</a>&nbsp;&gt;&nbsp;" . $pageTitle . "</p>\n";
    }
  }
?>