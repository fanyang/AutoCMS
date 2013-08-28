<?php
/*
 * index_ajax.php
 * Created on 2012-4-8
 * Author jkr7
 *
 */

include_once (dirname(__FILE__) . '/IndexAjaxController.php');

if (!(isset($_POST['page']))){exit;}
settype($_POST['page'],"int");
if (($_POST['page']<1)||($_POST['page']>30)){
	exit;
	}
$category = isset($_POST['category'])?$_POST['category']:'';
$controler = new IndexAjaxController($_POST['page'],20,$category);
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
<a href="/deals/<?php echo $controler->makeArticleUri($content['id'],$content['title']);?>" target="_blank" onmouseover="TitleMouseOver(event)" onmouseout="TitleMouseOut(event)">
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