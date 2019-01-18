<?php
$url = "http://xxx.xxx.xxx/index20.rdf"; // ブログのRSS URL
$str = file_get_contents( $url );
$simplexml = simplexml_load_string( $str );
//var_dump($simplexml);
$i = count( $simplexml->channel->item ); 
$max = 5; // 件数
$i = 1;
echo "<div id=\"rss\">\n<article>\n";
print "<h2><a href=\"{$simplexml->channel->link}\" target=\"_blank\">{$simplexml->channel->title}</a></h2>\n";
print "<dl>\n";
foreach ($simplexml->channel->item as $data) {
  $date = strtotime(mb_substr($data->pubDate, 5, 20));
  $youbi = array(0 => '(日)', 1 => '(月)', 2 => '(火)', 3 => '(水)', 4 => '(木)', 5 => '(金)', 6 => '(土)');
  $mday = date('w', $date);
  echo "<dt>".date('Y年n月j日', $date)."{$youbi[$mday]}</dt>\n";
  echo "<dd><a href=\"{$data->link}\" target=\"_blank\">{$data->title}</a></dd>\n";
  // ループ処理ごとに$iの値に1を足す
  $i++;
  // $iの値が$maxの値を超えたらループ終了
  if($i > $max){break;}
}
print "</dl>\n";
echo "</article>\n<!-- /rss --></div>\n";