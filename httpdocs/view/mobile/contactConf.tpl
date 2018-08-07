<?php include_once($realPath. "include_file/mobile/header.tpl"); ?>
<div id="contents">
	<h2><?php echo mb_convert_kana($pageTitle, "ka"); ?></h2>
	<form name="mailForm" method="post" action="<?php echo $_SERVER['SCRIPT_NAME']; if (!isset($_COOKIE['useCookie'])) { echo "?".$urlSessionSet; } ?>">
		<?php if ($errorName || $errorEmail || $errorEmailCheck || $errorMessage) { ?>
		<dl>
			<dt>お名前<span style="color: #C00">(必須)</span></dt>
			<dd><?php if ($errorName) { echo "<span style=\"color: #C00;\">".mb_convert_kana($errorNameValue, "ka")."</span><br />例)山田 太郎<br />"; } ?><input type="text" name="name" value="<?php echo htmlspecialchars(mb_convert_encoding($_POST['name'], "UTF-8", "SJIS-win"), ENT_QUOTES); ?>" /></dd>
			<dt>ふりがな<span style="color: #C00;">(必須)</span></dt>
			<dd><?php if ($errorNameFurigana) { echo "<span style=\"color: #C00;\">".mb_convert_kana($errorNameFuriganaValue, "ka")."</span><br />例)やまだ たろう<br />"; } ?><input type="text" name="nameFurigana" value="<?php echo htmlspecialchars(mb_convert_encoding($_POST['nameFurigana'], "UTF-8", "SJIS-win"), ENT_QUOTES); ?>" /></dd>
			<dt>ﾒｰﾙｱﾄﾞﾚｽ<span style="color: #C00;">(必須)</span></dt>
			<dd><?php if ($errorEmail) { echo "<span style=\"color: #C00;\">".mb_convert_kana($errorEmailValue, "ka")."</span><br />例)hoge@moge.com<br />"; } ?><input type="text" name="email" value="<?php echo htmlspecialchars($_POST['email'], ENT_QUOTES); ?>" istyle="3" format="*x" MODE="alphabet" /></dd>
			<dt>ﾒｰﾙｱﾄﾞﾚｽ確認用<span style="color: #C00;">(必須)</span></dt>
			<dd><?php if ($errorEmailCheck) { echo "<span style=\"color: #C00;\">".mb_convert_kana($errorEmailCheckValue, "ka")."</span><br />例)hoge@moge.com<br />"; } ?><input type="text" name="emailCheck" value="<?php echo htmlspecialchars($_POST['emailCheck'], ENT_QUOTES); ?>" istyle="3" format="*x" MODE="alphabet" /></dd>
			<dt>ﾒｯｾｰｼﾞ本文<span style="color: #C00;">(必須)</span></dt>
			<dd><?php if ($errorMessage) { echo "<span style=\"color: #C00;\">".mb_convert_kana($errorMessageValue, "ka")."</span><br />"; } ?><textarea name="message" rows="8"><?php echo htmlspecialchars(mb_convert_encoding($_POST['message'], "UTF-8", "SJIS-win"), ENT_QUOTES); ?></textarea></dd>
		</dl>
		<p><input type="submit" value="確認" /></p>
		<?php } else { ?>
		<dl>
			<dt>お名前<span style="color: #C00;">(必須)</span></dt>
			<dd><input type="hidden" name="name" value="<?php echo htmlspecialchars(mb_convert_encoding($_POST['name'], "UTF-8", "SJIS-win"), ENT_QUOTES); ?>" /><?php echo htmlspecialchars(mb_convert_encoding($_POST['name'], "UTF-8", "SJIS-win"), ENT_QUOTES); ?></dd>
			<dt>ふりがな<span style="color: #C00;">(必須)</span></dt>
			<dd><input type="hidden" name="nameFurigana" value="<?php echo htmlspecialchars(mb_convert_encoding($_POST['nameFurigana'], "UTF-8", "SJIS-win"), ENT_QUOTES); ?>" /><?php echo htmlspecialchars(mb_convert_encoding($_POST['nameFurigana'], "UTF-8", "SJIS-win"), ENT_QUOTES); ?></dd>
			<dt>ﾒｰﾙｱﾄﾞﾚｽ<span style="color: #C00;">(必須)</span></dt>
			<dd><input type="hidden" name="email" value="<?php echo htmlspecialchars($_POST['email'], ENT_QUOTES); ?>" /><?php echo htmlspecialchars($_POST['email'], ENT_QUOTES); ?></dd>
			<dt>ﾒｰﾙｱﾄﾞﾚｽ確認用<span style="color: #C00;">(必須)</span></dt>
			<dd><input type="hidden" name="emailCheck" value="<?php echo htmlspecialchars($_POST['emailCheck'], ENT_QUOTES); ?>" /><?php echo htmlspecialchars($_POST['emailCheck'], ENT_QUOTES); ?></dd>
			<dt>ﾒｯｾｰｼﾞ本文<span style="color: #C00;">(必須)</span></dt>
			<dd><?php echo htmlspecialchars(nl2br(mb_convert_encoding($_POST['message'], "UTF-8", "SJIS-win")), ENT_QUOTES); ?><input type="hidden" name="message" value="<?php echo htmlspecialchars(mb_convert_encoding($_POST['message'], "UTF-8", "SJIS-win"), ENT_QUOTES); ?>" /></dd>
		</dl>
		<input type="hidden" name="ticket" value="<?php echo htmlspecialchars($_SESSION['ticket'], ENT_QUOTES); ?>">
		<input type="hidden" name="check" value="OK" />
		<p><input type="submit" value="この内容で送信" /></p>
		<?php } ?>
	</form>
<!-- /#contents --></div>
<?php include_once($realPath. "include_file/mobile/footer.tpl"); ?>