<?php
$request_uri = $_SERVER["REQUEST_URI"];

$file_name="/management_default.php";
if ($request_uri == "/$backendName/config") {
	$file_name="/management_config.php";
}
if ($request_uri == "/$backendName/check_pic") {
	$file_name="/check_pic.php";
}
if ($request_uri == "/$backendName/upload") {
	$file_name="/upload.php";
}
else if (preg_match_all("#^/$backendName/page/\d+\$#iUs",$request_uri,$arr)) {
	$file_name="/management_content_list.php";
}
else if ($request_uri == "/$backendName/new") {
	$file_name="/management_content_new.php";
}
else if ($request_uri == "/$backendName/recommand") {
	$file_name="/management_recommand.php";
}
else if (preg_match_all("#^/$backendName/content/\d+\$#iUs",$request_uri,$arr)) {
	$file_name="/management_content_update.php";
}

include_once (dirname(__FILE__).$file_name);
?>
