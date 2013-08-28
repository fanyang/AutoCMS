<?php
include_once (dirname(__FILE__) . '/RecommandControler.php');
$controler = new RecommandControler($backendName);
$header = $controler->header;
include_once(dirname(__FILE__).'/header.php');
?>
<div id="PageBody">

<div id = "ManagementRecommend">
<?php
switch($controler->post_success){
	case 1:
	echo "<p class= \"HighLight\">更新成功!</p>";
	break;
	case -1:
	echo "<p class= \"HighLight\">更新出错!</p>";
	break;
}
?>

<form action="#" method="post">
<table>
<tr>
<th>顺序</th><th>内容ID</th><th>描述</th>
</tr>

<?php
foreach ($controler->recommands as $recommand):?>
<tr>
<td>
<?php echo $recommand['id'];?>
</td>
<td>
<input type="text" name="<?php echo $recommand['id'];?>_content_id" value="<?php echo $recommand['content_id'];?>">
</td>
<td>
<textarea name="<?php echo $recommand['id'];?>_description" <?php echo $controler->get_textarea_recommend_class();?>><?php echo str_replace("&","&amp;",$recommand['title']);?></textarea>
</td>
</tr>
<?php endforeach;?>
<tr>
<td></td>
<td></td>
<td><input type="submit" name="submit" value="更新"></td>
</tr>
</table>
</form>



</div><!--end of ManagementRecommend-->

</div><!--End of PageBody-->
<?php
include_once(dirname(__FILE__) . '/footer.php');
?>