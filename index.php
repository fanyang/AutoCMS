<?php
ini_set('date.timezone','America/Denver');
$request_uri = explode("/",rawurldecode($_SERVER["REQUEST_URI"]));
$request_uri_num = count($request_uri);
$file_name="/application/frontend/index.php";
$backendName = "management";
if ($request_uri[0]=="" && $request_uri[1]=="" && $request_uri_num==2)
{
	$file_name="/application/frontend/index.php";
}
else if($request_uri[1]=="index_ajax")
{
	$file_name="/application/frontend/index_ajax.php";
}
else if($request_uri[1]=="view")
{
	$file_name="/application/frontend/view.php";
}
else if($request_uri[1]=="deals")
{
	$file_name="/application/frontend/article.php";
}
else if($request_uri[1]=="apparel"||$request_uri[1]=="beauty")
{
	$file_name="/application/frontend/category.php";
}
else if($request_uri[1]=="search")
{
	$file_name="/application/frontend/search.php";
}
else if($request_uri[1]=="about")
{
	$file_name="/application/frontend/about.php";
}
else if($request_uri[1]=="brands")
{
	$file_name="/application/frontend/guide.php";
}
else if($request_uri[1]=="archives")
{
	$file_name="/application/frontend/archives.php";
}
else if($request_uri[1]==$backendName)
{
	$file_name="/application/backend/management_index.php";
}
include_once (dirname(__FILE__).$file_name);
?>