<?php
include_once (dirname(__FILE__) . '/ManagementControler.php');
class ContentNewControler extends ManagementControler{

	public function __construct($backendName) {
		parent :: __construct($backendName);
		if (!($this->is_cookie_auth() && $this->url_ok())) {$this->jump("/$this->backendName");}
		$id = $this->insert_new();
		$this->jump("/$this->backendName/content/".$id);
	}
	function url_ok() {
		if ($this->uri == "/$this->backendName/new") {
			return true;
		} else {
			return false;
		}
	}

	function insert_new() {
		$content['source']=$_SERVER['REMOTE_ADDR'];
		$content['title'] = "New Title";
		$content['pic'] = "#";
		$content['link'] = "";
		$content['body'] = "";
		$content['display'] = 0;

		return $this->db->insert($content,"content");
	}

}
?>
