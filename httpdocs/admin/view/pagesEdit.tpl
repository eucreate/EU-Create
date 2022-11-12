<?php include_once($realPath. "include_file/admin/header.tpl");
include_once($realPath . "include_file/admin/side.tpl"); ?>
<div id="pages">
<h2><?php echo $pageTitle; ?></h2>
<form method="post" action="<?php echo $_SERVER["SCRIPT_NAME"] . "?mode=edit&amp;id=" . $_GET["id"]; ?>">
  <dl>
    <dt>ID</dt>
    <dd><?php echo "<input type=\"hidden\" name=\"id\" value=\"{$_POST["id"]}\">{$_POST["id"]}"; ?></dd>
  </dl>
  <dl>
    <dt>ページタイプ</dt>
    <dd><input type="hidden" name="pageType" value="<?php echo $data["type"] ?>"><?php echo $pageType[$data["type"]]; ?></dd>
  </dl>
  <dl>
    <dt>カテゴリー名</dt>
    <dd><?php echo $data["categoriesName"]; ?></dd>
  </dl>
  <dl>
    <dt>ページ名（必須）</dt>
    <dd><input type="hidden" name="name" value="<?php echo $_POST["name"]; ?>">
      <?php echo $data["name"]; ?></dd>
  </dl>
  <dl>
    <dt>タイトル</dt>
    <dd><input type="text" name="title" value="<?php echo $_POST["title"]; ?>"></dd>
  </dl>
  <dl>
    <dt>OGP説明</dt>
    <dd><input type="text" name="ogpDescription" value="<?php echo $_POST["ogpDescription"]; ?>"></dd>
  </dl>
  <dl>
    <dt>ヘッダー部</dt>
    <dd><textarea name="header" rows="7"><?php echo $_POST["header"]; ?></textarea></dd>
  </dl>
  <dl>
    <dt>本文</dt>
    <dd><textarea name="formContents" id="formContents" rows="7"><?php echo $_POST["formContents"]; ?></textarea></dd>
  </dl>
  <dl>
    <dt>オプション</dt>
    <dd><input type="checkbox" name="phpScript[]" value="1" id="phpScript" <?php if (isset($_POST["phpScript"]) && $_POST["phpScript"][0] == 1) { echo " checked"; } ?>><label for="phpScript">本文中でPHPスクリプトを有効にする</label></dd>
  </dl>
  <dl>
  	<dt>パンくずリスト</dt>
    <dd><input type="checkbox" name="topicPath[]" value="1" id="topicPath" <?php if (isset($_POST["topicPath"]) && $_POST["topicPath"] === 1) { echo " checked"; } ?>><label for="topicPath">パンくずリストを表示する</label></dd>
  </dl>
  <dl>
    <dt>公開状態</dt>
    <dd><input type="radio" name="status" id="status0" value="0"<?php if (!isset($_POST["status"]) || isset($_POST["status"]) && $_POST["status"] == 0) { echo " checked"; } ?>><label for="status0">非公開</label>
      <input type="radio" name="status" id="status1" value="1"<?php if (isset($_POST["status"]) && $_POST["status"] == 1) { echo " checked"; } ?>><label for="status1">公開</label></dd>
  </dl>
  <p><input type="submit" value="保存"><input type="hidden" name="formStatus" value="check"><input type="hidden" name="nameOld" value="<?php echo $_POST["nameOld"]; ?>"></p>
</form>
<?php if (isset($_GET["editerMode"]) && (int)$_GET["editerMode"] === 0) {
} else { ?>
<script>
  CKEDITOR.replace('formContents', {
	  //
  });
</script>
<?php } ?>
<!-- /#pages --></div>
<?php include_once($realPath. "include_file/admin/footer.tpl"); ?>