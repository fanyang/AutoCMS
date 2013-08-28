<?php
class mysql {

	protected $host;
	protected $name;
	protected $pass;
	protected $database;
	protected $charset;

	function __construct($host, $name, $pass, $database, $charset) {
		$this->host = $host;
		$this->name = $name;
		$this->pass = $pass;
		$this->database = $database;
		$this->charset = $charset;
		$this->connect();

	}

	function connect() {
		$link = mysql_connect($this->host, $this->name, $this->pass) or die($this->error());
		mysql_select_db($this->database, $link) or die("CANNOT FIND database: " . $this->database);
		mysql_query("SET NAMES $this->charset");
	}

	function query($sql) {
		if (!($query = mysql_query($sql))) {
			$this->show('QUERY FAIL: ', $sql);
			exit;
		}
		return $query;
	}

	function fetch_array($query) {
		return mysql_fetch_array($query);
	}

	function fetch_to_array($sql) {
		$query = $this->query($sql);
		$result = array ();
		while ($row = $this->fetch_array($query)) {
			$result[] = $row;
		}
		return $result;
	}

	function fetch_row($query) {
		return mysql_fetch_row($query);
	}

	function fetch_to_row($sql) {
		$query = $this->query($sql);
		$result = array ();
		while ($row = $this->fetch_row($query)) {
			$result[] = $row[0];
		}
		return $result;
	}

	function num_rows($query) {
		return mysql_num_rows($query);
	}

	function show($message = '', $sql = '') {
		if (!$sql)
			echo $message;
		else
			echo $message . $sql;
	}

	function affected_rows() {
		return mysql_affected_rows();
	}

	function result($query, $row) {
		return mysql_result($query, $row);
	}

	function num_fields($query) {
		return mysql_num_fields($query);
	}

	function free_result($query) {
		return mysql_free_result($query);
	}

	function insert_id() {
		return mysql_insert_id();
	}

	function version() {
		return mysql_get_server_info();
	}

	function close() {
		return mysql_close();
	}

	function error() {
		return mysql_error();
	}

	function insert($data, $tableName) {
		$key = array_keys($data);
		$data = array_map("addslashes", $data);
		$key = array_map("addslashes", $key);
		$keyString = implode(",", $key);
		$dataString = implode("','", $data);
		$sql = "insert into $tableName ($keyString) values ('$dataString')";
		if ($this->query($sql)) {
			return $this->insert_id();
		} else {
			return false;
		}
	}

}
?>
