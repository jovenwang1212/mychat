<?php

namespace App\Repositories;
use \core\DB;

class MessageRepository {
	protected $db;

	public function __construct() {
		$this -> db =  DB::getInstance();
	}

	public function save($content,$from_name,$to_name,$type,$status) {
		try {
			$time=time();
			$sql = "insert into hx_message values(null,'$content','$from_name','$to_name','$type',$time,$status)";
			$rst = $this -> db -> query($sql);
		} catch(Exception $e) {
			var_dump($e);
		}
	}
	
	private function updateStatus($status) {
		try {
			$sql = "update hx_message set status=$status";
			$rst = $this -> db -> query($sql);
		} catch(Exception $e) {
			var_dump($e);
		}
	}
	public function getUnReadContent($from_name,$to_name) {
		try {
			$sql = "select content from hx_message where from_name='$from_name' and to_name='$to_name' and status=0";
			$rst = $this -> db -> fetch_all($sql);
			$this->updateStatus(1);
			return json_encode($rst);
		} catch(Exception $e) {
			var_dump($e);
			return "";
		}
	}
}


