<?php include_once($realPath. "include_file/admin/header.tpl");
include_once($realPath . "include_file/admin/side.tpl"); ?>
<div id="pages">
<h2><?php echo $pageTitle; ?></h2>
<form method="post" action="<?php echo $_SERVER["SCRIPT_NAME"] . "?mode=new"; ?>">
<dl>
	<dt>ページタイプ</dt>
	<dd><select name="pageType">
	<?php foreach($pageType as $key => $value) { echo "\t<option value=\"{$key}\""; echo ">{$value}</option>\n"; } ?>
	</select></dd>
</dl>
<dl>
	<dt>言語</dt>
	<dd>
	<select name="langID">
		<option value="0"<?php if (isset($_POST["langID"]) && $_POST["langID"] == 0) { echo " selected"; } ?>>日本語</option>
		<option value="1"<?php if (isset($_POST["langID"]) && $_POST["langID"] == 1) { echo " selected"; } ?>>英語 (米国)</option>
		<option value="2"<?php if (isset($_POST["langID"]) && $_POST["langID"] == 2) { echo " selected"; } ?>>中国語（簡体）</option>
	</select>
	</dd>
</dl>
<dl>
	<dt>カテゴリー名</dt>
	<dd><select name="pagesCategoryID">
	<?php foreach($categoriesResult as $row) {
	echo "\t\t<option value=\"{$row["pagesCategoriesID"]}\">{$row["categoriesName"]}</option>";
	} ?></select></dd>
</dl>
<dl>
	<dt>ページ名（必須）</dt>
	<dd><input type="text" name="name"<?php if (isset($_POST["name"])) { echo " value=\"{$_POST["name"]}\""; } ?> pattern="^[0-9a-zA-Z\-\_]+$" placeholder="半角英数とハイフン、アンダースコアのみ入力できます" required></dd>
	<?php if (isset($errorMessage["name"]) && $errorMessage["name"] != "") { echo "<dd>{$errorMessage["name"]}</dd>"; } ?>
</dl>
<dl>
	<dt>タイトル</dt>
	<dd><input type="text" name="title"<?php if (isset($_POST["title"])) { echo " value=\"{$_POST["title"]}\""; } ?>></dd>
</dl>
<dl>
	<dt>ヘッダー部</dt>
	<dd><textarea name="header" rows="7"><?php if (isset($_POST["header"])) { echo $_POST["header"]; } ?></textarea></dd>
</dl>
<dl>
	<dt>本文</dt>
	<dd><textarea name="formContents" id="formContents" rows="7"><?php if (isset($_POST["formContents"])) { echo $_POST["formContents"]; } ?></textarea></dd>
</dl>
<dl>
	<dt>オプション</dt>
	<dd><input type="checkbox" name="phpScript[]" value="1" id="phpScript"<?php if (isset($_POST["phpScript"]) && $_POST["phpScript"][0] == 1) { echo " checked"; } ?>><label for="phpScript">本文中でPHPスクリプトを有効にする</label></dd>
</dl>
<dl>
	<dt>公開状態</dt>
	<dd><input type="radio" name="status" id="status0" value="0"<?php if (!isset($_POST["status"]) || isset($_POST["status"]) && $_POST["status"] == 0) { echo " checked"; } ?>><label for="status0">非公開</label>
	<input type="radio" name="status" id="status1" value="1"<?php if (isset($_POST["status"]) && $_POST["status"] == 1) { echo " checked"; } ?>><label for="status1">公開</label></dd>
</dl>
<input type="hidden" name="pagesCategoriesID" value="1">
<p><input type="submit" value="保存"></p>
</form>
<script>
CKEDITOR.replace('formContents');
</script>
<!-- /#pages --></div>
<?php include_once($realPath. "include_file/admin/footer.tpl"); ?>