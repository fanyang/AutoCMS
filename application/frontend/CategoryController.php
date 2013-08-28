<?php
include_once (dirname(__FILE__) . '/../../library/Controler.php');
class CategoryController extends Controler{
	public $category;
	public $title;
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
			if ($this->uri=="/apparel/"||$this->uri=="/beauty/"){
				$uriArray = explode('/',$this->uri);
				$this->category = $uriArray[1];
				switch ($this->category){
					case 'apparel':
						$this->title = 'Apparel, Shoes, Handbags, Jewelry & Accessories';
						break;
					case 'beauty':
						$this->title = 'Beauty & Fragrance, Health & Fitness';
						break;
				}
				return true;
			}
			else{return false;}
		}

	function make_header() {
		$this->header['title'] = $this->title.', Deals, Discounts and Coupons';
		$this->header['description'] = "Deals, Discounts and Coupons for Girls. DealForGirl picks daily best deals, discounts and coupons on fine apparel, shoes, handbags, jewelry and accessories, beauty and fragrance, health and fitness. We are dedicated to help you save money and time when you shop online. We guarantee that our deals,discounts and coupons are best, newest, and most comprehensive.";
		$this->header['keywords'] =  $this->title.', Deals, Discounts, Coupons';
		$this->header['css_array'][] = "/public/styles/reset.css";
		$this->header['css_array'][] = "/public/styles/global.css";
		$this->header['css_array'][] = "/public/styles/index.css";
		$this->header['js_array'][] = "http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js";
		$this->header['js_array'][] = "/public/scripts/global.js";
		$this->header['js_array'][] = "/public/scripts/category.js";
	}

	public function getLatestDeals(){
		switch ($this->category){
			case 'apparel':
				$source  = "('dealcoupon Clothing','Dealigg ApparelShoes','Dealmoon Clothing','Dealnews Clothing','dealsea','Fatwallet Clothing','Huaren Fashion')";
				break;
			case 'beauty':
				$source  = "('Dealmoon Beauty','Huaren Beauty')";
				break;
		}
		$sql = "SELECT * FROM content WHERE display!=0 and source in $source ORDER BY id DESC LIMIT 20";
		return $this->db->fetch_to_array($sql);
	}
}
?>
