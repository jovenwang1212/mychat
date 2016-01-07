<?php

$app->on('connect', function ($context) use ($app) {
	// extract($context);
});

$app->on('login', function ($context) use ($app) {
	extract($context);

	if ($message->username == $message->password) {
		$friends=$app->users->login($fd, $message->username);

		// 返回登录成功消息
		reply($server, $fd, 'login', [ 'friends' => $friends ]);

	} else {
		reply($server, $fd, 'login', [ 'errors' => [ '用户名和密码不正确。' ] ]);
	}
});

$app->on('close', function ($context) use ($app) {
	extract($context);

	$user = $app->users->logout($fd);
	if ($user) {
		// 广播离开聊天室通知
		broadcast($server, 'leave', [
			'fd' => $fd,
			'username' => $user['username'],
		], $fd);
	}
});

$app->on('list', [
	function ($context) use ($app) {
		extract($context);

		reply($server, $fd, 'list', $app->users->all());
	}
]);

$app->on('chat', [
	function ($context) use ($app) {
		extract($context);
	whisper($server, $message->content, $fd,$message->to_name);
		
	}
]);

$app->on('messages', [
	function ($context) use ($app) {
		extract($context);
	
		reply($server, $fd, 'messages', 
			$app->messages->orWhere([
				'fd' => $fd,
				'from_fd' => $fd
			])
		);
	}
]);
