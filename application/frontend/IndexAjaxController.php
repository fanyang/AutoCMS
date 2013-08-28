<?php
/*
 * indexAjaxController.php
 * Created on 2012-4-8
 * Author jkr7
 *
 */
include_once (dirname(__FILE__) . '/../../library/Controler.php');
class IndexAjaxController extends Controler{
	private $currentPage;
	private $pageSize;
	private $category;
	public function __construct($currentPage,$pageSize,$category) {
		parent :: __construct();
		$this->currentPage = $currentPage;
		$this->pageSize = $pageSize;
		$this->category = $category;
	}
	public function getLatestDeals(){
		$dealAmount = $this->pageSize;
		$start = ($this->currentPage-1)*$dealAmount;
		$source = '';
		switch ($this->category){
			case 'apparel':
				$source  = "('dealcoupon Clothing','Dealigg ApparelShoes','Dealmoon Clothing','Dealnews Clothing','dealsea','Fatwallet Clothing','Huaren Fashion')";
				break;
			case 'beauty':
				$source  = "('Dealmoon Beauty','Huaren Beauty')";
				break;
		}
		$source = ($source=='')?'':' and source in '.$source;
		$sql = "SELECT * FROM content WHERE display!=0".$source." ORDER BY id DESC LIMIT $start,$dealAmount";
		return $this->db->fetch_to_array($sql);
	}

}
