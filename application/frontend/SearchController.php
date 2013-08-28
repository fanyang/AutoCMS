<?php
include_once (dirname(__FILE__) . '/../../library/Controler.php');
class SearchController extends Controler{
	public $keywords;
	public $searchResults;
	public function __construct() {
		parent :: __construct();
		if (!$this->url_ok()){
			$this->errorPage();
		}
		$this->keywords = (isset($_POST['keywords']))?$_POST['keywords']:'';
		$this->keywords = substr($this->keywords,0,50);
		$this->keywords = preg_replace('#[^0-9a-zA-Z]#s','',$this->keywords);
		$this->searchResults = $this->getSearchResults();
		$this->make_header();
	}
	
	function url_ok() {
			if ($this->uri=="/search/"){return true;}
			else{return false;}
		}

	function make_header() {
		$this->header['title'] = 'Search deals and coupons: '.$this->keywords;
		$this->header['description'] = 'Search deals and coupons: '.$this->keywords;
		$this->header['keywords'] = 'Search deals and coupons: '.$this->keywords;
		$this->header['css_array'][] = "/public/styles/reset.css";
		$this->header['css_array'][] = "/public/styles/global.css";
		$this->header['css_array'][] = "/public/styles/search.css";
	}
	
	function getSearchResults(){
		if($this->keywords==''){
			return null;
		}
		$sql = "SELECT * FROM content WHERE display!=0 and title like '%$this->keywords%' ORDER BY id DESC LIMIT 300";
		return $this->db->fetch_to_array($sql);
	}
}