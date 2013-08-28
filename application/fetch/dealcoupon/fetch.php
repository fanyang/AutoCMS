<?php
include_once (dirname(__FILE__) . '/../get_domain.php');
include_once (dirname(__FILE__) . '/../store_data.php');

$sourceName = "dealcoupon Clothing";
$url = "http://dealcoupon.com/categories/Clothing-Accessories/202.html";
$dealToSave = fetch($url,$sourceName);
if ($dealToSave != false) {
	saveDeal($dealToSave);
}
$url = "http://dealcoupon.com/categories/Clothing-Accessories/202.html?rec=21";
$dealToSave = fetch($url,$sourceName);
if ($dealToSave != false) {
	saveDeal($dealToSave);
}
$url = "http://dealcoupon.com/categories/Clothing-Accessories/202.html?rec=41";
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

	$mode = "#<div class=\"body coupon\">(.*)</div></td></tr></table></div></div>#iUs";
	preg_match_all($mode, $contents, $arr);
	$deals = $arr[1];
	$dealToSave = array();
	foreach ($deals as $deal) {
		$newDeal = array();
		$mode = "#<img src=\"(.*)\"(.*)>#iUs";
		if(preg_match_all($mode, $deal, $arr)){$newDeal['pic'] = $arr[1][0];}
		else{$newDeal['pic']="";}

		$mode = "#More (.*) coupons#iUs";
		preg_match_all($mode, $deal, $arr);
		$name = $arr[1][0];

		$mode = "#<div class=\"main\">(.*)\$#iUs";
		preg_match_all($mode, $deal, $arr);
		$deal = $arr[1][0];

		$mode = "#href=\"(.*)\"#iUs";
		preg_match_all($mode, $deal, $arr);
		if (!($newDeal['link'] = getFinalLink($arr[1][0]))){continue;}

		$mode = "#</th><td valign=\"top\">(.*)</a></td></tr><tr><th valign=\"top\">#iUs";
		preg_match_all($mode, $deal, $arr);
		$newDeal['title'] = removeHtmlTags($arr[1][0]);
		$newDeal['title'] = $name.": ".$newDeal['title'];

		$mode = "#(What:)|(Link:)|(Click here to use this coupon)#iUs";
		$newDeal['body'] = preg_replace($mode,"",$deal);
		$newDeal['body'] = removeHtmlTags($newDeal['body']);

		$newDeal['source'] = $sourceName;
		$dealToSave[] = $newDeal;
	}
	return $dealToSave;
}
?>
