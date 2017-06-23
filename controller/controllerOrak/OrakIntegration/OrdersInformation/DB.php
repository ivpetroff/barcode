<?php
define('MYSQL_HOST', "localhost");
define('MYSQL_USER', "root");
define('MYSQL_PASS', "");
define('MYSQL_DB', "ImperoMercari");

class DB {
	private $connection = null;
	static private $_connection = null;

	public function __construct() {
		if(is_null(self::$_connection)) {
			self::$_connection = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
			self::$_connection->set_charset("UTF-8");
			self::$_connection->query("set names utf8");
		}
		$this->connection = self::$_connection;
	}
	
	public function real_escape_string($sStr) {
		return $this->connection->real_escape_string($sStr);
	}

	public function Query($sQuery) {
		return $this->connection->query($sQuery);
	}

    public function InsertID() {
        return $this->connection->insert_id;
    }

	public function Close() {
		$this->connection->close();
		self::$_connection = null;
	}
}