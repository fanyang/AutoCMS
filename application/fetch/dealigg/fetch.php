<?php
include_once (dirname(__FILE__) . '/../get_domain.php');
include_once (dirname(__FILE__) . '/../store_data.php');

$url = "http://www.dealigg.com/cat-best-price-ApparelShoes";
$sourceName = "Dealigg ApparelShoes";
$dealToSave = fetch($url,$sourceName);
if ($dealToSave != false) {
	saveDeal($dealToSave);
}

function fetch($url,$sourceName) {
	$contents = false;
	$fetchTime = 0;
	do {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		$contents = curl_exec($ch);
		curl_close($ch);
		$fetchTime++;
	} while ($contents == false && $fetchTime < 3);
	if ($contents == false) {
		return false;
	}

	$mode = "#<div class=\"desctitle\">(.*)</div>#iUs";
	preg_match_all($mode, $contents, $arr);
	$deals = array ();
	foreach($arr[1] as $content){
		$mode = "#<a href=\"(.*)\"(.*)>(.*)</a>#iUs";
		preg_match_all($mode, $content, $piece);
		$deal['link'] = "http://www.dealigg.com".$piece[1][0];
		$deal['title'] = strip_tags(trim($piece[3][0]));
		$deals[] = $deal;
	}

	$dealToSave = array ();
	foreach ($deals as $deal) {
		$link = $deal['link'];
		$contents = false;
		$fetchTime = 0;
		do {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $link);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 60);
			$contents = curl_exec($ch);
			curl_close($ch);
			$fetchTime++;
		} while ($contents == false && $fetchTime < 3);
		if ($contents == false) {
			continue;
		}

		$mode = "#<h1><a href=\"(.*)\"(.*)</h1>#iUs";
		preg_match_all($mode, $contents, $piece);
		$deal['link'] = getFinalLink("http://www.dealigg.com".$piece[1][0]);
		if ($deal['link'] == false) {
			continue;
		}
		$mode = "#=(\d+)\$#";
		preg_match_all($mode, $piece[1][0], $arr);
		$deal['pic'] = "http://s1.dealigg.net/thumb_img/thumb_".$arr[1][0].".jpg";

		$contents = preg_replace("#[\\r\\n]#is", "", $contents);
		$content = preg_replace("#\s+#is", " ", $content);
		$mode = "#<td valign=\"top\"  class=\"descdetails\">(.*)<br>(.*)<td colspan=\"2\"  align=\"right\">#iUs";
		preg_match_all($mode, $contents, $piece);
		$content = $piece[2][0];
		$content = preg_replace("#<table (.*)</table>#iUs", "", $content);
		$content = preg_replace("#<div  style=\"float: left;(.*)</div>#iUs", "", $content);
		$content = removeHtmlTags($content);
		$content = preg_replace("#\s+#is", " ", $content);
		$content = preg_replace("#<br />\s*<br />\s*<br />(.*)\$#is", "", $content);
		$content = preg_replace("#<br />\s*<br />(.*)#iUs", "<br />", $content);
		$content = preg_replace("#dealigg#i", "DealForGirl", $content);
		$content = mb_convert_encoding($content,'utf8','iso-8859-1');
		$content = trim($content);
		$deal['body'] = $content;
		$deal['source'] = $sourceName;
		$dealToSave[] = $deal;

	}
	return $dealToSave;
}
?>