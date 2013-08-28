<?php

//$url[] = "http://deals.huaren.us/blogurl.php?id=15344_1";
//$url[] = "http://dealnews.com/lw/artclick.html?2,537880,1919566";
//$url[] = "http://dealnews.com/lw/artclick.html?2,537493,1918047";
//$url[] = "http://www.dealmoon.com/exec/j/?d=138045";
//$url[] = "http://www.dealmoon.com/exec/j/?d=138407";
//$url[] = "http://www.fatwallet.com/redirect/bounce.php?afsrc=1&dealid=31005&fwcodeid=568652&bypCb=1";
//$url[] = "http://www.dealcatcher.com/redir/996543712";
//$url[] = "http://www.dealigg.com/out.php?id=303809";
//$url[] = "http://www.dealigg.com/out.php?id=242411";
//$url[] = "http://www.coupongreat.com/go/27015";
//$url[] = "http://www.keycode.com/offer_redeem.php?mer=1151&offer=116363";
//$url[] = "http://www.couponmountain.com/stats/redir.php?c=6&m=10396&p=464816";
//$url[] = "http://dealcoupon.com/lw/coupon.html?10,198888";
//$url[] = "http://bit.ly/wHmOXo";
//$url[] = "http://goo.gl/HkdDw";
//$url[] = "http://www.dealmoon.com/exec/j/?d=138128";
//$url[] = "http://www.fatwallet.com/redirect/bouncenocb.php?afsrc=1&cbmerch=10750&threadid=1158743";
//$url[] = "http://g.deals2buy.com/o/214dag2e";
//$url[] = "http://www.tkqlhce.com/click-5467912-10812806\" target=\"_top";
//$url[] = "http://www.tkqlhce.com/click-5467912-10812806%22+target%3D%22_top";
//$url[] = "http://www.sears.com/shc/s/p_10153_12605_03692202000P?sid=IDx20070921x00003c&srccode=cii_10043468&cpncode=18-108807587-2";
//$url[] = "http://www.lordandtaylor.com/?utm_source=GAN&utm_medium=Affiliates&utm_term=na&tag=GAN&ctcampaign=221&utm_campaign=dealnews&utm_content=Ban&cm_mmc=Affiliate-_-GAN-_-dealnews-_-Primar";
//$url[] = "http://deals.huaren.us/blogurl.php?id=15494_1";
//$url[] = "http://www.dealigg.com/out.php?id=944233";
//$url[] = "http://www.fatwallet.com/redirect/bounce.php?afsrc=1&dealid=31494&bypCb=1";
//$url[] = "http://dealnews.com/lw/artclick.html?2,540022,1929450";
//$url[] = "http://dealcoupon.com/lw/coupon.html?10,198950";
//$url[]="http://www.shareasale.com/r.cfm?u=482314&b=187009&m=12447&afftrack=no_refer&urllink=www.meritline.com%2Ffashion-alloy-watch-black---p-52588.aspx%3Fclickid%3DVHhZdDBRb0JDeG9BQUdQRnB6QUFBQUk1%26source%3Ddealmoon";
//$url[] = "http://lt.dell.com/lt/lt.aspx?ACD=10549103-889052-ds39url&CID=7420&LID=197374&DGC=BF&DGSeg=BSD&DURL=http://outlet.us.dell.com/ARBOnlineSales/Online/InventorySearch.aspx?c=us%26cs=28%26l=en%26s=dfb%26brandid=2802%26fid=8129&URL=http%3A%2F%2Flt.dell.com%2Flt%2Flt.aspx%3FACD%3D%25za-%25zp-%25zs%26CID%3D7420%26LID%3D197374%26DGC%3DBF%26DGSeg%3DBSD%26DURL%3Dhttp%3A%2F%2Foutlet.us.dell.com%2FARBOnlineSales%2FOnline%2FInventorySearch.aspx%3Fc%3Dus%2526cs%3D28%2526l%3Den%2526s%3Ddfb%2526brandid%3D2802%2526fid%3D8129";
//foreach ($url as $u) {
//	var_dump(getFinalLink($u));
//}

//-----------------------------------------------------------------------------------------
function getDomainByUrl($url) {
	$mode = "#^https?://(.*)(/|\?|$)#iUs";
	preg_match_all($mode, $url, $arr);
	$domain = $arr[1][0];
	return $domain;
}
function getFinalLink($url) {
	$tempUrl = $url;
	$cookie_file = tempnam("./temp", "cookie");
	$redirectTime = 0;
	do {
		$redirectTime++;
		$tempUrl = trim($tempUrl);
		$tempUrl = preg_replace("#\s+#iUs", "", $tempUrl);
		$tempUrl = str_replace("&amp;", "&", $tempUrl);
		$url = $tempUrl;

		$contents = false;
		$fetchTime = 0;
		do {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $tempUrl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 60);
			$ref_url = "http://twitter.com";
			curl_setopt($ch, CURLOPT_REFERER, $ref_url);
			curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
			curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7");
			$contents = curl_exec($ch);

			$curlResult = curl_getinfo($ch);

			curl_close($ch);
			$fetchTime++;
		} while ($contents == false && $fetchTime < 3);
		if ($contents == false) {
			return false;
		}

		if (($curlResult['http_code'] == 301 || $curlResult['http_code'] == 302)) {
			//			if (isset ($curlResult['redirect_url']) && $curlResult['redirect_url'] != "") {
			//				$tempUrl = $curlResult['redirect_url'];
			//				continue;
			//			}
			$mode = "#Location: (.*)#im";
			preg_match_all($mode, $contents, $arr);
			if ((!isset ($arr[1][0])) || $arr[1][0] == "") {
				return false;
			}
			$domain = getDomainByUrl($tempUrl);
			$newUrl= trim($arr[1][0]);
			$schema = "http://";
			if(preg_match_all("#^(https?://)(.*)#iUs",$tempUrl,$arr))
			{$schema = $arr[1][0];}
			if (preg_match_all("#^/(.*)#iUs",$newUrl,$arr))
			{$newUrl = $schema.$domain.$newUrl;}
			$tempUrl = $newUrl;
			continue;
		}
		if ($curlResult['http_code'] == 200) {
			$mode = "#<meta (.*)>#iUs";
			if (preg_match_all($mode, $contents, $arr) == false) {
				continue;
			}
			$metas = $arr[0];
			foreach ($metas as $meta) {
				$mode = "#http-equiv=(.*)((refresh)|(redirect))(.*)(http(.*))\"#iUs";
				if (preg_match_all($mode, $meta, $arr) == false) {
					continue;
				} else {
					$tempUrl = $arr[6][0];
					break;
				}
			}
		}

	}
	while ($tempUrl != $url && $fetchTime < 20);
	$tempUrl = preg_replace("#:80#","",$tempUrl,1);
	return $tempUrl;
}

?>
