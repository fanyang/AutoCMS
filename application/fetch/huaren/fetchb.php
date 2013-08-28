<?php
include_once (dirname(__FILE__) . '/fetch.php');

$url = "http://deals.huaren.us/categories/beauty-and-health/";
$sourceName = "Huaren Beauty";
$dealToSave = fetch($url, $sourceName);
if ($dealToSave != false) {
	saveDeal($dealToSave);
}
?>
