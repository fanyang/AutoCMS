<?php
include_once (dirname(__FILE__) . '/ManagementControler.php');
class RecommandControler extends ManagementControler {

	public $recommands;
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
		$this->recommands = $this->getRecommandContents();
	}
	function url_ok() {
		if ($this->uri == "/$this->backendName/recommand") {
			return true;
		} else {
			return false;
		}
	}

	function getRecommandContents() {
		$sql = "SELECT * FROM recommand ORDER BY id ASC";
		return $this->db->fetch_to_array($sql);
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
		for ($i=1;$i<=5;$i++){
			$id = $i;
			$content_id = $_POST[$i."_content_id"];
			$content_id = $this->form_filter_simpletext($content_id);
			$content_id = $this->form_filter_sql($content_id);
			$sql="UPDATE recommand SET content_id = '$content_id' where id = '$id'";
			$this->db->query($sql);
			$description = $_POST[$i."_description"];
			$description = $this->form_filter_sql($description);
			$sql="UPDATE recommand SET title = '$description' where id = '$id'";
			$this->db->query($sql);
		}
		return true;
	}

}
?>
