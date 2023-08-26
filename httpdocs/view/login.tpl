<?php include_once($realPath. "include_file/header.tpl"); ?>
	<h2><?php echo $pageTitle; ?></h2>
	<form method="post" action="<?php echo $_SERVER["SCRIPT_NAME"]; ?>">
	<dl>
	  <dt>ID</dt>
	  <dd><input type="text" name="id" pattern="^[0-9a-zA-Z\-\_]+$" placeholder="半角英数とハイフン、アンダースコアのみ入力できます" required class="form-control"></dd>
	  <dt>Password</dt>
	  <dd><input type="password" name="pass" class="form-control" required></dd>
	  <dd><input type="submit" value="send" class="btn btn-primary"></dd>
	</dl>
	<p>※COOKIEを有効にしてください。</p>
	<p><a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/">&rarr;Front Pageへ</a></p>
	<?php
	if (isset($status) && strlen($status) > 0) {
		echo "<p id=\"notice\">{$status}</p>\n";
	}
	?>
	</form>
<?php include_once($realPath. "include_file/inc_dsp_othersInfo.php");
include_once($realPath. "include_file/footer.tpl"); ?>