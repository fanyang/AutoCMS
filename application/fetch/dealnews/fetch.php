<?php
include_once (dirname(__FILE__) . '/../get_domain.php');
include_once (dirname(__FILE__) . '/../store_data.php');

$url = "http://dealnews.com/c202/Clothing-Accessories/";
$sourceName = "Dealnews Clothing";
$dealToSave = fetch($url,$sourceName);

if ($dealToSave != false) {
//	saveDeal($dealToSave);
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
	
	$mode = "#<div class=\"body article-medium \">(.*)Report an error#iUs";
	preg_match_all($mode, $contents, $arr);
	$contents = $arr[1];
	
	
	

	$deals = array ();
	foreach ($contents as $content) {
		$mode = "#<h3 class=\"std-headline\">(.*)<a class=\"std-headline\" href=\"(.*)\">(.*)</a></h3>#iUs";
		preg_match_all($mode, $content, $arr);
 		$deal['link'] = $arr[2][0];
 		$deal['title'] = strip_tags($arr[3][0]);
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
		$mode = "#<div class=\"image\"><a target=\"_blank\" href=\"(.*)\"><img src=\"(.*)\" (.*) /></a></div>#iUs";
		preg_match_all($mode, $contents, $piece);
		$deal['link'] = getFinalLink($piece[1][0]);
		if ($deal['link'] == false) {
			continue;
		}
		$deal['pic'] = $piece[2][0];
		$mode = "#<div id=\"\" class=\"artbody\">(.*)</div>#iUs";
		preg_match_all($mode, $contents, $piece);
		$content = $piece[1][0];
		$content = removeHtmlTags($content);
		$content = preg_replace("#dealnews#i", "DealForGirl", $content);
		$deal['body'] = $content;
		$deal['source'] = $sourceName;
		$dealToSave[] = $deal;
	}
	
	return $dealToSave;
}
?>
