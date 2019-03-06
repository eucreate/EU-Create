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
}

if (isset($_POST["words"]) && $_POST["words"] != "") {
  //var_dump($_POST);
  $pageTitle = "&quot;" . htmlspecialchars($_POST["words"], ENT_QUOTES, 'UTF-8') . "&quot;";
  $db = new dbc();
  if ((int)$_POST["mode"] === 1) {
    $pageTitle .= " page search result";
    $getSearchSql = "SELECT * FROM pages INNER JOIN pagesCategories ON pages.pagesCategoriesID = pagesCategories.pagesCategoriesID WHERE type = 1 AND status = 1 AND contents LIKE ?";
  } else {
    $pageTitle .= " news search result";
    $getSearchSql = "SELECT * FROM news WHERE newsPublicFlag = 1 AND newsBody LIKE ?";
  }
  $getSearchParam = array("%" . htmlspecialchars($_POST["words"], ENT_QUOTES, 'UTF-8') . "%");
  $result = $db->getRow($getSearchSql, $getSearchParam);
  //var_dump($result);
  $db->Disconnect();
} else {
  $pageTitle = "Search result";
}
include_once($realPath.$viewDir."/".$fileName.$viewFileExt);