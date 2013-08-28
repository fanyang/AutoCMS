<?php
include_once (dirname(__FILE__) . '/fetch.php');
include_once (dirname(__FILE__) . '/../get_one_page.php');

$http['url'] = "http://www.dealmoon.com/Health-Beauty";
$http['proxy'] = isset($proxy['dealmoon'])?$proxy['dealmoon']:'';
$sourceName = "Dealmoon Beauty";
$dealToSave = fetch($http, $sourceName);
if ($dealToSave != false) {
	saveDeal($dealToSave);
}
?>
