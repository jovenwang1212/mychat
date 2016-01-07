<?php

namespace App\Repositories;

class UserRepository {
	protected $db;

	public function __construct() {
		$this->db = new core\DB;
	}

	public function login(uid) {

		try {
			$sql="update hx_user set status=1 where u_id=".uid;
			$rst=$this->db.fetch_first($sql);
			var_dump($rst);
		} catch(Exception $e) {
			var_dump($e);
		}
	}

}
