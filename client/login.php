<?php
opcache_reset();

require '../vendor/autoload.php';
$username = $_REQUEST["username"];
$password = md5($_REQUEST["password"]);
if(empty($username)){
	$username="sam";
}
if(empty($_REQUEST["password"])){
	$password=md5("sam");
}
try {
	$db = new core\DB;
	$sql = "select * from hx_user where u_username='" . $username . "' and u_password='" . $password . "'";
	$rst = $db -> fetch_first($sql);
	if ($rst) {
		session_start();
		$user = array("uid" => $rst["u_id"], "username" => $rst["u_username"], "agent" => $rst["u_agent"]);
		$_SESSION['user']=$user;
		
		$status_sql="update hx_user set status=1 where u_id=".$rst["u_id"];
		$status_rst=$db->query($status_sql);
		var_dump($status_rst);
		$query = http_build_query($user);
		header("Location:user.php" . "?" . $query);
	} else {
		echo "<font color='red'>用户名密码不正确</font><p><a href='index.html'>返回登录页面</a></p>";
	}
} catch(Exception $e) {
	var_dump($e);
}
