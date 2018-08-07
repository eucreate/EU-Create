<?php include_once($realPath. "include_file/mobile/header.tpl"); ?>
<div id="contents">
	<h2><?php echo mb_convert_kana($pageTitle, "ka"); ?></h2>
	<p><?php echo mb_convert_kana($mailStatus[$_SESSION['mailStatus']], "ka"); ?></p>
	<p><?php if ($_SESSION['refererUrl'] && $_SESSION['refererUrl'] != "" ) { ?>
	<a href="<?php echo $_SESSION['refererUrl']; ?>">｢<?php echo mb_convert_kana($_SESSION['refererTitle'], "ka"); ?>｣へ戻る</a>
	<?php } else { ?>
	<a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/"><?php echo mb_convert_kana("トップページ", "ka"); ?>へ戻る</a><?php } ?>
	</p>
<!-- /#contents --></div>
<?php include_once($realPath. "include_file/mobile/footer.tpl"); ?>