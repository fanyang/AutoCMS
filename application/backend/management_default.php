<?php
include_once (dirname(__FILE__) . '/DefaultControler.php');
$controler = new DefaultControler($backendName);
if ($controler->is_login()) {
	if ($controler->exec_login()) {
		$controler->jump("/$backendName/page/1");
	}
}

else if ($controler->is_logout()) {

	$controler->exec_logout();
	$controler->jump("/$backendName");
}

else if ($controler->is_cookie_auth()){
	$controler->jump("/$backendName/page/1");
}
?>

<form action = "#" method = "post">

<table>
<tr>
<th>Password:</th><td><input type = "password" name = "password" /></td>
</tr>
<tr>
<th>Code:</th><td><input type = "text" name = "check_pic" />
<img src = "/<?php echo $backendName;?>/check_pic"></td>
</tr>
</table>
<input type = "submit" name = "submit" value = "Login" />
<h2><a href="/">Back Home</a></h2>
</form>
