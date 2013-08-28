<?php
$proxy['dealsea']='130.94.148.99:80';
$proxy['dealmoon']='59.57.15.71:80';

function getOnePage($http){
	$http['proxy'] = isset($http['proxy'])?$http['proxy']:'';
	$http['header'] = isset($http['header'])?$http['header']:false;
	$headers['CLIENT-IP'] = '72.30.38.140';
	$headers['X-FORWARDED-FOR'] = '72.30.38.140';
	$cookie = "./cookie/cookie.tmp";
	$headerArr = array();
	foreach( $headers as $n => $v ) {
		$headerArr[] = $n .':' . $v;
	}
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $http['url']);
	curl_setopt ($ch, CURLOPT_HTTPHEADER , $headerArr );  //构造IP
	curl_setopt($ch, CURLOPT_PROXY,$http['proxy']);
	curl_setopt ($ch, CURLOPT_REFERER, $http['url']);   //构造来路
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
	curl_setopt($ch, CURLOPT_HEADER, $http['header']);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64)");
	curl_setopt($ch, CURLOPT_ENCODING, 'identity,gzip,deflate');
	$contents = curl_exec($ch);
	curl_close($ch);
	return $contents;
}