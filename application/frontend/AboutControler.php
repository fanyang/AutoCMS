<?php
include_once (dirname(__FILE__) . '/../../library/Controler.php');
class AboutControler extends Controler{

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
			if ($this->uri=="/about/"){return true;}
			else{return false;}
		}

	function make_header() {
		$this->header['title'] = "About Us | DealForGirl";
		$this->header['description'] = "About who we are and what we do.";
		$this->header['keywords'] = "dealforgirl, deals, coupons, discount, bargin, sale, clothing, apparel, shoes, handbags, jewelry, accessories, watches, beauty, fragrance, health, fitness";
		$this->header['css_array'][] = "/public/styles/reset.css";
		$this->header['css_array'][] = "/public/styles/global.css";
		$this->header['css_array'][] = "/public/styles/about.css";
	}
}
?>
