<?php
include_once (dirname(__FILE__) . '/../get_domain.php');
include_once (dirname(__FILE__) . '/../store_data.php');
include_once (dirname(__FILE__) . '/../get_one_page.php');


$sourceName = "dealsea";
$http['url'] = "http://dealsea.com/latest";
$http['proxy'] = isset($proxy['dealsea'])?$proxy['dealsea']:'';
$dealToSave = fetch($http,$sourceName);
if ($dealToSave != false) {
	saveDeal($dealToSave,$http['proxy']);
}


function fetch($http,$sourceName) {

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
	
	$mode = "#<table cellpadding=\"0\" cellspacing=\"20\">(.*)More\.\.\.#iUs";
	preg_match_all($mode, $contents, $matchArray);
	$contents = $matchArray[1][0];
	$mode = "#<tr>(.*)</tr>#iUs";
	preg_match_all($mode, $contents, $matchArray);
	$deals = $matchArray[1];
	
	$dealToSave = array();
	foreach ($deals as $deal) {
		$newDeal = array();
		$mode = "#<a href=\"(/view\-deal/\d+)\">#iUs";
		preg_match_all($mode, $deal, $matchArray);
		$http['url'] = 'http://dealsea.com'.$matchArray[1][0];
		
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
		
		$mode = "#<div class=\"dealTitle\"><h1><span>(.*)</span></h1>#iUs";
		preg_match_all($mode, $contents, $matchArray);
		$newDeal['title'] = $matchArray[1][0];
		
		$mode = "#<div style=\"margin:20px 0px 10px 0px;display:block\">(.*)</div>#iUs";
		preg_match_all($mode, $contents, $matchArray);
		$newDeal['body'] = $matchArray[1][0];
		$newDeal['body'] = removeHtmlTags($newDeal['body']);
		$newDeal['body'] = preg_replace("#dealsea#i", "DealForGirl", $newDeal['body']);
		
		$mode = "#<div class=\"dealImage\">(.*)<a href=\"(.*)\"(.*)><img src=\"(.*)\"(.*)/></a>(.*)</div>#iUs";
		preg_match_all($mode, $contents, $matchArray);
		$newDeal['link']='http://dealsea.com'.$matchArray[2][0];
		$newDeal['pic']=$matchArray[4][0];
		if(!preg_match_all("#^http#iUs",$newDeal['pic'],$matchArray)){
			$newDeal['pic'] = 'http://dealsea.com'.$newDeal['pic'];
		}
		if(getDomainByUrl($newDeal['pic'] )=='dealsea.com'){
			$newDeal['proxy'] = $http['proxy'];
		}
		
		$http['url'] = $newDeal['link'];
		$http['header'] = true;
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
		$mode = "#Location: (.*)#im";
		preg_match_all($mode, $contents, $matchArray);
		$newDeal['link'] = $matchArray[1][0];
		if (getDomainByUrl($newDeal['link']) == 'dealsea.com'){
			continue;
		}
		if (!($newDeal['link'] = getFinalLink($newDeal['link'] ))){
				continue;
		}
		
		$newDeal['source'] = $sourceName;
		$dealToSave[] = $newDeal;
	}
	

	return $dealToSave;
}
?>
