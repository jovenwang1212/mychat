<?php

namespace App\Repositories;
use \core\DB;

class Service {
	protected $db;

	public function __construct() {
		$this -> db = DB::getInstance();
	}

	public function save($from_name, $to_name, $time, $s_status) {
		try {
			$sql = "insert into hx_service values(null,'$from_name','$to_name',$time,$s_status)";
			$rst = $this -> db -> query($sql);
		} catch(Exception $e) {
			var_dump($e);
		}
	}
/*s_status=0且add_time
 * */
	public function selectCurrFrontWaiters($from_name) {
		try {
			$sql = "select count(*) as count from hx_service where s_status=0 and add_time<(select add_time from hx_service where from_name='$from_name')";
			$rst = $this -> db -> fetch_first($sql);
			return $rst['count'];
		} catch(Exception $e) {
			var_dump($e);
			return "";
		}
	}

	public function orSave($from_name, $to_name) {
		try {
			$sql = "select count(*) as count from hx_service where s_status=0 and from_name='$from_name' and to_name='$to_name'";
			$rst = $this -> db -> fetch_first($sql);
			if (empty($rst['count'])) {
				$time = time();
				$this -> save($from_name, $to_name, $time, 0);
				return $time;
			}else{
				return $rst['add_time'];
			}
		} catch(Exception $e) {
			var_dump($e);
		}
	}

	/*接待s_status=0且add_time最小的那个user
	 *
	 * */
	public function receive($username) {
		try {
			$sql = "select count(*) as count from hx_service where s_status=0 and from_name='$from_name' and to_name='$to_name'";
			$rst = $this -> db -> fetch_first($sql);
			if (empty($rst['count'])) {
				$time = time();
				$this -> save($from_name, $to_name, $time, 0);
			}
		} catch(Exception $e) {
			var_dump($e);
		}
	}

}
