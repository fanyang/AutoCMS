<?php
include_once (dirname(__FILE__) . '/../../library/Controler.php');
class GuideControler extends Controler{

	public $id;
	public $deals;
	public $fashionsLi1;
	public $fashionsLi2;
	public $beauties;
	public function __construct() {
		parent :: __construct();
		$this->id = 0;
		if (!$this->url_ok()){$this->errorPage();}
		$this->make_header();
		$this->deals = $this->getDealTable();
		$this->beauties = $this->getbeautyTable();
		$this->getfashionTable();

	}
		function url_ok() {
			if ($this->uri=="/brands/"){return true;}
			else if (preg_match_all("#^/brands/(\\d+)$#s",$this->uri,$arr)){
				$this->id = $arr[1][0];
				$sql="select * from guide_website where id=$this->id";
				if ($row = $this->db->fetch_array($this->db->query($sql)))
				{
					$url=$row['url'];
					$newNum = $row['count']+1;
					$sql = "update guide_website set count=$newNum where id = $this->id";
					$this->db->query($sql);
					header ( 'HTTP/1.1 302 Moved Temporarily' );
					header ( 'Location: ' . $url );
					exit(0);
				}
				else{return false;}
				}
			else{return false;}
		}

	function make_header() {
		$this->header['title'] = "Top Brands Fashion Shopping Guide | DealForGirl";
		$this->header['description'] = "Top Brands Apparel, Shoes, Handbags, Jewelry & Accessories, Beauty & Fragrance, Health & Fitness.";
		$this->header['keywords'] = "dealforgirl, deals, coupons, discount, bargin, sale, clothing, apparel, shoes, handbags, jewelry, accessories, watches, beauty, fragrance, health, fitness";
		$this->header['css_array'][] = "/public/styles/reset.css";
		$this->header['css_array'][] = "/public/styles/global.css";
		$this->header['css_array'][] = "/public/styles/guide.css";
		$this->header['js_array'][] = "http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js";
		$this->header['js_array'][] = "/public/scripts/guide.js";
	}

	function getDealTable(){
		$sql = "select * from guide_website where category=1 order by name asc";
		return $this->db->fetch_to_array($sql);
	}
	function getFashionTable(){
		$sql = "select count(id) from guide_website where category=3";
		$num = $this->db->fetch_array($this->db->query($sql));
		$num = ceil($num[0]/2);
		$sql = "select * from guide_website where category=3 order by name asc limit 0,$num";
		$this->fashionsLi1 = $this->db->fetch_to_array($sql);
		$sql = "select * from guide_website where category=3 order by name asc limit $num,99999";
		$this->fashionsLi2 = $this->db->fetch_to_array($sql);
	}
	function getBeautyTable(){
		$sql = "select * from guide_website where category=2 order by name asc";
		return $this->db->fetch_to_array($sql);
	}
}