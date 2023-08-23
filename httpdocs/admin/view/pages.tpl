<?php include_once($realPath. "include_file/admin/header.tpl");
include_once($realPath . "include_file/admin/side.tpl"); ?>
<div id="pages">
<h2>ページ管理</h2>
<?php if ($rows > 0) { ?>
	<p>登録されたページは<?php echo $rows[0]["COUNT(*)"]; ?>件ありました。</p>
	<p><a href="<?php echo $_SERVER["SCRIPT_NAME"]; ?>?mode=new">新規登録</a></p>
	<table>
	  <thead>
	    <tr>
	      <th class="columnAction">&nbsp;</th>
	      <th class="columnId">ID</th>
	      <th>ページ名<br>
	      タイトル</th>
	      <th class="columnType">ページタイプ</th>
		  <th class="columnLang">言語</th>
	      <th class="columnStatus">公開状態</th>
	      <th class="columnDate">登録日<br>
	      更新日</th>
	    </tr>
	  </thead>
	  <tbody>
<?php foreach($result as $row) {
	if ($row["status"] == 1) { $pageStatus = "公開"; } else { $pageStatus = "非公開"; }
	if ($row["langID"] == 0) {
		$pageLangID = "日本語";
	} elseif ($row["langID"] == 1) {
		$pageLangID = "英語 (米国)";
	} elseif ($row["langID"] == 2) {
		$pageLangID = "中国語（簡体）";
	}
	echo "\t\t<tr>
      <td><a href=\"{$_SERVER["SCRIPT_NAME"]}?mode=edit&amp;id={$row["id"]}\">編集</a><br>
      <a href=\"{$_SERVER["SCRIPT_NAME"]}?mode=edit&amp;id={$row["id"]}&amp;editerMode=0\">ソース編集</a>
		  <a href=\"{$_SERVER["SCRIPT_NAME"]}?mode=delete&amp;id={$row["id"]}\">削除</a></td>
		  <td class=\"columnId\">{$row["id"]}</td>
		  <td>{$row["name"]}<br>
		  {$row["title"]}</td>
		  <td class=\"columnType\">{$pageType[$row["type"]]}</td>
		  <td class=\"columnLang\">{$pageLangID}</td>
		  <td class=\"columnStatus\">{$pageStatus}</td>
		  <td class=\"columnDate\">{$row["created"]}<br>
		  {$row["modified"]}</td>
		</tr>\n";
} ?>
	  </tbody>
	</table>
	<p><a href="<?php echo $_SERVER["SCRIPT_NAME"]; ?>?mode=new">新規登録</a></p>
<?php } else {
	echo "<p>登録されたページはありませんでした。</p>
		<p><a href=\"" . $_SERVER["SCRIPT_NAME"] . "?mode=new\">新規登録</a></p>\n";
}
echo "<!-- /#pages --></div>\n";
include_once($realPath. "include_file/admin/footer.tpl"); ?>