<?php
	opcache_reset();
?>
	<!DOCTYPE html>
	<html>

	<head>
		<meta charset="utf-8">
		<title></title>
		<script type="text/javascript" src="jquery-1.9.1.js"></script>
		<style>
			li {
				list-style: none;
			}
			
			#friends li {
				line-height: 30px;
			}
			
			#friends li.selected {
				background-color: rgb(228, 237, 244);
			}
			
			#online_users {
				float: left;
			}
			
			#chat {
				width: 400px;
				border: blue 1px solid;
				float: left;
				margin-left: 100px;
			}
			
			#customer_service {
				float: left;
			}
			
			#chat_history {
				overflow-y: scroll;
				height: 300px;
				width: 100%;
			}
		</style>
	</head>

	<body>
		<h1>用户XXX</h1>
		<div id="online_users">
			<h2>好友</h2>
			<ul id="friends">
				<?php
					require '../vendor/autoload.php';
					$name=$_GET["username"];
					try {
						$db = core\DB::getInstance();
						$sql_upper="select * from hx_user where u_id=".$_GET['agent'];
						$sql_down="select * from hx_user where u_agent=".$_GET['uid'];
						$friend_upper=$db->fetch_first($sql_upper);
						$friends=$db->fetch_all($sql_down);
						if($friend_upper){
							$friends[]=$friend_upper;
						}
						$friends=array_reverse($friends);
						foreach($friends as $friend){
							echo "<li><a>".$friend['u_username']."</a></li>";
						}
					} catch(Exception $e) {
						var_dump($e);
					}
				?>
			</ul>
		</div>

		<div id="chat">
			<div id="chat_history"></div>
			<div id="chat_send">
				<textarea cols="63" rows="8" id="msg_content"></textarea>
				<br/>
				<span>按"Enter"发送消息</span>
			</div>
		</div>

		<div id="customer_service">
			<a href="#">与客服交谈</a>
		</div>
		<script>
			var name = getParameterByName("username");
			var ws = {};
			var msg_contentDom = document.getElementById("msg_content");
			var chat_historyDom = document.getElementById("chat_history");
			$("#friends li").on("click", function() {
				var $self = $(this);
				$self.siblings().removeClass("selected");
				$self.addClass("selected");
			});
			$("#friends li:first").trigger("click");
			ws = new WebSocket("ws://localhost:9501");
			ws.onopen = function(e) {
				console.log("websocket open");
				var msg = [
					'login', {
						'username': name,
					}
				];
				ws.send(JSON.stringify(msg));
			}
			ws.onmessage = function(e) {
				console.log(e.data);
				var msg = JSON.parse(e.data);
				var type = msg[0];
				var pDom = document.createElement("p");
				var _msg = msg[1];
				pDom.innerHTML = '<font color="blue" >' + _msg.from_name + '</font><br/>' + _msg.content;
				chat_historyDom.appendChild(pDom);
			}
			ws.onclose = function(e) {
				console.log("服务器断开.");
			};
			ws.onerror = function(e) {
				console.log("onerror");
			};
			document.onkeydown = function(e) {
				var ev = document.all ? window.event : e;
				if (ev.keyCode == 13) {
					sendMsg();
				}
			}

			function sendMsg() {
				var content = msg_contentDom.value;
				content = content.trim();
				if (!content) {
					return false;
				}
				var msg = [
					'chat', {
						'from_name': name,
						'content': content,
						'to_name': $("#friends li.selected a").text()
					}
				];
				ws.send(JSON.stringify(msg));
				msg_contentDom.value = "";
				//add chat message to history
				var pDom = document.createElement("p");
				pDom.innerHTML = '<font color="blue" >' + name + '</font><br/>' + content;
				chat_historyDom.appendChild(pDom);
				return false;
			}

			function getParameterByName(name) {
				name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
				var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
					results = regex.exec(location.search);
				return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
			}
		</script>
	</body>

	</html>