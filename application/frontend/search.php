<?php
include_once (dirname(__FILE__) . '/SearchController.php');
$controler = new SearchController();
$header = $controler->header;
include_once(dirname(__FILE__) . '/header.php');
?>
<div id="PageBody">
<div id="SearchForm">
<form method="post" action="#">
<input type="text" value="" autocomplete="on" name="keywords">
<input type="submit" value="Search" name="submit" class="pink">
</form>
</div><!--End of SearchForm-->
<div id="SearchResult">
<?php if(!empty($controler->keywords)):?>
<h1>Search deals and coupons: <strong><?php echo $controler->keywords;?></strong></h1>
<div style="width:728px;margin:0 auto;">
<?php include_once (dirname(__FILE__) . '/banners/banner72890a.php');?>
</div>
<?php foreach ($controler->searchResults as $result):?>
<span class="date"><?php echo substr($result['create_at'],0,10);?></span>
<a href="/deals/<?php echo $controler->makeArticleUri($result['id'],$result['title']);?>" target="_blank"><?php echo $result['title']?></a><br />
<?php endforeach;?>
<?php endif;?>
</div><!--End of SearchResult-->
</div><!--End of PageBody-->
<?php
include_once(dirname(__FILE__) . '/footer.php');
?>