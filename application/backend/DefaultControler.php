<?php
include_once (dirname(__FILE__) . '/ManagementControler.php');
class DefaultControler extends ManagementControler{

	public function __construct($backendName) {
		parent :: __construct($backendName);
		if (!$this->url_ok()){$this->jump("/");}

	}
	function url_ok() {
		if ($this->uri == "/$this->backendName" | $this->uri == "/$this->backendName/login" | $this->uri == "/$this->backendName/logout") {
			return true;
		} else {
			return false;
		}
	}

	function is_login() {
		if (!(isset ($_POST['submit']) && isset ($_POST['password'])
		&& isset ($_POST['check_pic'])&& isset($_SESSION['check_pic']))) {
			return false;
		} else {
			return true;
		}
	}

	function exec_login() {
		$password = md5(sha1($_POST['password']));
		$check_pic = $_POST['check_pic'];
		if ($check_pic != $_SESSION['check_pic']) {
			return false;
		}

		if ($password != $this->config['password']) {
			return false;
		}

		setcookie('shell', md5(sha1($password)), time() + 86400, "/");
		return true;


	}

	function is_logout() {
		if ($this->uri == "/$this->backendName/logout") {
			return true;
		} else {
			return false;
		}
	}

	function exec_logout() {
		setcookie("shell", "", time() - 3600,"/");
	}


}
?>
