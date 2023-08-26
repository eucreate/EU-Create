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
	$uaBrowserInfo = [
		"type" => "pc",
		"carrier" => "",
		"browser" => "",
		"version" => ""
	];
	if (preg_match("/^(DoCoMo|J-PHONE|Vodafone|SoftBank)/", $ua, $matches)) {
		$uaBrowserInfo["type"] = "mobile";
		$uaBrowserInfo["carrier"] = strtolower($matches[1]);
		$viewDir .= "/mobile";
	} elseif (preg_match("/^(UP\.Browser|KDDI)/", $ua, $matches)) {
		$uaBrowserInfo["type"] = "mobile";
		$uaBrowserInfo["carrier"] = strtolower($matches[1]);
		$viewDir .= "/mobile";
	} elseif (preg_match("/Trident\/(\d+\.\d+).*rv:(\d+\.\d+)/", $ua, $regExpResults)
		|| preg_match("/MSIE\s(\d+\.\d+)/i", $ua, $regExpResults)) {
		$uaBrowserInfo['browser'] = "IE";
		$uaBrowserInfo['version'] = (float)$regExpResults[1];
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
		print $contents;
	}
}

function newsIndex($recordLimit = 5) {
	$db = new dbc();
	$flag = (isset($_GET["preview"]) && (int)$_GET["preview"] === 1) ? "" : "WHERE newsPublicFlag = 1 ";
	$getNewsSql = "SELECT * FROM news {$flag}ORDER BY newsModifiedDate DESC LIMIT {$recordLimit}";
	$resultNewsSql = $db->getRow($getNewsSql);
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
	$db->disconnect();
}

function wpBlogIndex($recordLimit = 5, $blogTable = "wp_") {
	try {
		$db = new dbc("", "MySQL", "utf8mb4");
		// ブログ情報を取得
		$blogInfoSql = "SELECT option_value FROM {$blogTable}options WHERE option_name = 'siteurl' OR option_name = 'blogname' LIMIT 2";
		$resultBlogInfo = $db->getRow($blogInfoSql);
		$blogDB = array_column($resultBlogInfo, 'option_value');
		$siteurl = $blogDB[1];
		$blogname = $blogDB[0];
		// ブログ記事を取得
		$blogSql = "SELECT post_date, guid, post_title FROM {$blogTable}posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_date DESC LIMIT {$recordLimit}";
		$resultBlog = $db->getRow($blogSql);
		// HTML出力
		echo "<h3><a href=\"" . htmlspecialchars($siteurl, ENT_QUOTES, 'UTF-8') . "\">" . htmlspecialchars($blogname, ENT_QUOTES, 'UTF-8') . "</a></h3>\n";
		if (count($resultBlog) > 0) {
			echo "<dl>\n";
			foreach ($resultBlog as $row) {
				echo "<dt>" . date("Y年m月d日 H:i", strtotime($row["post_date"])) . "</dt>\n";
				echo "<dd><a href=\"" . htmlspecialchars($row["guid"], ENT_QUOTES, 'UTF-8') . "\">" . htmlspecialchars($row["post_title"], ENT_QUOTES, 'UTF-8') . "</a></dd>\n";
			}
			echo "</dl>\n";
		} else {
			echo "<p>ブログはありませんでした。</p>\n";
		}
	} catch (PDOException $e) {
        die("データベース接続エラー: " . $e->getMessage());
    } finally {
		$db->disconnect();
	}
}
