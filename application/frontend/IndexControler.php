<?php
include_once (dirname(__FILE__) . '/../../library/Controler.php');
class IndexControler extends Controler{
	public function __construct() {
		parent :: __construct();
		if (!$this->url_ok()){
			$this->errorPage();
		}
		else{
			$this->make_header();
		}
	}
		function url_ok() {
			if ($this->uri=="/"){return true;}
			else{return false;}
		}

	function make_header() {
		$this->header['title'] = "Deals, Discounts and Coupons on Apparel, Shoes, Handbags, Jewelry & Accessories, Beauty & Fragrance, Health & Fitness. | DealForGirl";
		$this->header['description'] = "Deals, Discounts and Coupons for Girls. DealForGirl picks daily best deals, discounts and coupons on fine apparel, shoes, handbags, jewelry and accessories, beauty and fragrance, health and fitness. We are dedicated to help you save money and time when you shop online. We guarantee that our deals,discounts and coupons are best, newest, and most comprehensive.";
		$this->header['keywords'] = "dealforgirl, deals, coupons, discount, bargin, sale, clothing, apparel, shoes, handbags, jewelry, accessories, watches, beauty, fragrance, health, fitness";
		$this->header['css_array'][] = "/public/styles/reset.css";
		$this->header['css_array'][] = "/public/styles/global.css";
		$this->header['css_array'][] = "/public/styles/index.css";
		$this->header['js_array'][] = "http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js";
		$this->header['js_array'][] = "/public/scripts/global.js";
		$this->header['js_array'][] = "/public/scripts/index.js";
	}
	function getRecommandDeals(){
		$sql = "SELECT * FROM recommand ORDER BY id ASC";
		return $this->db->fetch_to_array($sql);
	}
	function getContentById($id){
		$sql = "SELECT * FROM content WHERE id=$id";
		return $this->db->fetch_array($this->db->query($sql));
	}
	public function getLatestDeals(){
		$sql = "SELECT * FROM content WHERE display!=0 ORDER BY id DESC LIMIT 20";
		return $this->db->fetch_to_array($sql);
	}
}
?>
