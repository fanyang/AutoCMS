<?php
include_once (dirname(__FILE__) . '/ConfigControler.php');
$controler = new ConfigControler($backendName);
$header = $controler->header;
include_once(dirname(__FILE__).'/header.php');
?>
<div id="PageBody">
<div id="Config">
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
<tr><th>是否自动推荐</th><td>
<input type="radio" name="auto_recommand" value="1"
<?php if ($controler->config['auto_recommand']==1):?>
checked="checked"
<?php endif;?>
 />是&nbsp;&nbsp;
<input type="radio" name="auto_recommand" value="0"
<?php if ($controler->config['auto_recommand']==0):?>
checked="checked"
<?php endif;?> />否
</td></tr>
<tr><th>推荐多少秒以内内容</th><td>
<input type="text" name="recommand_time" value="<?php echo $controler->config['recommand_time'];?>" />秒</td></tr>
<tr><th>多少秒以内为新内容</th><td>
<input type="text" name="new_time" value="<?php echo $controler->config['new_time'];?>" />秒
</td></tr>
<tr><th>抓取后是否自动显示</th><td>
<input type="radio" name="auto_display" value="1"
<?php if ($controler->config['auto_display']==1):?>
checked="checked"
<?php endif;?>
 />是&nbsp;&nbsp;
<input type="radio" name="auto_display" value="0"
<?php if ($controler->config['auto_display']==0):?>
checked="checked"
<?php endif;?> />否
</td></tr>
<tr><th>抓取后是否自动Twitter</th><td>
<input type="radio" name="auto_twitter" value="1"
<?php if ($controler->config['auto_twitter']==1):?>
checked="checked"
<?php endif;?>
 />是&nbsp;&nbsp;
<input type="radio" name="auto_twitter" value="0"
<?php if ($controler->config['auto_twitter']==0):?>
checked="checked"
<?php endif;?> />否
</td></tr>
<tr><th>首页显示内容条数</th><td>
<input type="text" name="deal_amount" value="<?php echo $controler->config['deal_amount'];?>" />条
</td></tr>
<tr><th>网址多少秒内不重复抓取</th><td>
<input type="text" name="domain_exp" value="<?php echo $controler->config['domain_exp'];?>" />秒
</td></tr>
<tr><th></th>
<td><input type="submit" name="submit" value="更新"></td>
</tr>
</table>
</form>
</div><!--End of Config-->
</div><!--End of PageBody-->
<?php
include_once(dirname(__FILE__) . '/footer.php');
?>