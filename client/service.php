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
		<h1>客服在线</h1>
		<div id="online_users">
			<h2>当前接待用户</h2>
			<ul id="friends">
				<li><a>接待新会员</a></li>
				<?php
					require '../vendor/autoload.php';
					$name=$_GET["username"];
					try {
						$db = core\DB::getInstance();
						$sql="select from_name from hx_service where to_name='".$_GET['username']."'";
						$receiveUserNames=$db->fetch_all($sql);
						
						foreach($receiveUserNames as $receiveUser){
							$name=$receiveUser["from_name"];
							echo "<li><a>".$name."</a></li>";
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
		<div id="userinfo">
			用户详细信息
		</div>

		<script>
			var name = getParameterByName("username");
			var ws = {};
			var msg_contentDom = document.getElementById("msg_content");
			var chat_historyDom = document.getElementById("chat_history");
			
			ws = new WebSocket("ws://localhost:9501");
			ws.onopen = function(e) {
				console.log("websocket open");
				var msg = [
					'login', {
						'username': name,
					}
				];
				ws.send(JSON.stringify(msg));
				//$("#friends li:first").trigger("click");
			}
			ws.onmessage = function(e) {
				console.log(e.data);
				var msg = JSON.parse(e.data);
				var type = msg[0];
				
				var _msg = msg[1];
				
				if(type=="chat"){
					var current_chater=$("#friends li.selected a").text();
					if(_msg.from_name==current_chater){
						var pDom = document.createElement("p");
						pDom.innerHTML = '<font color="blue" >' + _msg.from_name + '</font><br/>' + _msg.content;
						chat_historyDom.appendChild(pDom);
					}
					
				}else if(type=="load_history"){
					console.log(_msg);
					var fragment = document.createDocumentFragment();
					for(var i=0;i<_msg.length;i++){
						var history=_msg[i];
						var pDom = document.createElement("p");
						pDom.innerHTML='<font color="blue" >' + history.from_name + '</font><br/>' + history.content;
						fragment.appendChild(pDom);
					}
					chat_historyDom.appendChild(fragment);
				}else if(type=="receive"){
					var liDom = document.createElement("li");
					liDom.innerHTML = "<a>"+_msg['to_name']+"</a>";
					document.getElementById("friends").appendChild(liDom);
					$(liDom).siblings().removeClass("selected");
					$(liDom).addClass("selected");
					chat_history.innerHTML = "";
					var pDom = document.createElement("p");
					pDom.innerHTML = '<font color="blue" >' + _msg.from_name + '</font><br/>' + _msg.content;
					chat_historyDom.appendChild(pDom);
				}else if(type=="system"){
					var pDom = document.createElement("p");
					pDom.innerHTML = '<font color="blue" >' + _msg.from_name + '</font><br/>' + _msg.content;
					chat_historyDom.appendChild(pDom);
				}
				
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
			
			$("#friends li").on("click", function() {
				var $self = $(this);
				$self.siblings().removeClass("selected");
				$self.addClass("selected");
				chat_history.innerHTML = "";
				if($("#friends li.selected a").text()=="接待新会员"){
					var msg = [
					'receive', {
						'username': name,
					}
					];
				}else{
					var msg = [
					'load_history', {
						'from_name': $("#friends li.selected a").text(),
						'to_name': name
					}
					];
				}
				
				ws.send(JSON.stringify(msg));
			});
			

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