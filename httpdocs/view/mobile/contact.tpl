<?php include_once($realPath. "include_file/mobile/header.tpl"); ?>
<div id="contents">
	<h2><?php echo mb_convert_kana($pageTitle, "ka"); ?></h2>
	<form name="mailForm" method="post" action="<?php echo $_SERVER['SCRIPT_NAME']; if (!isset($_COOKIE['useCookie'])) { echo "?".$urlSessionSet; } ?>">
		<dl>
			<dt>お名前<span style="color: #C00;">(必須)</span></dt>
			<dd>例)山田 太郎<br /><input type="text" name="name" value="" /></dd>
			<dt>ふりがな<span style="color: #C00;">(必須)</span></dt>
			<dd>例)やまだ たろう<br /><input type="text" name="nameFurigana" value="" /></dd>
			<dt>ﾒｰﾙｱﾄﾞﾚｽ<span style="color: #C00;">(必須)</span></dt>
			<dd>例)hoge@moge.com<br /><input type="text" name="email" value="" istyle="3" format="*x" MODE="alphabet" /></dd>
			<dt>ﾒｰﾙｱﾄﾞﾚｽ確認用<span style="color: #C00;">(必須)</span></dt>
			<dd>例)hoge@moge.com<br /><input type="text" name="emailCheck" value="" istyle="3" format="*x" MODE="alphabet" /></dd>
			<dt>ﾒｯｾｰｼﾞ本文<span style="color: #C00;">(必須)</span></dt>
			<dd><textarea name="message" rows="6"></textarea></dd>
		</dl>
		<p><input type="submit" value="確認" /></p>
	</form>
<!-- /#contents --></div>
<?php include_once($realPath. "include_file/mobile/footer.tpl"); ?>