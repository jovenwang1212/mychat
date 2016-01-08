<?php

function sendMessage($server, $type, $msg)
{
	global $app;

	$user = $app->users->getByUsername($msg->to_name);
	$read_time=0;
	if($user['fd']){
		$read_time=time();
	}
	// 记录消息
	$app->messages->save($msg->content,$msg->from_name,$msg->to_name,$type,$read_time); 
	
	if($user['fd']){
		$server->push($user['fd'], json_encode([
			$type,
			[
				'from_name' => $msg->from_name,
				'content' => $msg->content
			]
		]));
	}
}

function loadHistory($server,$msg){
	global $app;
	$user = $app->users->getByUsername($msg->to_name);
	// 记录消息
	$historyContent=$app->messages->getHistoryContent($msg->from_name,$msg->to_name,$user["login_time"]); 
	
	
	if($user['fd']){
		$server->push($user['fd'], json_encode([
			"load_history",$historyContent
		]));
	}
}

function service($server,$type,$msg){
	global $app;

	$user = $app->users->getByUsername($msg->username);
	// 记录消息
	$app->service->orSave($msg->username,""); 
	$count=$app->service->selectCurrFrontWaiters($msg->username);
	
	if($user['fd']){
		$server->push($user['fd'], json_encode([
			$type,
			[
				'from_name' => "客服服务",
				'content' => "当前等待用户".$count.'位'
			]
		]));
	}
}
function receive($server,$type,$msg){
	global $app;

	$user = $app->users->getByUsername($msg->username);
	// 记录消息
	$app->service->receive($msg->username); 
	$count=$app->service->selectCurrWaiters();
	
	if($user['fd']){
		$server->push($user['fd'], json_encode([
			$type,
			[
				'from_name' => "客服服务",
				'content' => "当前等待用户".$count.'位'
			]
		]));
	}
}
