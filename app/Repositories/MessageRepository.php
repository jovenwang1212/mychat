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
}


