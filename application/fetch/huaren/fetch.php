<?php
include_once (dirname(__FILE__) . '/../get_domain.php');
include_once (dirname(__FILE__) . '/../store_data.php');

function fetch($url, $sourceName) {
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

	$mode = "#<div class=\"post\" id=\"post-(.*)<div id=\"obsocialbookmark_bar#iUs";
	preg_match_all($mode, $contents, $arr);


	$contents = $arr[0];
	$dealToSave = array ();
	foreach ($contents as $content) {
		$newContent = array ();
		$content = preg_replace("#\s+#is", " ", $content);
		$mode = "#<a class=\"title\" (.*)>(.*)</a>#iUs";
		preg_match_all($mode, $content, $arr);
		$newContent['title'] = $arr[2][0];
		$mode = "#<div class=\"content\">(.*)<div id=\"obsocialbookmark_bar#iUs";
		preg_match_all($mode, $content, $arr);
		$newContent['body'] = $arr[1][0];

		$mode = "#<img (.*)src=\"(.*)\" (.*)>#iUs";
		preg_match_all($mode, $newContent['body'], $arr);
		$newContent['pic'] = $arr[2][0];

		$mode = "#<a (.*)href=\"(.*)\"(.*)>#iUs";
		preg_match_all($mode, $newContent['body'], $arr);
		if (!($newContent['link'] = getFinalLink($arr[2][0]))){continue;}

		$newContent['body'] = removeHtmlTags($newContent['body']);
		$newContent['body'] = preg_replace("#\s+#is", " ", $newContent['body']);
		$newContent['body'] = preg_replace("#huaren#i", "DealForGirl", $newContent['body']);
		$newContent['body'] = trim($newContent['body']);

		$newContent['source'] = $sourceName;
		$dealToSave[] = $newContent;
	}

	return $dealToSave;
}
?>
