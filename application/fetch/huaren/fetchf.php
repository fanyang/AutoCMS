<?php
include_once (dirname(__FILE__) . '/fetch.php');

$url = "http://deals.huaren.us/categories/fashion/";
$sourceName = "Huaren Fashion";
$dealToSave = fetch($url, $sourceName);
if ($dealToSave != false) {
	saveDeal($dealToSave);
}
?>
