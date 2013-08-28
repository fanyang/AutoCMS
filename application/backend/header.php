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
<div id = "HeaderMenu">
<p>
<a href="/<?php echo $backendName;?>/page/1">列表</a>
| <a href="/<?php echo $backendName;?>/new" target="_blank">新建</a>
| <a href="/<?php echo $backendName;?>/recommand">推荐</a>
| <a href="/<?php echo $backendName;?>/config">配置</a>
| <a href="/<?php echo $backendName;?>/logout">退出</a>
</p>
</div><!--End of HeaderMenu-->
<div id="HeaderBottom">
</div><!--End of HeaderBottom-->
</div><!--End of PageHeader-->