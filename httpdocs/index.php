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

parse_str($_SERVER["QUERY_STRING"], $qs);
if (array_key_exists("pages", $qs) === false && count($qs) === 0) {
	$pages = "index";
} elseif (isset($_GET["pages"]) && $_GET["pages"] != "index" && preg_match('/^[a-zA-Z0-9_\-]*$/', $_GET["pages"])) {
	$pages = $qs["pages"];
} else {
	$pages = "";
}

if (isset($_GET["categoriesName"]) && $_GET["categoriesName"] != "" && preg_match('/^[a-zA-Z0-9_\-]*$/', $_GET["categoriesName"])) {
	$pagesCategory = $_GET["categoriesName"];
} else {
	$pagesCategory = "top";
}

$db = new dbc();
if (isset($_GET["preview"]) && (int)$_GET["preview"] === 1) {
	$getPagesSql = "SELECT * FROM pages INNER JOIN pagesCategories ON pages.pagesCategoriesID = pagesCategories.pagesCategoriesID WHERE name = ? AND categoriesName = ? AND type = ?";
	$getPagesRow = "SELECT COUNT(*) FROM pages INNER JOIN pagesCategories ON pages.pagesCategoriesID = pagesCategories.pagesCategoriesID WHERE name = ? AND categoriesName = ? AND type = ?";
	$getPagesParam = array($pages, $pagesCategory, $displayPageType);
} else {
	$getPagesSql = "SELECT * FROM pages INNER JOIN pagesCategories ON pages.pagesCategoriesID = pagesCategories.pagesCategoriesID WHERE name = ? AND categoriesName = ? AND status = ? AND type = ?";
	$getPagesRow = "SELECT COUNT(*) FROM pages INNER JOIN pagesCategories ON pages.pagesCategoriesID = pagesCategories.pagesCategoriesID WHERE name = ? AND categoriesName = ? AND status = ? AND type = ?";
	$getPagesParam = array($pages, $pagesCategory, 1, $displayPageType);
}
$result = $db->getRow($getPagesSql, $getPagesParam);
$rows = $db->getRowSelect($getPagesRow, $getPagesParam);
if ($rows > 0) {
	foreach ($result as $row) {
		$pageTitle = $row["title"];
		$customHeader = $row["header"];
		$pagesContents = $row["contents"];
		$pagesPhpScript = $row["phpScript"];
	}
} else {
	$pageTitle = "Not Found";
	$pagesContents = "<p>Not Found<br>ページが見つかりませんでした。</p>\n<p><a href=\"/\">Front Page</a></p>\n";
	$pagesPhpScript = 0;
}

include_once($realPath.$viewDir."/".$fileName.$viewFileExt);
$db->Disconnect();