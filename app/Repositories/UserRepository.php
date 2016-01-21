<?php

namespace App\Repositories;

class UserRepository {
	protected $db;

	public function __construct() {
		$this -> db =  \core\DB::getInstance();
	}

	public function login($fd, $username) {
		try {
			$time=time();
			$sql = "update hx_user set fd=$fd,login_time= $time where u_username='$username'";
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

	public function getByUsername($username) {
		try {
			$sql = "select * from hx_user where u_username='$username'";
			$rst = $this -> db -> fetch_first($sql);
			return $rst;
		} catch(Exception $e) {
			var_dump($e);
		}
	}
	
	public function getByFd($fd) {
		try {
			$sql = "select * from hx_user where fd=$fd";
			$rst = $this -> db -> fetch_first($sql);
			return $rst;
		} catch(Exception $e) {
			var_dump($e);
		}
	}

}
