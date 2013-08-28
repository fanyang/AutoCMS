<?php
include_once (dirname(__FILE__) . '/GuideControler.php');
$controler = new GuideControler();
$header = $controler->header;
include_once(dirname(__FILE__) . '/header.php');
?>
<div id="PageBody">

<div id="dealTable">
<div class="Title">
<h1>Deals, Tools</h1>
</div><!--end of Title-->
<div class="Content">
<ul id="dealUl1">
<?php foreach($controler->deals as $website):?>
<li>
<a href="/brands/<?php echo $website['id'];?>" title="<?php echo $website['description'];?>" target="_blank"><?php echo $website['name'];?></a>
</li>
<?php endforeach;?>
</ul>
</div><!--end of Content-->
</div><!--end of dealTable-->

<div id="fashionTable">
<div class="Title">
<h1>Clothing, Shoes, Handbags, Accessories, Jewelry</h1>
</div><!--end of Title-->
<div class="Content">
<ul id="fashionUl1">
<?php foreach($controler->fashionsLi1 as $website):?>
<li>
<a href="/brands/<?php echo $website['id'];?>" title="<?php echo $website['description'];?>" target="_blank"><?php echo $website['name'];?></a>
</li>
<?php endforeach;?>
</ul>
<ul id="fashionUl2">
<?php foreach($controler->fashionsLi2 as $website):?>
<li>
<a href="/brands/<?php echo $website['id'];?>" title="<?php echo $website['description'];?>" target="_blank"><?php echo $website['name'];?></a>
</li>
<?php endforeach;?>
</ul>
</div><!--end of Content-->
</div><!--end of fashionTable-->

<div id="beautyTable">
<div class="Title">
<h1>Beaury, Fragrance, Health</h1>
</div><!--end of Title-->
<div class="Content">
<ul id="beautyUl1">
<?php foreach($controler->beauties as $website):?>
<li>
<a href="/brands/<?php echo $website['id'];?>" title="<?php echo $website['description'];?>" target="_blank"><?php echo $website['name'];?></a>
</li>
<?php endforeach;?>
</ul>
</div><!--end of Content-->
</div><!--end of beautyTable-->

</div><!--End of PageBody-->
<?php
include_once(dirname(__FILE__) . '/footer.php');
?>