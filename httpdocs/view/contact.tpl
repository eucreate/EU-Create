<?php include_once($realPath. "include_file/header.tpl"); ?>
<div id="mailForm">
  <h2>お問い合わせ</h2>
  <form name="mailForm" method="post" action="<?php echo $_SERVER['SCRIPT_NAME']; if (!isset($_COOKIE['useCookie'])) { echo "?".$urlSessionSet; } ?>">
    <dl>
      <dt>お名前<span class="required">（必須）</span></dt>
      <dd><input type="text" name="name" value="" placeholder="山田　太郎" required></dd>
      <dt>ふりがな<span class="required">（必須）</span></dt>
      <dd><input type="text" name="nameFurigana" value="" placeholder="やまだ　たろう" required></dd>
      <dt>メールアドレス<span class="required">（必須）</span></dt>
      <dd><input type="text" name="email" value="" placeholder="hoge@moge.com" required></dd>
      <dt>メッセージ本文<span class="required">（必須）</span></dt>
      <dd><textarea name="message" rows="8" placeholder="メッセージを入力してください。" required onfocus="foc()">メッセージを入力してください。</textarea></dd>
    </dl>
    <p><input type="submit" value="確認"></p>
  </form>
  <!-- /#mailForm --></div>
<?php include_once($realPath. "include_file/inc_dsp_othersInfo.php");
include_once($realPath. "include_file/footer.tpl"); ?>