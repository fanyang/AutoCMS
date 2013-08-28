<?php
include_once (dirname(__FILE__) . '/../../library/Controler.php');

updateRecommand();

function getCountById($id) {
	$storeData = new Controler();
	$sql = "SELECT view_count FROM content WHERE id = $id";
	$count = $storeData->db->fetch_to_array($sql);
	return $count[0]['view_count'];
}

function updateRecommand() {
	$storeData = new Controler();
	$autoRecommand = $storeData->config['auto_recommand'];
	if ($autoRecommand == 0) {
		return false;
	}
	$recommandTime = date("Y-m-d H:i:s", mktime() - $storeData->config['recommand_time']);
	$sql = "SELECT count(id) FROM recommand";
	$numberOfRecommands = $storeData->db->fetch_array($storeData->db->query($sql));
	$numberOfRecommands = $numberOfRecommands[0];
	settype($numberOfRecommands, "int");
	$sql = "SELECT id,title FROM content WHERE create_at>'$recommandTime' AND display=1 ORDER BY view_count DESC LIMIT 0,$numberOfRecommands";
	$recommands = $storeData->db->fetch_to_array($sql);
	$sql = "TRUNCATE TABLE recommand";
	$storeData->db->query($sql);
	$newRecommand = array ();
	foreach ($recommands as $recommand) {
		$newRecommand['content_id '] = $recommand['id'];
		$newRecommand['title'] = $recommand['title'];
		$storeData->db->insert($newRecommand, 'recommand');
	}
	return true;

}
?>
