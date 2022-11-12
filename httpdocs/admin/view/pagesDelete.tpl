<?php include_once($realPath. "include_file/admin/header.tpl");
include_once($realPath . "include_file/admin/side.tpl"); ?>
<div id="pages">
<h2><?php echo $pageTitle; ?></h2>
<form method="post" action="<?php echo $_SERVER["SCRIPT_NAME"] . "?mode=delete&amp;id=" . $_GET["id"]; ?>">
<?php foreach ($result as $row) { ?>
<dl>
	<dt>ID</dt>
	<dd><?php echo $row["id"]; ?><input type="hidden" name="id" value="<?php echo $row["id"]; ?>"></dd>
</dl>
<dl>
	<dt>ページ名</dt>
	<dd><?php echo $row["name"]; ?></dd>
</dl>
<dl>
	<dt>タイトル</dt>
	<dd><?php if ($row["title"] == "") { echo "&nbdp;"; } else { echo $row["title"]; } ?></dd>
</dl>
<dl>
	<dt>ヘッダー部</dt>
	<dd><?php if ($row["header"] == "") { echo "&nbsp;"; } else { echo $row["header"]; } ?></dd>
</dl>
<dl>
	<dt>本文</dt>
	<dd><?php if ($row["contents"] == "") { echo "&nbsp;"; } else { echo $row["contents"]; } ?></dd>
</dl>
<dl>
	<dt>オプション</dt>
	<dd>本文中でPHPスクリプトを<?php if ($row["phpScript"] == 1) { echo "有効"; } else { echo "無効"; } ?>にする</dd>
</dl>
<dl>
	<dt>公開状態</dt>
	<dd><?php if ($row["status"] == 0) { echo "非公開"; } else { echo "公開"; } ?></dd>
</dl>
<p>削除する場合は「削除する」ボタンをクリックしてください。<br>
※削除したデータは元には戻せません。</p>
<p><input type="submit" value="削除する"><input type="hidden" name="deleteFlag" value="ture"></p>
</form>
<!-- /#pages --></div>
<?php }
include_once($realPath. "include_file/admin/footer.tpl"); ?>