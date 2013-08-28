<form action="#" method="post">
<table>
<tr><td>proxyIp: </td><td><input type="text" name="proxyIp" style="width: 800px;" /></td></tr>
<tr><td>url: </td><td><input type="text" name="url" style="width: 800px;" /></td></tr>
<tr><td></td><td><input type="submit" name="submit" value="submit" /></td></tr>
</table>
</form>
<?php
if(!isset($_POST['submit'])){
	exit;
}
// $proxyIp = '59.57.15.71:80';
// $url = "http://www.dealforgirl.com/shuafen/test/test2.php";
// $url = "http://www.dealmoon.com";
// $url = "http://dealsea.com";
// $url = "http://dealnews.com";
// $url = "http://dealcoupon.com";
// $url = "http://huaren.us";
// $url = "http://www.dealigg.com";
// $url = "http://www.fatwallet.com";

$http['proxy'] = $_POST['proxyIp'];
$http['url'] = $_POST['url'];
$http['header'] = true;

include_once (dirname(__FILE__) . '/get_one_page.php');
echo $contents = getOnePage($http);
?>