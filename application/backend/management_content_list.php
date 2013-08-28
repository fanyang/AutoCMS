<?php
include_once (dirname(__FILE__) . '/ContentListControler.php');
$controler = new ContentListControler($backendName);
$header = $controler->header;
include_once(dirname(__FILE__) . '/header.php');
?>

<div id = "ContentList">
<form action = "#" method = "post">
<input type = "submit" name = "delete" value = "删除所选" />
<table>
<tr>
<th></th>
<th>ID</th>
<th>标题</th>
<th>是否显示</th>
<th>来源</th>
<th>创建时间</th>
<th>点击次数</th>
<th>链接</th>
</tr>
<?php foreach ($controler->contents as $content):?>
<tr>
<td><input type="checkbox" name = "contents[]" value = "<?php echo $content['id'];?>" /></td>
<td><a href="/deals/<?php echo $content['id'];?>.html" target="_blank"><?php echo $content['id'];?></a></td>
<td style="max-width:600px;"><p><a href = "/<?php echo $backendName;?>/content/<?php echo $content['id'];?>" target="_blank"><?php echo $content['title'];?></a></p></td>
<td><?php if($content['display']==0) {echo "N";}else{echo "Y";}?></td>
<td><p><?php echo $content['source']?></p></td>
<td><p><?php echo $content['create_at']?></p></td>
<td><?php echo $content['view_count'];?></td>
<td style="max-width:1500px;"><a href="<?php echo $content['link'];?>" target="_blank"><?php echo $content['link'];?></a></td>
</tr>
<?php endforeach;?>
</table>
</form>
</div><!--end of ContentList-->

<div id="Pages">
<?php for ($i=1;$i<=$controler->last_page;$i++):?>
<?php if($i==$controler->current_page):?>
<?php echo $i;?>
<?php else:?>
<a href="/<?php echo $backendName;?>/page/<?php echo $i;?>"><?php echo $i;?></a>
<?php endif;?>
 |
<?php endfor;?>
</div> <!--end of Pages-->

<?php
include_once(dirname(__FILE__) . '/footer.php');
?>
