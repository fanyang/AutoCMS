<?php
include_once (dirname(__FILE__) . '/ManagementControler.php');
class ConfigControler extends ManagementControler {

	public $post_success;

	public function __construct($backendName) {
		parent :: __construct($backendName);
		if (!($this->is_cookie_auth() && $this->url_ok())) {
			$this->jump("/$this->backendName");
		}
		if ($this->is_post()) {
			if ($this->exec_post()) {
				$this->post_success = 1;
			} else {
				$this->post_success = -1;
			}
		} else {
			$this->post_success = 0;
		}

		$this->make_header();
	}
	function url_ok() {
		if ($this->uri == "/$this->backendName/config") {
			return true;
		} else {
			return false;
		}
	}

	function is_post(){
		if(isset($_POST['submit'])){
			return true;
		}
		else
		{
			return false;
		}
	}

	function exec_post() {
		$id = $this->config['id'];
		$newConfig = array();
		$newConfig['auto_recommand'] = addslashes(trim($_POST['auto_recommand']));
		$newConfig['recommand_time'] = addslashes(trim($_POST['recommand_time']));
		$newConfig['new_time'] = addslashes(trim($_POST['new_time']));
		$newConfig['auto_display'] = addslashes(trim($_POST['auto_display']));
		$newConfig['auto_twitter'] = addslashes(trim($_POST['auto_twitter']));
		$newConfig['deal_amount'] = addslashes(trim($_POST['deal_amount']));
		$newConfig['domain_exp'] = addslashes(trim($_POST['domain_exp']));
		foreach ($newConfig as $key=>$value)
		{
			$sql="UPDATE config SET $key = $value where id = $id";
			$this->db->query($sql);
		}
		$this->config = $this->getConfig();
		return true;
	}

}
?>
