<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if (isset($header['title'])) {echo $header['title'];}?></title>
<meta name="description" content="<?php if (isset($header['description'])) {echo $header['description'];}?>" />
<meta name="keywords" content="<?php if (isset($header['keywords'])) {echo $header['keywords'];}?>" />
<?php if (isset($header['css_array'])):?>
<?php foreach($header['css_array'] as $css):?>
<link href="<?php echo $css;?>" rel="stylesheet" type="text/css" />
<?php endforeach;?>
<?php endif;?>
<?php if (isset($header['js_array'])):?>
<?php foreach($header['js_array'] as $js):?>
<script language="JavaScript" src="<?php echo $js;?>" type="text/javascript"></script>
<?php endforeach;?>
<?php endif;?>
</head>
<body>
<div id = "Container">
<div id="PageHeader">
<div id = "HeaderLogo">
<a href="/"><img src="/public/images/logo.png" title="DealForGirl: Best deal website for smart girls" alt="DealForGirl" /></a>
</div><!--End of Logo-->
<div id = "HeaderBanner">
<?php include_once (dirname(__FILE__) . '/banners/banner48060a.php');?>
</div><!--End of Banner-->
<div id="TwitterButton">
<a href="https://twitter.com/DealForGirl" class="twitter-follow-button" data-show-count="true" data-show-screen-name="false">Follow @DealForGirl</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div><!--End of TwitterButton-->

<div class="nav_search">
<form method="post" action="/search/">
<input type="text" value="" autocomplete="on" name="keywords" class="kw_ipt f12 gray">
<input type="submit" value="" id="fm_hd_btm_shbx_bttn" class="do_ipt">
</form>
</div><!--End of nav_search-->

<div class="main_nav_wrapper">
<div class="main_nav">
<ul class="nav_left">
<li><a href="/" title="DealForGirl Homepage">Home</a></li>
<li><a href="/apparel/" target="_blank" title="Apparel, Shoes, Handbags, Jewelry & Accessories">Apparel</a></li>
<li><a href="/beauty/" target="_blank" title="Beauty & Fragrance, Health & Fitness">Beauty</a></li>
<li><a href="/brands/" target="_blank" title="Top Brands List">Brands</a></li>
<li><a href="/archives/" target="_blank" title="Archives of Deals and Coupons">Archives</a></li>
<li><a href="/about/" target="_blank" title="About DealForGirl">About</a></li>
</ul>
</div>
</div>
</div><!--End of PageHeader-->