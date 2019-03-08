<?php include_once($realPath. "include_file/header.tpl"); ?>
<p class="topicPath"><a href="/"><?php echo $siteName; ?></a> &gt; <?php echo $pageTitle; ?></p>
<h1 class="text-palt"><?php echo $pageTitle; ?></h1>
<?php
if (isset($_POST["words"]) && $_POST["words"] != "") {
  if (count($result) > 0) {
    $resultCount = count($result);
    echo "<p>{$resultCount} results were found.</p>";
    if ((int)$_POST["mode"] === 1){
      foreach ($result as $row) {
        $categoriesName = $row["categoriesName"];
        $categoriesTitle = $row["categoriesTitle"];
        $pagesName = $row["name"];
        $pagesTitle = $row["title"];
        if ($categoriesName != "top") {
          $linkUri = "/" . $categoriesName . "/" . $pagesName . ".html";
          $linkCategoriesName = "（" . $categoriesTitle . "）";
        } elseif ($categoriesName === "top" && $pagesName === "index") {
          $linkUri = "/";
          $linkCategoriesName = "";
        } else {
          $linkUri = "/" . $pagesName . ".html";
          $linkCategoriesName = "";
        }
        echo "<p><a href=\"{$linkUri}\">{$pagesTitle}{$linkCategoriesName}</a></p>\n";
      }
    } else {
      foreach ($result as $row) {
        echo "<p><a href=\"/news.php?id=" . (int)$row["newsId"] . "\">" . $row["newsTitle"] . "</p>\n";
      }
    }
  } else {
    echo "<p>Not Found<br>The page could not be found.</p>
    <p>*&quot;&#39;(single quotation)&quot; and the like, a string that could affect the system can not search.</p>
    <p><a href=\"/\">" . $siteName . " Front Page</a></p>\n";
  }
} else {
  echo "<p>The search character is not entered.</p>
  <p>*&quot;&#39;(single quotation)&quot; and the like, a string that could affect the system can not search.</p>
  <p><a href=\"/\">" . $siteName . " Front Page</a></p>\n";
}
?>
<?php include_once($realPath. "include_file/footer.tpl"); ?>