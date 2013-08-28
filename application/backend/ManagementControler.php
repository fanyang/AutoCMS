<?php
include_once (dirname(__FILE__) . '/../../library/Controler.php');
class ManagementControler extends Controler{

	public function __construct($backendName = "management") {
		parent :: __construct();
		if (!isset ($_SESSION)) {
			session_start();
		}
		$this->backendName = $backendName;
	}

	public $backendName;

	function is_cookie_auth() {
		if (!isset ($_COOKIE['shell'])) {

			return false;
		}
		$shell = $_COOKIE['shell'];

		if ($shell == md5(sha1($this->config['password']))) {
			setcookie('shell', $shell, time() + 86400, "/");
			return true;
		} else {
			return false;
		}
	}
	function make_header() {
		$this->header['title'] = "Management | DealForGirl";
		$this->header['description'] = "About who we are and what we do.";
		$this->header['keywords'] = "dealforgirl, deal for girl, deals, coupons, discount, bargin, sale, buy, on sale, money saving, brands, clothing, apparel, shoes, handbags, jewelry, accessories, watches, beauty, fragrance, health, fitness, girls, ladies, women";
		$this->header['css_array'][] = "/public/styles/reset.css";
		$this->header['css_array'][] = "/public/styles/global.css";
		$this->header['css_array'][] = "/public/styles/management.css";
		$this->header['js_array'][] = "/public/scripts/jquery.js";
		$this->header['js_array'][] = "/public/scripts/management.js";
		$this->header['js_array'][] = "/public/scripts/xheditor.js";
	}

	function get_textarea_pic_class()
	{
		$class = "  class=\"xheditor {tools:'Img,|,Source,Preview',width:'300px',height:'300px',urlBase:'/',urlType:'root',upImgUrl:'/$this->backendName/upload',forcePtag:false}\"";
		return $class;
	}
	function get_textarea_content_class()
	{
		$class = "class=\"xheditor {hoverExecDelay:0,upLinkExt:'zip,rar,txt,pdf,doc,docx',width:'800px',height:'400px',urlBase:'/',urlType:'root',upLinkUrl:'/$this->backendName/upload',upImgUrl:'/$this->backendName/upload',upFlashUrl:'/$this->backendName/upload',upMediaUrl:'/$this->backendName/upload',forcePtag:false}\"";
		return $class;
	}
	function get_textarea_recommend_class()
	{
		$class=" class=\"xheditor {tools:'Cut,Copy,Paste,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,Removeformat,Align,List,Link,Unlink,Source,Preview',cleanPaste:3,width:'500',height:'150',forcePtag:false}\"";
		return $class;
	}

	function form_filter_name($string) {
		return preg_replace('/[^\w]/', '', $string);
	}

	function form_filter_url($string) {
		$string = str_replace("<", "%3C", $string);
		$string = str_replace(">", "%3E", $string);
		$string = str_replace("\"", "%22", $string);
		return $string;
	}

	function form_filter_ending_space($string) {
		return trim($string);
	}

	function form_filter_sql($string) {
		$string = addslashes($string);
		return $string;
	}

	function form_filter_simpletext($string) {
		$string = htmlspecialchars($string, ENT_COMPAT, "UTF-8");
		return $string;
	}
}
?>
