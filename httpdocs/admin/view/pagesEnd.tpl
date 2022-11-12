<?php include_once($realPath. "include_file/admin/header.tpl");
include_once($realPath . "include_file/admin/side.tpl"); ?>
<div id="pages">
<h2><?php echo $pageTitle; ?></h2>
<p><?php if (isset($_GET["task"]) && $_GET["task"] === "datele") {
	echo "削除";
} elseif (isset($_GET["task"]) && $_GET["task"] === "edit") {
	echo "編集";
} else {
	echo "登録";
} ?>が完了しました。</p>
<p><a href="/admin/pages.php">ページ管理トップへ</a></p>
<!-- /#pages --></div>
<?php include_once($realPath. "include_file/admin/footer.tpl"); ?>