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

if (isset($_POST["words"]) && $_POST["words"] != "") {
  $pageTitle = "「" . htmlspecialchars($_POST["words"], ENT_QUOTES, 'UTF-8') . "」の";
  $searchWords = explode(" ", htmlspecialchars($_POST["words"], ENT_QUOTES, 'UTF-8'));
  $db = new dbc();
  if ((int)$_POST["mode"] === 1) {
    $pageTitle .= "ページ検索結果";
    $keywordCondition = array();
    foreach ($searchWords as $keyword) {
      $keywordCondition[] = "contents LIKE ?";
    }
    $keywordCondition = implode(' AND ', $keywordCondition);
    $getSearchSql = "SELECT * FROM pages INNER JOIN pagesCategories ON pages.pagesCategoriesID = pagesCategories.pagesCategoriesID WHERE type = 1 AND status = 1 AND langID = 0 AND {$keywordCondition}";
    $paramKeywords = array();
  } else {
    $keywordCondition = array();
    foreach ($searchWords as $keyword) {
      $keywordCondition[] = "newsBody LIKE ?";
    }
    $keywordCondition = implode(' AND ', $keywordCondition);
    $pageTitle .= "ニュース検索結果";
    $getSearchSql = "SELECT * FROM news WHERE newsPublicFlag = 1 AND {$keywordCondition}";
  }
  foreach ($searchWords as $keyword) {
    $paramKeywords[] = "%" . $keyword . "%";
  }
  $getSearchParam = array();
  $getSearchParam = array_merge($getSearchParam, $paramKeywords);
  $result = $db->getRow($getSearchSql, $getSearchParam);
  $db->Disconnect();
} else {
  $pageTitle = "検索結果";
}
include_once($realPath.$viewDir."/".$fileName.$viewFileExt);