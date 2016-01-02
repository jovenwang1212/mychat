<!DOCTYPE html>
	<html>

	<head>
		<meta charset="utf-8">
		<title></title>
		<script type="text/javascript" src="jquery-1.9.1.js"></script>
		<style>
			li{
				list-style: none;
			}
		</style>
	</head>

	<body>
			<h1>用户XXX</h1>
			<div id="online_users">
				<h2>好友</h2>
				<ul id="friends">
					<?php
						session_start();
						$friends=$_SESSION["friends"];
						foreach($friends as $friend){
							echo "<li><a href='#'>".$friend['u_username']."</a></li>";
						}
					?>
				</ul>
			</div>
		
			<div id="customer_service">
				<a href="#">与客服交谈</a>
			</div>
			<script>
				$("#friends li a").click(function(){
					window.open("chat.html");
				});
			</script>
	</body>

	</html>