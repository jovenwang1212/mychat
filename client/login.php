<?php 
require '../vendor/autoload.php';
try{
	$db=new core\DB;
}catch(Exception $e){
	var_dump($e);
}

$sql="select * from hx_user";
$rst=$db->fetch_first($sql);
var_dump($rst);
