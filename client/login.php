<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require '../vendor/autoload.php';
$username=$_REQUEST["username"];
$password=md5($_REQUEST["password"]);
try{
	$db=new core\DB;
	$sql="select * from hx_user where u_username='".$username."' and u_password='".$password."'";
	$rst=$db->fetch_first($sql);
	if($rst){
		session_start();
		$user=array(
			"uid"=>$rst["u_id"],
			"username"=>$rst["u_username"],
			"agent"=>$rst["u_agent"]
		);
		$_SESSION["user"]=$user;
		
		$sql_upper="select * from hx_user where u_id=".$user['agent'];
			$sql_down="select * from hx_user where u_agent=".$user['uid'];
			$friend_upper=$db->fetch_first($sql_upper);
			$friends=$db->fetch_all($sql_down);
			if($friend_upper){
				$friends[]=$friend_upper;
			}
			$friends=array_reverse($friends);
			$_SESSION["friends"]=$friends;
			header("Location:user.php");
	}else{
		echo "<font color='red'>用户名密码不正确</font><p><a href='index.html'>返回登录页面</a></p>";
	}
}catch(Exception $e){
	var_dump($e);
}