<?php

namespace App\Repositories;

class UserRepository {
	protected $db;

	public function __construct() {
		$this -> db = new \core\DB;
	}

	public function login($fd, $username) {
		try {
			$sql = "update hx_user set fd=$fd where u_username='$username'";
			echo $sql;
			$rst = $this -> db -> query($sql);
		} catch(Exception $e) {
			var_dump($e);
		}
	}

	public function logout($fd) {
		try {
			$sql = "update hx_user set fd=0 where fd=$fd";
			$rst = $this -> db -> query($sql);
		} catch(Exception $e) {
			var_dump($e);
		}
	}

}
