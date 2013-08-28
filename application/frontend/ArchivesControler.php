<?php
include_once (dirname(__FILE__) . '/../../library/Controler.php');
class ArchivesControler extends Controler{
	public $dealdate;
	public $dealTitles;
	public function __construct() {
		parent :: __construct();
		if (!$this->url_ok()){$this->errorPage();}
		$this->make_header();

	}
		function url_ok() {
			if ($this->uri=="/archives/"){
				$this->dealdate = 0;
				return true;
			}
			if (preg_match_all('#^/archives/([0-9\-]{10})/$#',$this->uri,$matchArray)){
				$this->dealdate = $matchArray[1][0];
				$sql = "select id,title from content where date(create_at)='$this->dealdate' order by id desc";
				$query = $this->db->query($sql);
				if (mysql_num_rows($query)==0){
					return false;
				}
				else{
					$this->dealTitles = $this->db->fetch_to_array($sql);
				}
				return true;
			}
			else{return false;}
		}
		
		function getAllDate(){
			$firstDay = strtotime('2012-01-12');
			$today = strtotime(date('Y-m-d',time()));
			$allDate = array();
			do{
				$allDate[] = $today;
				$today-=86400;
			}
			while($today>=$firstDay);
			return $allDate;
		}

	function make_header() {
		$title = 'Archives of deals and coupons';
		$title = $this->dealdate==0?$title:$title.' '.$this->dealdate;
		$this->header['title'] = $title.' | DealForGirl';
		$this->header['description'] = $title;
		$this->header['keywords'] = $title;
		$this->header['css_array'][] = "/public/styles/reset.css";
		$this->header['css_array'][] = "/public/styles/global.css";
		$this->header['css_array'][] = "/public/styles/archives.css";
	}
}
?>
