<?php

namespace App\Repositories;
use \core\DB;

class MessageRepository {
	protected $db;

	public function __construct() {
		$this -> db =  DB::getInstance();
	}

	public function save($content,$from_name,$to_name,$type,$read_time) {
		try {
			$time=time();
			$sql = "insert into hx_message values(null,'$content','$from_name','$to_name','$type',$time,$read_time)";
			$rst = $this -> db -> query($sql);
		} catch(Exception $e) {
			var_dump($e);
		}
	}
	
	private function updateReadTime($read_time) {
		try {
			$sql = "update hx_message set read_time=$read_time";
			$rst = $this -> db -> query($sql);
		} catch(Exception $e) {
			var_dump($e);
		}
	}
	public function getHistoryContent($from_name,$to_name,$login_time) {
		try {
			$sql = "select from_name,content from hx_message where ((from_name='$from_name' and to_name='$to_name') or (to_name='$from_name' and from_name='$to_name')) and read_time>=$login_time";
			echo $sql;
			$rst = $this -> db -> fetch_all($sql);
			$this->updateReadTime($login_time);
			return $rst;
		} catch(Exception $e) {
			var_dump($e);
			return "";
		}
	}
}


