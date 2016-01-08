<?php

namespace App\Repositories;
use \core\DB;

class Service {
	protected $db;

	public function __construct() {
		$this -> db =  DB::getInstance();
	}

	public function save($from_name,$to_name,$time,$s_status) {
		try {
			$time=time();
			$sql = "insert into hx_service values(null,'$from_name','$to_name',$time,$s_status)";
			$rst = $this -> db -> query($sql);
		} catch(Exception $e) {
			var_dump($e);
		}
	}

	
	public function selectCurrWaiters() {
		try {
			$sql="select (count(*)-1) as count from hx_service where s_status=0";
			$rst = $this -> db -> fetch_first($sql);
			return $rst['count'];
		} catch(Exception $e) {
			var_dump($e);
			return "";
		}
	}
	
	public function orSave($from_name,$to_name) {
		try {
			$sql="select count(*) as count from hx_service where s_status=0 and from_name='$from_name' and to_name='$to_name'";
			$rst = $this -> db -> fetch_first($sql);
			if(empty($rst['count'])){
				$time=time();
				$this->save($from_name, $to_name, $time, 0);
			}
		} catch(Exception $e) {
			var_dump($e);
		}
	}
	
}


