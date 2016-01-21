<?php 
require __DIR__ . '/core/DB.PHP';
require __DIR__ . '/core/Config.php';
use core\DB;
//	$redis = new \Redis;
//	$redis -> connect('localhost','6379', 0.0);
//	$arr=$redis->lRange("queue_service_req",0,-1);
//	var_dump($arr);
//	
//	
//	$arr=$redis->lRange("queue_service_ing",0,-1);
//	var_dump($arr);
//
//	
//	$redis->delete("key1");
//	$redis->lPush('key1', 'sam');
//	$redis->lPush('key1', 'luke');
//	$redis->lPush('key1', 'boss');
//	$redis->lPush('key1', 'alex');
//
//var_dump($redis->lRange('key1', 0, -1)); /* array('A', 'A', 'C', 'B', 'A') */
//$redis->lRem('key1', 'luke', 1); /* 2 */
//var_dump($redis->lRange('key1', 0, -1)); /* array('C', 'B', 'A') */
//$redis->lRem('queue_service_ing','sam',1);

 $db=DB::getInstance();
 $from_name='sam';
 $sql="select fd from hx_user as u,(select to_name from hx_service where from_name='$from_name' order by add_time desc) as s where u.u_username=s.to_name";
// echo $sql."<br>";
 $result = $db->fetch_first($sql);
// $rst=$result->fetch_array(MYSQLI_ASSOC);
 var_dump($result['fd']); 

