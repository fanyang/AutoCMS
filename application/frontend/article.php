<?php
include_once (dirname(__FILE__) . '/ArticleController.php');
$controller = new ArticleController();
$header = $controller->header;
include_once(dirname(__FILE__) . '/header.php');
?>
<div id="PageBody">
<div id="Content">
<div id="Navigator">
<div id="NavLeft">
<?php if($controller->lastArticle['id']!=$controller->article['id']):?>
<a href="<?php echo $controller->makeArticleUri($controller->lastArticle['id'],$controller->lastArticle['title'])?>" title="Previous"></a>
<?php else:?>
<a></a>
<?php endif;?>
</div><!--End of NavLeft-->
<div id="NavMiddle">
<?php foreach($controller->articlePager as $article):?>
<a href="/deals/<?php echo $controller->makeArticleUri($article['id'],$article['title']);?>"
 <?php if($article['id']==$controller->article['id']):?>class="current"<?php endif;?>
 title="<?php echo $article['title'];?>"
 style="background-image: url(<?php echo $article['pic']?>);"
 ><span class="PicTitle"><?php echo $article['title'];?></span></a>
<?php endforeach;?>
</div><!--End of NavMiddle-->
<div id="NavRight">
<?php if($controller->nextArticle['id']!=$controller->article['id']):?>
<a href="<?php echo $controller->makeArticleUri($controller->nextArticle['id'],$controller->nextArticle['title'])?>" title="Next"></a>
<?php else:?>
<a></a>
<?php endif;?>
</div><!--End of NavRight-->
</div><!--End of Navigator-->
<div id="Title">
<h1><a href="/view/<?php echo $controller->article['id'];?>" target="_blank"><?php echo $controller->article['title'];?></a></h1>
<p><?php echo $controller->article['create_at'];?></p>
</div><!--End of Title-->
<div id="ContentBody">
<div id="Thumb">
<a href="/view/<?php echo $controller->article['id'];?>" target="_blank" title="Get this deal" style="background-image: url(<?php echo $controller->article['pic']?>);"></a>
</div><!--End of Thumb-->
<div id="ContentBodyDown">
<div style="width: 900px; height: 90px; margin:5px; float: left; text-align: right;">
<?php include_once (dirname(__FILE__) . '/banners/banner72890a.php');?>
</div>
<div style="float: right; margin:5px 5px 5px 5px;">
<?php include_once (dirname(__FILE__) . '/banners/banner336280a.php');?>
</div>
<div id="ContentBodyLeft">
<p style="font-size:14px;line-height:30px;"><a href="/view/<?php echo $controller->article['id'];?>" target="_blank" title="Get this Deal / Coupon">Click Here</a></p>
<p><?php echo $controller->article['body'];?></p>
</div>
</div><!--End of ContentBodyDown-->
</div><!--End of ContentBody-->
<div style="clear:both;"></div>
</div><!--End of Content-->
<div id="Comment">
<div class = "TitleBar">
<h2>Add New Comment</h2>
</div><!--End of TitleBar-->
<div id="CommentList">
<table>
<?php
$floor = 1;
foreach ($controller->comments as $comment):
?>
  <tr>
  <td><?php echo $floor?>:</td>
  <td><?php echo $comment['name']?></td>
  <td><?php echo $comment['create_at']?></td>
  </tr>
  <tr>
  <td colspan="3" style="background-color: #FFF;"><?php echo $comment['body']?></td>
  </tr>
  <?php $floor++;endforeach;?>
</table>
</div><!--End of CommentList-->
<div id="CommentForm">
<form action="#" method="post">
<table>
<tr><th>Name (optional):</th><td><input type="text" name="name" maxlength="25" /></td></tr>
<tr><th>Email (optional):</th><td><input type="text" name="email" maxlength="50" /></td></tr>
<tr><th>Comment:</th><td><textarea name="body" rows="10" cols="50"></textarea></td></tr>
<tr><th></th><td><input type="submit" name="submit" value="Submit" class="button"/></td></tr>
</table>
</form>
</div><!--End of CommentForm-->
</div><!--End of Comment-->
</div><!--End of PageBody-->
<?php
include_once(dirname(__FILE__) . '/footer.php');
?>