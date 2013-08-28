<?php
include_once (dirname(__FILE__) . '/../get_domain.php');
include_once (dirname(__FILE__) . '/../store_data.php');


function fetch($http, $sourceName) {
	$contents = false;
	$fetchTime = 0;
	do {
		$contents = getOnePage($http);
		sleep(1);
		$fetchTime++;
	} while ($contents == false && $fetchTime < 3);
	if ($contents == false) {
		return false;
	}

	$mode = "#<li id=\"li\d+\">(.*)<div class=\"ri_textdown\">#iUs";
	preg_match_all($mode, $contents, $arr);
	$contents = $arr[0];
	$dealToSave = array ();
	foreach ($contents as $content) {
		$newContent = array ();
		$mode = "#<div class=\"left_img\">(.*)<img src=\"(.*)\"(.*)<div class=\"right_text\">#iUs";
		preg_match_all($mode, $content, $arr);
		$newContent['pic'] = $arr[2][0];
		if (preg_match_all("#^/#", $newContent['pic'], $arr)) {
			$newContent['pic'] = "http://www.dealmoon.com" . $newContent['pic'];
		}
		if(getDomainByUrl($newContent['pic'] )=='www.dealmoon.com'){
			$newContent['proxy'] = $http['proxy'];
		}

		$mode = "#<h2>(.*)<a(.*)href=\"(.*)\">(.*)</a>(.*)</h2>#iUs";
		preg_match_all($mode, $content, $arr);
		$newContent['link'] = $arr[3][0];
		$newContent['title'] = $arr[4][0];

		$mode = "#^/(.*)/(\d+)\.html\$#iUs";
		preg_match_all($mode, $newContent['link'], $arr);
		$http['url'] = 'http://www.dealmoon.com/exec/j/?d='.$arr[2][0];
		
		$contents = false;
		$fetchTime = 0;
		do {
			$contents = getOnePage($http);
			sleep(1);
			$fetchTime++;
		} while ($contents == false && $fetchTime < 3);
		if ($contents == false) {
			continue;
		}
		$mode = "#<meta http\-equiv=\"refresh\" content=\"0;url=(.*)\">#iUs";
		preg_match_all($mode, $contents, $matchArray);
		$newContent['link'] = $matchArray[1][0];
		if (getDomainByUrl($newContent['link']) == 'www.dealmoon.com'){
			continue;
		}
		
		$newContent['link'] = getFinalLink($newContent['link']);
		if ($newContent['link'] == false) {
			continue;
		}

		$newContent['title'] = trim(strip_tags($newContent['title']));
		$newContent['title'] = preg_replace("#\s{2,}#", " ", $newContent['title']);
		$newContent['title'] = preg_replace("#dealmoon#i", "DealForGirl", $newContent['title']);

		$mode = "#<td>(.*)</td>#iUs";
		preg_match_all($mode, $content, $arr);
		$newContent['body'] = $arr[1][0];
		$newContent['body'] = removeHtmlTags($newContent['body']);
		$newContent['body'] = preg_replace("#\s+#is", " ", $newContent['body']);
		$newContent['body'] = preg_replace("#dealmoon#i", "DealForGirl", $newContent['body']);

		$newContent['source'] = $sourceName;

		$dealToSave[] = $newContent;
	}
	return $dealToSave;
}
?>
