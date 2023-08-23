<?php
require_once(dirname(__FILE__).'/include_app/config.php');

$fileName = pathinfo(__FILE__, PATHINFO_FILENAME);
$pageTitle = "";
$displayPageType = 1;

list($uaBrowserInfo, $viewDir) = getBrowserInfo($viewDir);

if ($uaBrowserInfo["type"] === "mobile") {
  mb_language("ja");
  mb_internal_encoding("UTF-8");
  mb_http_input("auto");
  mb_http_output("SJIS-win");
  ob_start("mb_output_handler");
  $displayPageType = 2;
} else {
  if (empty($_SERVER['HTTPS'])) {
    header("Location: https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}");
    exit;
  }
}

$db = new dbc();
$getNewsSql = "SELECT * FROM news WHERE newsId = ?";
$getNewsParam = array((int)$_GET["id"]);
$result = $db->getRow($getNewsSql, $getNewsParam);
if (count($result) > 0) {
  foreach ($result as $row) {
    $pageTitle = $row["newsTitle"];
    $pageDate = $row["newsDspDate"];
    $pagesContents = $row["newsBody"];
  }
} else {
  $pageTitle = "Not Found";
  $pagesContents = "<p>Not Found<br>ページが見つかりませんでした。</p>\n<p><a href=\"/\">" . $siteName . " Front Page</a></p>\n";
}
include_once($realPath.$viewDir."/".$fileName."Detail".$viewFileExt);
$db->disconnect();