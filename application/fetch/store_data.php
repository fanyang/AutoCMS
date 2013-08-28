<?php
include_once (dirname(__FILE__) . '/get_domain.php');
include_once (dirname(__FILE__) . '/../../library/Controler.php');
include_once (dirname(__FILE__) . '/tmhOAuth/post_tweet.php');

function saveDeal($dealToSave) {
	foreach ($dealToSave as $deal) {
		if (checkDomainExp(getDomainByUrl($deal['link']))) {
			$deal['link'] = getRefLink($deal['link']);
			$proxy = isset($deal['proxy'])?$deal['proxy']:'';
			$deal['pic'] = saveImg($deal['pic'],$proxy);
			if ($deal['pic'] == false) {
				continue;
			}
			$storeData = new Controler();
			$autoDisplay = $storeData->config['auto_display'];
			$deal['display'] = $autoDisplay;
			if(isset($deal['proxy'])){
				unset($deal['proxy']);
			}
			$id = $storeData->db->insert($deal, "content");
			if ($storeData->config['auto_twitter'] != 0) {
				$twitterString = 'http://www.dealforgirl.com/deals/'. $id . '.html '. $deal['title'];
				post_tweet($twitterString);
			}

		}
	}
}

function removeHtmlTags($content){
		$mode = "#(<table(.*)>)|(</table>)|(<th(.*)>)|(</th>)|(<tr(.*)>)|(</tr>)|(<td(.*)>)|(</td>)|(<br>)|(<div(.*)>)|(</div>)";
		$mode .="|(<a(.*)href(.*)>)|(</a>)|(<span(.*)>)|(</span>)|(<font(.*)>)|(</font>)|(<img(.*)src(.*)>)";
		$mode .="|(<iframe(.*)>(.*)</iframe>)|(<script(.*)>(.*)</script>)|(style=\"(.*)\")";
		$mode .= "#iUs";
		$content = preg_replace($mode, " ", $content);
		$content = preg_replace("#\s+#is", " ", $content);
		$content = trim($content);
		return $content;
}

function checkDomainExp($domain) {
	$storeData = new Controler();
	$domainExp = $storeData->config['domain_exp'];
	settype($domainExp, "int");
	$addToDatabase = false;
	$domain = addslashes($domain);
	$sql = "SELECT * FROM domaincache WHERE domain = '$domain'";
	$domainCache = $storeData->db->fetch_array($storeData->db->query($sql));
	if ($domainCache == false) {
		$arr = array (
			"domain" => $domain
		);
		$storeData->db->insert($arr, "domaincache");
		$addToDatabase = true;
	} else {
		$domainId = $domainCache['id'];
		$currentTime = time();
		$domainCacheTime = strtotime($domainCache['create_at']);
		if ($currentTime - $domainExp > $domainCacheTime) {
			$currentTime = date("Y-m-d H:i:s");
			$sql = "UPDATE domaincache SET create_at='$currentTime' WHERE id = $domainId";
			$storeData->db->query($sql);
			$addToDatabase = true;
		} else {
			$addToDatabase = false;
		}
	}
	return $addToDatabase;
}

function getRefLink($link) {
	$domain = getDomainByUrl($link);
	$storeData = new Controler();
	$domain = addslashes($domain);
	$sql = "SELECT * FROM reflink WHERE domain = '$domain'";
	$refLink = $storeData->db->fetch_array($storeData->db->query($sql));
	if ($refLink == false) {
		return $link;
	} else {
		$link = $refLink['link'];
		return $link;
	}
}

function saveImg($url, $proxy="") {
	$rootDir = "../..";
	$attachDir = "public/uploads";
	$tempPath = getImg($url, $proxy, dirname(__FILE__) . "/" . $rootDir . "/" . $attachDir);
	if ($tempPath == false) {
		return false;
	}
	$fileInfo = pathinfo($tempPath);
	$extension = $fileInfo['extension'];
	$attachSubDir = 'day_' . date('ymd');
	$fullDir = dirname(__FILE__) . "/" . $rootDir . "/" . $attachDir . '/' . $attachSubDir;
	if (!is_dir($fullDir)) {
		mkdir($fullDir, 0755);
	}
	$newFilename = date("YmdHis") . mt_rand(1000, 9999) . '.' . $extension;
	$targetPath = $fullDir . '/' . $newFilename;
	rename($tempPath, $targetPath);
	$targetPath = processThumbPic($targetPath, 135, 135);
	$fileInfo = pathinfo($targetPath);
	return "/" . $attachDir . "/" . $attachSubDir . "/" . $fileInfo['basename'];
}

function getImg($url = "", $proxy, $attachDir = "") {
	$tempPath = $attachDir . "/" . date("YmdHis") . mt_rand(10000, 99999) . '.tmp';
	$url = trim($url);
	$url = str_replace(" ", "+", $url);
	$fp = fopen($tempPath, 'wb');
	$contents = false;
	$fetchTime = 0;
	do {
		$hander = curl_init();
		curl_setopt($hander, CURLOPT_URL, $url);
		curl_setopt($hander, CURLOPT_FILE, $fp);
		curl_setopt($hander, CURLOPT_HEADER, false);
		curl_setopt($hander, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($hander, CURLOPT_TIMEOUT, 60);
		curl_setopt($hander, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($hander, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64)");
		curl_setopt($hander, CURLOPT_PROXY,$proxy);
		$contents = curl_exec($hander);
		curl_close($hander);
		$fetchTime++;
	} while ($contents == false && $fetchTime < 3);
	fclose($fp);
	if ($contents == false) {
		return false;
	}
	return $tempPath;
}

function processThumbPic($targetPath, $limitWidth = 135, $limitHeight = 135) {
	$pathname = pathinfo($targetPath);
	$filename = basename($targetPath, $pathname["extension"]);
	$newPath = $pathname["dirname"] . "/" . $filename;
	$img = getimagesize($targetPath);
	switch ($img[2]) {
		case 1 :
			$newPath .= "gif";
			rename($targetPath, $newPath);
			$im = @ imagecreatefromgif($newPath);
			$bgcolor = ImageColorAllocate($im, 0, 0, 0);
			$bgcolor = ImageColorTransparent($im, $bgcolor);
			break;
		case 2 :
			$newPath .= "jpg";
			rename($targetPath, $newPath);
			$im = @ imagecreatefromjpeg($newPath);
			break;
		case 3 :
			$newPath .= "png";
			rename($targetPath, $newPath);
			$im = @ imagecreatefrompng($newPath);
			$bgcolor = ImageColorAllocate($im, 0, 0, 0);
			$bgcolor = ImageColorTransparent($im, $bgcolor);
			break;
	}
	$widthOld = $img[0];
	$widthNew = $img[0];
	$heightOld = $img[1];
	$heightNew = $img[1];
	if ($widthNew > $limitWidth) {
		$heightNew = round($heightNew / ($widthNew / $limitWidth));
		$widthNew = $limitWidth;

	}
	if ($heightNew > $limitHeight) {
		$widthNew = round($widthNew / ($heightNew / $limitHeight));
		$heightNew = $limitHeight;

	}
	if ($widthOld > $limitWidth || $heightOld > $limitHeight) {
		$newim = imagecreatetruecolor($widthNew, $heightNew);
		imagealphablending($newim, false);
		imagesavealpha($newim, true);
		imagecopyresampled($newim, $im, 0, 0, 0, 0, $widthNew, $heightNew, $widthOld, $heightOld);
		switch ($img[2]) {
			case 1 :
				imagegif($newim, $newPath);
				break;
			case 2 :
				imagejpeg($newim, $newPath, 100);
				break;
			case 3 :
				imagepng($newim, $newPath);
				break;
		}
	}
	return $newPath;
}
?>
