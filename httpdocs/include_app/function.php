<?php
/**
 * ページタイトルを取得する関数
 * SpecialThanks http://creazy.net/2008/05/php_get_page_title_sample.html
 */
function getPageTitle( $url ) {
    $html = file_get_contents($url); //(1)file_get_contents関数で指定されたURLからHTML文字列を取得
    $html = mb_convert_encoding($html, mb_internal_encoding(), "auto" ); //(2)mb_convert_encoding関数で内部エンコーディングに指定している文字コードに変換
    if ( preg_match( "/<title>(.*?)<\/title>/i", $html, $matches) ) { //(3)preg_match関数で正規表現を使ってtitleタグを抜き出す
        return $matches[1];
    } else {
        return false;
    }
}

/**
 * ブラウザ情報を取得する関数
 */
function getBrowserInfo($viewDir) {
	// User Agent
	$ua = $_SERVER["HTTP_USER_AGENT"];
	$uaBrowserInfo["type"] = "";
	$uaBrowserInfo["carrier"] ="";
	$uaBrowserInfo["browser"] = "";
	$uaBrowserInfo["version"] = "";
	if (preg_match("/^DoCoMo/", $ua)){
		$uaBrowserInfo["type"] = "mobile";
		$uaBrowserInfo["carrier"] = "docomo";
		$viewDir .= "/mobile";
	} elseif(preg_match("/^J-PHONE|^Vodafone|^SoftBank/", $ua)){
		$uaBrowserInfo["type"] = "mobile";
		$uaBrowserInfo["carrier"] = "softbank";
		$viewDir .= "/mobile";
	} elseif(preg_match("/^UP\.Browser|^KDDI/", $ua)){
		$uaBrowserInfo["type"] = "mobile";
		$uaBrowserInfo["carrier"] = "au";
		$viewDir .= "/mobile";
	} else {
		$uaBrowserInfo["type"] = "pc";
		if (preg_match("/Trident\/(\d{1,}\.(\d{1,})).*rv:(\d{1,}\.(\d{1,}))/", $ua, $regExpResults)) {
			$uaBrowserInfo['browser'] = "IE";
			$uaBrowserInfo['version'] = (float)$regExpResults[3];
		} elseif (preg_match("/MSIE\s(\d{1,}\.\d{1,})/i", $ua, $regExpResults)) {
			$uaBrowserInfo['browser'] = substr($regExpResults[0], 2, 2);
			$uaBrowserInfo['version'] = (float)$regExpResults[1];
		}
	}
	return array($uaBrowserInfo, $viewDir);
}

/**
 * コンテンツ表示
 * @param unknown $contents
 * @param unknown $phpScript
 * @param unknown $realPath
 */
function readContents($contents, $phpScript, $realPath, $viewPath) {
	if ($phpScript == 1) {
		$tempFile = tmpfile();
		fwrite($tempFile, htmlspecialchars_decode($contents));
		$tempFileName = stream_get_meta_data($tempFile);
		include_once($tempFileName["uri"]);
		fclose($tempFile);
	} else {
//		$returnContents = htmlspecialchars_decode($contents);
//		return print $returnContents;
		print $contents;
	}
}

function newsIndex($recordLimit = 5) {
	$db = new dbc();
	if (isset($_GET["preview"]) && (int)$_GET["preview"] === 1) {
		$flag = "";
	} else {
		$flag = "WHERE newsPublicFlag = 1 ";
	}
	$getNewsSql = "SELECT * FROM news {$flag}ORDER BY newsModifiedDate LIMIT {$recordLimit}";
	//var_dump($getNewsSql);
	$resultNewsSql = $db->getRowOnce($getNewsSql);
	//var_dump($resultNewsSql);
	if (count($resultNewsSql) > 0) {
		foreach ($resultNewsSql as $row) {
			echo "\t\t\t<dl>
			<dt>{$row["newsDspDate"]}</dt>
			<dd><a href=\"news.php?id=" . (int)$row["newsId"] ."\">" . $row["newsTitle"] . "</a></dd>
			</dl>\n";
		}
	} else {
		echo "<p>ニュースはありませんでした。</p>\n";
	}
	$db->Disconnect();
}
