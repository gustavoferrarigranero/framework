<?php
/**
 * Created by PhpStorm.
 * User: Gustavo
 * Date: 12/09/2015
 * Time: 09:41
 */

class Connection {

	private $link;
	public static $me;

	public function __construct() {

		$hostname = DB_HOSTNAME;
		$username = DB_USERNAME;
		$password = DB_PASSWORD;
		$database = DB_DATABASE;

		if (!$this->link = mysql_connect($hostname, $username, $password)) {
			trigger_error('Error: Could not make a database link using ' . $username . '@' . $hostname);
			exit();
		}

		if (!mysql_select_db($database, $this->link)) {
			trigger_error('Error: Could not connect to database ' . $database);
			exit();
		}

		mysql_query("SET NAMES 'utf8'", $this->link);
		mysql_query("SET CHARACTER SET utf8", $this->link);
		mysql_query("SET CHARACTER_SET_CONNECTION=utf8", $this->link);
		mysql_query("SET SQL_MODE = ''", $this->link);
	}

	public static function getDb(){
		if(!self::$me || !(self::$me instanceof Connection))
			self::$me = new Connection();

		return self::$me;

	}

	public function query($sql) {
		if ($this->link) {
			$resource = mysql_query($sql, $this->link);

			if ($resource) {
				if (is_resource($resource)) {
					$i = 0;

					$data = array();

					while ($result = mysql_fetch_assoc($resource)) {
						$data[$i] = $result;

						$i++;
					}

					mysql_free_result($resource);

					$query = new stdClass();
					$query->row = isset($data[0]) ? $data[0] : array();
					$query->rows = $data;
					$query->num_rows = $i;

					unset($data);

					return $query;
				} else {
					return true;
				}
			} else {
				$trace = debug_backtrace();

				trigger_error('Error: ' . mysql_error($this->link) . '<br />Error No: ' . mysql_errno($this->link) . '<br /> Error in: <b>' . $trace[1]['file'] . '</b> line <b>' . $trace[1]['line'] . '</b><br />' . $sql);
			}
		}
	}

	public function escape($value) {
		if ($this->link) {
			return mysql_real_escape_string($value, $this->link);
		}
	}

	public function countAffected() {
		if ($this->link) {
			return mysql_affected_rows($this->link);
		}
	}

	public function getLastId() {
		if ($this->link) {
			return mysql_insert_id($this->link);
		}
	}

	public function __destruct() {
		if ($this->link) {
			mysql_close($this->link);
		}
	}
}