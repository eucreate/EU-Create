<?php
$dbPath = "../";
require_once(dirname(__FILE__).'/../include_app/config.php');
require_once($realPath . $rootPath . "include_app/cookieSession.php");
$db = new dbc($dbPath);
$fileName = pathinfo(__FILE__, PATHINFO_FILENAME);
$pageTitle = "ページ管理";
// ログイン状態のチェック
if (!isset($_SESSION["USERID"])) {
  header("Location: /login.php");
  exit;
}
if (isset($_GET["mode"]) && $_GET["mode"] === "delete") {
  if (isset($_POST["deleteFlag"]) === false) {
    $sql = "SELECT * FROM pages WHERE id = ?";
    $param = array($_GET["id"]);
    $result = $db->getRow($sql, $param);
  }
  if (isset($_POST["deleteFlag"]) && $_POST["deleteFlag"] === "true") {
    ini_set("max_execution_time",180);
    $sqlDelete = "DELETE FROM pages WHERE id = ?";
    $paramDelete = array($_POST["id"]);
    $db->queryOperation($sqlDelete, $paramDelete);
    header("Location: /admin/pages.php?mode=end&task=delete");
    exit;
  }
  $pageTitle .= "（削除）";
  include_once($realPath."admin/".$viewDir."/".$fileName."Delete".$viewFileExt);
} elseif (isset($_GET["mode"]) && $_GET["mode"] === "edit") {
  //編集
  if (isset($_POST["formStatus"]) === false) {
    $sql = "SELECT * FROM pages INNER JOIN pagesCategories ON pages.pagesCategoriesID = pagesCategories.pagesCategoriesID WHERE pages.id = ?";
    $param = array($_GET["id"]);
    $result = $db->getRow($sql, $param);
    foreach ($result as $data) {
      $_POST["id"] = $data["id"];
      $_POST["name"] = $data["name"];
      $_POST["nameOld"] = $data["name"];
      $_POST["title"] = $data["title"];
      $_POST["header"] = $data["header"];
      $_POST["formContents"] = $data["contents"];
      $_POST["phpScript"][0] = $data["phpScript"];
      $_POST["status"] = $data["status"];
      $_POST["pageType"] = $data["type"];
      $_POST["ogpDescription"] = $data["ogpDescription"];
      $_POST["topicPath"] = $data["topicPath"];
      $_POST["langID"] = $data["langID"];
    }
  }
  if (isset($_POST["formStatus"]) && $_POST["formStatus"] === "check") {
    $errorMessage = array();
    //ページ名が入力されているかチェック
    if (isset($_POST["name"]) && $_POST["name"] === "") {
      $errorMessage = array("name" => "ページ名が入力されていません。");
    }
    //ページ名が登録済みかチェック
    if (isset($_POST["name"]) && $_POST["name"] != "" && $_POST["name"] != $_POST["nameOld"]) {
      $sqlCheck = "SELECT COUNT(*) FROM pages WHERE pageType = ? AND pagesCategoryID = ? AND name LIKE ?";
      $paramCheck = array($_POST["pageType"], $_POST["pagesCategoryID"], $_POST["name"]);
      $rowsCheck = $db->getRow($sqlCheck, $paramCheck);
      if ($rowsCheck[0]["COUNT(*)"] > 0) {
        $errorMessage = array("name" => "ページ名「".htmlspecialchars($_POST["name"])."」は登録済みです。");
      }
    }
    //チェックしてエラーが無い場合
    if (isset($_POST["name"]) && count($errorMessage) === 0) {
      $phpScript = (isset($_POST["phpScript"]) && $_POST["phpScript"][0] == 1) ? 1 : 0;
      $ogpDescription = (isset($_POST["ogpDescription"]) && $_POST["ogpDescription"] != "") ? htmlspecialchars($_POST["ogpDescription"], ENT_QUOTES, 'UTF-8') : NULL;
      $topicPath = (isset($_POST["topicPath"]) && $_POST["topicPath"][0] == 1) ? 1 : 0;
      ini_set("max_execution_time",180);
      $sqlUpdate = "UPDATE pages SET name = ?, title = ?, header = ?, contents = ?, status = ?, modified = NOW(), phpScript = ?, type = ?, ogpDescription = ?, topicPath = ?, langID = ? WHERE id = ?";
      $paramUpdate = array($_POST["name"], $_POST["title"], $_POST["header"], $_POST["formContents"], (int)$_POST["status"], (int)$phpScript, (int)$_POST["pageType"], $ogpDescription, (int)$topicPath, (int)$_POST["langID"], (int)$_POST["id"]);
      $db->queryOperation($sqlUpdate, $paramUpdate);
      header("Location: /admin/pages.php?mode=end&task=edit");
      exit;
    }
  }
  $pageTitle .= "（編集）";
  $customHeader = "<script src=\"/js/ckeditor/ckeditor.js\"></script>";
  include_once($realPath."admin/".$viewDir."/".$fileName."Edit".$viewFileExt);
} elseif (isset($_GET["mode"]) && $_GET["mode"] === "end") {
  $pageTitle .= "（完了）";
  include_once($realPath."admin/".$viewDir."/".$fileName."End".$viewFileExt);
} elseif (isset($_GET["mode"]) && $_GET["mode"] === "new") {
  //カテゴリー取得
  $categoriesSql = "SELECT * FROM pagesCategories";
  $categoriesResult = $db->getRow($categoriesSql);
  //新規登録
  $errorMessage = array();
  //ページ名が入力されているかチェック
  if (isset($_POST["name"]) && $_POST["name"] == "") {
    $errorMessage = array("name" => "ページ名が入力されていません。");
  }
  //ページ名が登録済みかチェック
  if (isset($_POST["name"]) && $_POST["name"] != "") {
    $sqlCheck = "SELECT COUNT(*) FROM pages WHERE pagesCategoriesID = ? AND name LIKE ?";
    $paramCheck = array($_POST["pagesCategoryID"], htmlspecialchars($_POST["name"]));
    $rowsCheck = $db->getRow($sqlCheck, $paramCheck);
    if ($rowsCheck[0]["COUNT(*)"] > 0) {
      $errorMessage = array("name" => "ページ名「".htmlspecialchars($_POST["name"])."」は登録済みです。");
    }
  }
  //チェックしてエラーが無い場合
  if (isset($_POST["name"]) && count($errorMessage) === 0) {
    if (isset($_POST["phpScript"]) && $_POST["phpScript"][0] == 1) {
      $phpScript = 1;
    } else {
      $phpScript = 0;
    }
    if (isset($_POST["ogpDescription"]) && $_POST["ogpDescription"] != "") {
      $ogpDescription = htmlspecialchars($_POST["ogpDescription"], ENT_QUOTES, 'UTF-8');
    } else {
      $ogpDescription = NULL;
    }
    ini_set("max_execution_time",180);
    $sqlInsert = "INSERT INTO pages(name, title, header, contents, status, created, phpScript, type, pagesCategoriesID, ogpDescription, langID) VALUES(?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?)";
    $paramInsert = array($_POST["name"], $_POST["title"], $_POST["header"], $_POST["formContents"], $_POST["status"], $phpScript, (int)$_POST["pageType"], (int)$_POST["pagesCategoryID"], $ogpDescription, (int)$_POST["langID"]);
    $db->queryOperation($sqlInsert, $paramInsert);
    header("Location: /admin/pages.php?mode=end");
    exit;
  }
  $pageTitle .= "（新規登録）";
  $customHeader = "<script src=\"/js/ckeditor/ckeditor.js\"></script>";
  include_once($realPath."admin/".$viewDir."/".$fileName."New".$viewFileExt);
} else {
  $sql = "SELECT * FROM pages INNER JOIN pagesCategories ON pages.pagesCategoriesID = pagesCategories.pagesCategoriesID";
  $sqlRows = "SELECT COUNT(*) FROM pages";
  $result = $db->getRow($sql);
  $rows = $db->getRow($sqlRows);
  include_once($realPath."admin/".$viewDir."/".$fileName.$viewFileExt);
}
$db->disconnect();