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

/**
 * 私聊
 * 
 * @param  swoole_server  $server  
 * @param  array|mixed    $content 消息内容
 * @param  int            $from_fd 发送人
 * @param  int            $to_fd   接收人
 */
function whisper($server, $content, $from_fd, $to_fd)
{
	sendMessage($server, 'chat', $content, $from_fd, $to_fd);
}

/**
 * 群聊
 * 
 * @param  swoole_server $server  
 * @param  array|mixed   $content 消息内容
 * @param  int           $from_fd 发送人
 * @param  string        $channel 频道，如果没有指定，默认为公共频道
 */
function mass($server, $content, $from_fd, $channel = 'public')
{
	global $app;

	foreach ($app->users->online() as $user) {
		$to_fd = $user['fd'];

		if ($from_fd === $to_fd) {
			continue;
		}

		if (is_null($channel) || $user['channel'] !== $channel) {
			continue;
		}

		sendMessage($server, 'chat', $content, $from_fd, $to_fd);
	}
}

function reply($server, $to_fd, $type, $message)
{
	$server->push($to_fd, json_encode([ $type, $message ]));
	
}

function broadcast($server, $type, $message, $except_fd, $channel = 'public')
{
	global $app;

	foreach ($app->users->online() as $user) {
		$to_fd = $user['fd'];

		if (is_array($except_fd) && in_array($to_fd, $except_fd) 
			|| $except_fd === $to_fd) {
			continue;
		}

		if (is_null($channel) || $user['channel'] !== $channel) {
			continue;
		}

		reply($server, $to_fd, $type, $message);
	}
}
