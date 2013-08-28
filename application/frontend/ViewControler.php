<?php
include_once (dirname ( __FILE__ ) . '/../../library/Controler.php');
class ViewControler extends Controler {
	
	public function __construct() {
		parent::__construct ();
		if (! $this->url_ok ()) {
			$this->errorPage ();
		}
	
	}
	function url_ok() {
		$this->uri = explode ( "/", $this->uri );
		$request_uri_num = count ( $this->uri );
		//http://www.com/view/100/1
		if (! ($request_uri_num == 3 || $request_uri_num == 4)) {
			return false;
		}
		if ($this->uri [1] != "view") {
			return false;
		}
		
		$contentId = addslashes ( $this->uri [2] );
		if (! preg_match_all ( "#^\d+\$#s", $contentId, $arr )) {
			return false;
		}
		$sql = "SELECT * FROM content where id = $contentId and display!=0";
		$content = $this->db->fetch_array ( $this->db->query ( $sql ) );
		if (! $content) {
			return false;
		}
		
		if ($request_uri_num == 3) {
			if ($content ['link'] != "") {
				$this->updateViewCount ( $contentId );
				header ( 'HTTP/1.1 302 Moved Temporarily' );
				header ( 'Location: ' . $content ['link'] );
				exit ( 0 );
			} else {
				return false;
			}
		} else {
			$linkNum = addslashes ( $this->uri [3] );
			if (! preg_match_all ( "#^\d+\$#s", $linkNum, $arr )) {
				return false;
			}
			$sql = "SELECT * FROM content_link WHERE content_id = $contentId AND link_num=$linkNum";
			$link = $this->db->fetch_array ( $this->db->query ( $sql ) );
			if ($link) {
				$this->updateViewCount ( $contentId );
				header ( 'HTTP/1.1 302 Moved Temporarily' );
				header ( 'Location: ' . $link ['deal_link'] );
				exit ( 0 );
			} else {
				return false;
			}
		}
	}
	
	function updateViewCount($contentId) {
		$sql = "UPDATE content SET view_count=view_count+1 WHERE id=$contentId";
		$this->db->query ( $sql );
	}

}