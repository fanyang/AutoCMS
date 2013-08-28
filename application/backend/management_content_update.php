<?php
include_once (dirname(__FILE__) . '/ContentUpdateControler.php');
$controler = new ContentUpdateControler($backendName);
$header = $controler->header;
include_once(dirname(__FILE__) . '/header.php');
?>
<div id="PageBody">

<div id = "ContentUpdate">
<form action="#" method = "post">
<table>
<tr>
<th>标题:</th><td><input type = "text" name = "title" value = "<?php echo $controler->content['title'];?>"></td>
</tr>
<tr>
<th>主链接:</th><td><input type = "text" name = "link" value = "<?php echo $controler->content['link'];?>"></td>
</tr>
<?php for ($i=0;$i<5;$i++):?>
<tr>
<th>链接/<?php echo $i;?>:</th><td><input type = "text" name = "deal_content_url[<?php echo $i;?>]" value = "<?php if($url=$controler->get_deal_url($controler->content['id'],$i)):?><?php echo $url;?><?php endif;?>"></td>
</tr>
<?php endfor;?>
<tr>
<th>图片</th><td><textarea name="pic" <?php echo $controler->get_textarea_pic_class();?>><img src="<?php echo str_replace("&","&amp;",$controler->content['pic']);?>" /></textarea></td>
</tr>
<tr>
<th>内容:</th><td><textarea name="body" <?php echo $controler->get_textarea_content_class();?>><?php echo str_replace("&","&amp;",$controler->content['body']);?></textarea></td>
</tr>
<tr>
<th>显示:</th><td>
<p>
&nbsp;&nbsp;
<input type="radio" checked="checked" name="display" value="0" />待定&nbsp;&nbsp;
<input type="radio" name="display" value="1" />通过
</p>
</td>
</tr>
<tr>
<th></th>
<td><input type = "submit" name="submit" value ="提交" /></td>
</tr>
</table>

</form>


</div><!--end of ContentUpdate-->
</div><!--End of PageBody-->
<?php
include_once(dirname(__FILE__) . '/footer.php');
?>