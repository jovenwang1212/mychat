<?php

namespace App\Repositories;
use \core\DB;
use \core\Redis;

class Service {
	protected $db;
	protected $redis;
	public static $qsr='queue_service_req';
	public static $qsi='queue_service_ing';
	

	public function __construct() {
		$this -> db = DB::getInstance();
		$this->redis= new Redis();
	}
	/*
	 * 如果 请求队列和接待队列里面都没有，就新增
	 */
	public function rPush($from_name){
		if($this->redis->index(self::$qsr,$from_name)===false&&
			$this->redis->index(self::$qsi,$from_name)===false){
				$this->redis->push(self::$qsr,$from_name);
			}
	}
	/*
	 * 把queue_service_req的会员pop出来from_name,并放到ing queue里边
	 */
	public function migrate(){
		$from_name = $this->redis->pop(self::$qsr);
		$this->redis->push(self::$qsi,$from_name);
		return $from_name;
	}
	/*
	 * 当前会员排在第几位
	 */
	public function index($from_name){
		return $this->redis->index(self::$qsr,$from_name);
	}
	
	public function save($from_name, $to_name) {
		try {
			$time = time();
			$sql = "insert into hx_service values(null,'$from_name','$to_name',$time,'')";
			$rst = $this -> db -> query($sql);
		} catch(Exception $e) {
			var_dump($e);
		}
	}
}
