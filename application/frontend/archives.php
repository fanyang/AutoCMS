<?php
include_once (dirname(__FILE__) . '/ArchivesControler.php');
$controller = new ArchivesControler();
$header = $controller->header;
include_once(dirname(__FILE__) . '/header.php');
?>
<div id="PageBody">
<?php if($controller->dealdate==0):?>
<div id="title"><h1>Archives of Deals and Coupons</h1></div>
<ul id="dateList">
<?php $alldate = $controller->getAllDate();
foreach ($alldate as $oneDate):
$oneDate = date('Y-m-d',$oneDate);
?>
<li><a href="/archives/<?php echo $oneDate;?>/" target="_blank"><?php echo $oneDate;?></a></li>
<?php endforeach;?>
</ul>
<?php else:?>
<div id="title"><h1><?php echo $controller->dealdate;?> Deals and Coupons</h1></div>
<ul id="dealsList">
<?php
foreach ($controller->dealTitles as $dealTitle):
?>
<li><a href="/deals/<?php echo $controller->makeArticleUri($dealTitle['id'],$dealTitle['title']);?>" target="_blank"><?php echo $dealTitle['title'];?></a></li>
<?php endforeach;?>
</ul>
<?php endif;?>
</div><!--End of PageBody-->
<?php
include_once(dirname(__FILE__) . '/footer.php');
?>