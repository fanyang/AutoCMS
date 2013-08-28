<?php
include_once (dirname(__FILE__) . '/CategoryController.php');
$controler = new CategoryController();
$header = $controler->header;
include_once(dirname(__FILE__) . '/header.php');
?>

<div id="PageBody">
<div id="LatestDeals">
<div class = "TitleBar">
<h1><?php echo $controler->title;?></h1>
</div><!--End of LatestDeals-->
<div style="width:728px;margin:0 auto;">
<?php include_once (dirname(__FILE__) . '/banners/banner72890a.php');?>
</div>
<?php
$contents = $controler->getLatestDeals();
foreach ($contents as $content):
?>
<div class="OneDeal">
<div class="DealImage">
<a href="/view/<?php echo $content['id'];?>" target="_blank" title="Get this deal" style="background-image: url(<?php echo $content['pic']?>);"></a>
</div><!--End of DealImage-->
<div class="DealContent">
<div class="DealTitle">
<h2>
<a href="/deals/<?php echo $controler->makeArticleUri($content['id'], $content['title']);?>" target="_blank" onmouseover="TitleMouseOver(event)" onmouseout="TitleMouseOut(event)">
<?php if (time()-strtotime($content['create_at'])<$controler->config['new_time']):?>
	<span class="HighLight"><img src="/public/images/new.gif" alt="New: " /></span><?php endif;?>
<?php echo $controler->makeTitle($content['title']);?>
</a>
</h2>
</div><!--End of DealTitle-->
<div class="DealInfo">
<p>
<?php echo $content['create_at'];?>
</p>
</div><!--End of DealInfo-->
<div class="DealBody">
<p>
<?php echo $content['body'];?>
</p>
</div><!--End of DealBody-->

</div><!--End of DealContent-->
</div><!--End of OneDeal-->
<?php endforeach;?>
</div><!--End of LatestDeals-->
</div><!--End of PageBody-->
<div id = "backToTop">
<a href="#" title="Back to Top"></a>
</div><!--End of PageBody-->
<?php
include_once(dirname(__FILE__) . '/footer.php');
?>