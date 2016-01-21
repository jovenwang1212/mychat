<?php 
	$redis = new \Redis;
	$redis -> connect('localhost','6379', 0.0);
	$arr=$redis->lRange("queue_service_req",0,-1);
	var_dump($arr);
	
	
	$arr=$redis->lRange("queue_service_ing",0,-1);
	var_dump($arr);
