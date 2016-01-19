<?php
namespace core;

class Redis {
	/**
	 * @var \redis
	 */
	protected $redis;
	
	static $prefix = "_";

	function __construct($host = '127.0.0.1', $port = 6379, $timeout = 0.0) {
		$redis = new \Redis;
		$redis -> connect($host, $port, $timeout);
		$this -> redis = $redis;
	}
	
	public function push($queue,$value){
		$this->redis->rPush($queue,$value);
	}
	public function pop($queue){
		return $this->redis->lPop($queue);
	}
	
	public function len($queue){
		return $this->redis->lSize($queue);
	}
	 
	 /*
	 * 判断队列中有没有某无素
	 */
	public function contains($queue,$value){
		$arr=$this->_list($queue);
		if(in_array($value,$arr)){
			return true;
		}
		return false;
	}
	/*
	 *拿到队列所的有无素
	 */
	private function _list($queue){
		return $this->redis->lRange($queue,0,-1);
	}
}
