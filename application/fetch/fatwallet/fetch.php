<?php
include_once (dirname(__FILE__) . '/../get_domain.php');
include_once (dirname(__FILE__) . '/../store_data.php');

$url = "http://www.fatwallet.com/clothing-deals/";
$sourceName = "Fatwallet Clothing";
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

	$mode = "#<div class=\"standardPageSection\">(.*)<tr id=\"moreBestDealsRow1\">#iUs";
	preg_match_all($mode, $contents, $arr);
	$body = $arr[1][0];
	$mode = "#<div class=\"bestDealsListCell\">(.*)<div class=\"bestDealsListMerchant\">(.*)</div>#iUs";
	preg_match_all($mode, $body, $arr);
	$deals = $arr[0];
	$dealToSave = array();
	foreach ($deals as $deal) {
		$newDeal = array();
		$mode = "#<div class=\"bestDealsListTitle\"(.*)><a (.*)>(.*)</a></div>#iUs";
		preg_match_all($mode, $deal, $arr);
		$newDeal['title'] = $arr[3][0];
		$mode = "#<div class=\"bestDealsListMerchant\">(.*)</div>#iUs";
		preg_match_all($mode, $deal, $arr);
		$newDeal['title'] = $arr[1][0].": ".$newDeal['title'];
		$newDeal['title'] = preg_replace("#FatWallet#i", "DealForGirl", $newDeal['title']);

		$mode = "#<img (.*)data-href=\"(.*)\"(.*)/>#iUs";
		preg_match_all($mode, $deal, $arr);
		$newDeal['pic'] = $arr[2][0];

		$mode = "#(dealid=\d+)#is";
		preg_match_all($mode, $deal, $arr);
		$newDeal['link'] = "http://www.fatwallet.com/redirect/bounce.php?afsrc=1&".$arr[0][0]."&bypCb=1";
		$newDeal['link'] = getFinalLink($newDeal['link']);

		$mode = "#<div class=\"bestDealsListPrice\"(.*)<div class=\"bestDealsListMerchant\">#iUs";
		preg_match_all($mode, $deal, $arr);
		$newDeal['body'] = $arr[0][0];
		$newDeal['body'] = removeHtmlTags($newDeal['body']);
		$newDeal['body'] = preg_replace("#(<abbr(.*)>)|(</abbr>)#iUs","",$newDeal['body']);

		$newDeal['source'] = $sourceName;
		$dealToSave[] = $newDeal;
	}
	return $dealToSave;
}
?>
