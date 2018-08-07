<?php include_once($realPath. "include_file/header.tpl"); ?>
	<div id="mailForm">
	<h2><?php echo $pageTitle; ?></h2>
	<form name="mailForm" method="post" action="<?php echo $_SERVER['SCRIPT_NAME']; if (!isset($_COOKIE['useCookie'])) { echo "?".$urlSessionSet; } ?>">
		<?php if ($errorName || $errorEmail || $errorEmailCheck || $errorMessage) { ?>
		<dl>
			<dt>お名前<span class="required">（必須）</span></dt>
			<dd><?php if ($errorName) { echo "<span class=\"errorText\">{$errorNameValue}</span><br>"; } ?><input type="text" name="name" value="<?php echo htmlspecialchars($_POST['name'], ENT_QUOTES); ?>" placeholder="山田　太郎" required></dd>
			<dt>ふりがな<span class="required">（必須）</span></dt>
			<dd><?php if ($errorNameFurigana) { echo "<span class=\"errorText\">{$errorNameFuriganaValue}</span><br>"; } ?><input type="text" name="nameFurigana" value="<?php echo htmlspecialchars($_POST['nameFurigana'], ENT_QUOTES); ?>" placeholder="やまだ　たろう" required></dd>
			<dt>メールアドレス<span class="required">（必須）</span></dt>
			<dd><?php if ($errorEmail) { echo "<span class=\"errorText\">{$errorEmailValue}</span><br>"; } ?><input type="text" name="email" value="<?php echo htmlspecialchars($_POST['email'], ENT_QUOTES); ?>" placeholder="hoge@moge.com" required></dd>
			<dt>メールアドレス確認用<span class="required">（必須）</span></dt>
			<dd><?php if ($errorEmailCheck) { echo "<span class=\"errorText\">{$errorEmailCheckValue}</span><br>"; } ?><input type="text" name="emailCheck" value="<?php echo htmlspecialchars($_POST['emailCheck'], ENT_QUOTES); ?>" placeholder="hoge@moge.com" required></dd>
			<dt>メッセージ本文<span class="required">（必須）</span></dt>
			<dd><?php if ($errorMessage) { echo "<span class=\"errorText\">{$errorMessageValue}</span><br>"; } ?><textarea name="message" rows="8" placeholder="メッセージを入力してください。" onfocus="foc()" required><?php echo htmlspecialchars($_POST['message'], ENT_QUOTES); ?></textarea></dd>
		</dl>
		<p><input type="submit" value="確認"></p>
		<?php } else { ?>
		<dl>
			<dt>お名前<span class="required">（必須）</span></dt>
			<dd><input type="hidden" name="name" value="<?php echo htmlspecialchars($_POST['name'], ENT_QUOTES); ?>"><?php echo htmlspecialchars($_POST['name'], ENT_QUOTES); ?></dd>
			<dt>ふりがな<span class="required">（必須）</span></dt>
			<dd><input type="hidden" name="nameFurigana" value="<?php echo htmlspecialchars($_POST['nameFurigana'], ENT_QUOTES); ?>"><?php echo htmlspecialchars($_POST['nameFurigana'], ENT_QUOTES); ?></dd>
			<dt>メールアドレス<span class="required">（必須）</span></dt>
			<dd><input type="hidden" name="email" value="<?php echo htmlspecialchars($_POST['email'], ENT_QUOTES); ?>"><?php echo htmlspecialchars($_POST['email'], ENT_QUOTES); ?></dd>
			<dt>メールアドレス確認用<span class="required">（必須）</span></dt>
			<dd><input type="hidden" name="emailCheck" value="<?php echo htmlspecialchars($_POST['emailCheck'], ENT_QUOTES); ?>"><?php echo htmlspecialchars($_POST['emailCheck'], ENT_QUOTES); ?></dd>
			<dt>メッセージ本文<span class="required">（必須）</span></dt>
			<dd><?php echo nl2br(htmlspecialchars($_POST['message'], ENT_QUOTES)); ?><input type="hidden" name="message" value="<?php echo htmlspecialchars($_POST['message'], ENT_QUOTES); ?>"></dd>
		</dl>
		<input type="hidden" name="check" value="OK">
		<input type="hidden" name="ticket" value="<?php echo htmlspecialchars($_SESSION['ticket'], ENT_QUOTES); ?>">
		<p><input type="submit" value="この内容で送信"></p>
		<?php } ?>
	</form>
	<!-- /#mailForm --></div>
<?php include_once($realPath. "include_file/inc_dsp_othersInfo.php");
include_once($realPath. "include_file/footer.tpl"); ?>