<?php include_once($realPath. "include_file/header.tpl"); ?>
	<h2><?php echo $pageTitle; ?></h2>
	<p><?php echo $mailStatus[$_SESSION['mailStatus']]; ?></p>
	<p><?php if ($_SESSION['refererUrl'] && $_SESSION['refererUrl'] != "" ) { ?><a href="<?php echo $_SESSION['refererUrl']; ?>">「<?php echo $_SESSION['refererTitle']; ?>」へ戻る</a><?php } else { ?><a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/">「トップページ」へ戻る</a><?php } ?></p>
<?php include_once($realPath. "include_file/inc_dsp_othersInfo.php");
include_once($realPath. "include_file/footer.tpl"); ?>