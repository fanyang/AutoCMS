<?php
include_once (dirname(__FILE__) . '/ManagementControler.php');
class ContentListControler extends ManagementControler {

	public $current_page;
	public $last_page;
	public $contents;

	public function __construct($backendName) {
		parent :: __construct($backendName);
		if (!($this->is_cookie_auth() && $this->url_ok())) {
			$this->jump("/$this->backendName");
		}
		$this->exec_post();
		$this->make_header();
		$this->contents = $this->getContents($this->config['deal_amount']);

	}

	function url_ok() {
		if(!preg_match_all("#^/$this->backendName/page/(\d+)\$#iUs",$this->uri,$arr)){return false;}
		$this->current_page = $arr[1][0];
		$this->last_page = $this->get_last_page_all_content($this->config['deal_amount']);
		if ($this->current_page >= 1 and $this->current_page <= $this->last_page) {
			return true;
		} else {
			return false;
		}
	}

	function get_last_page_all_content($page_size = 100){
		$sql = "SELECT * FROM content";
		$query = $this->db->query($sql);
		$total_num = $this->db->num_rows($query);
		$last_page = ceil($total_num / $page_size);
		if ($last_page == 0) $last_page=1;
		return $last_page;
	}

	function exec_post() {
		if (isset ($_POST['delete']) && isset ($_POST['contents'])) {
			$this->delete_contents();

		}
	}

	function delete_contents() {
		$string = implode(",", $_POST['contents']);
		$sql = "DELETE FROM content_link WHERE content_id in ($string)";
		$this->db->query($sql);
		$sql = "DELETE FROM content WHERE id in ($string)";
		$this->db->query($sql);
		$this->last_page = $this->get_last_page_all_content($this->config['deal_amount']);
	}

	function getContents($page_size = 100){
		$page=$this->current_page;
		$start = ($page -1) * $page_size;
		$sql = "SELECT * FROM content ORDER BY id DESC LIMIT $start,$page_size ";
		return $this->db->fetch_to_array($sql);
	}
}
?>
