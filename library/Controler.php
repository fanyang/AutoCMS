<?php
include_once (dirname(__FILE__) . '/Config.php');
include_once (dirname(__FILE__) . '/Mysql_Class.php');

class Controler {

	public $db;
	public $uri;
	public $config;
	public $header;
	public function __construct() {
		$this->db = new mysql(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_CHARSET);
		$this->uri = rawurldecode($_SERVER["REQUEST_URI"]);
		$this->config = $this->getConfig();
	}

	function errorPage(){
		header("HTTP/1.1 404 Not Found");
		header("Refresh: 0; url=/");
		exit;
	}

	function jump($url){
		header("Location: $url");
		exit;
	}

	function getConfig(){
		$sql = "SELECT * FROM config";
		return $this->db->fetch_array($this->db->query($sql));
	}
	function makeArticleUri($id,$title){
		$newStr = preg_replace("#[^\w| ]#is","",$title);
		$newStr = trim($newStr);
		if ($newStr == ""){return $id.'.html';}
		$newStr = preg_replace("#\s+#s","-",$newStr);
		$newStr = strtolower($newStr);
		return $id.'-'.$newStr.'.html';
	}
	function makeTitle($string){
		$string = preg_replace("/(\\$\d+\.\d+)|(\\$\d+)|(\d+\.\d+\%)|(\d+\%)/i","<span class=\"HighLight\">\\0</span>",$string);
		return $string;
	}

}
?>
