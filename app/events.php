<?php

$app->on('connect', function ($context) use ($app) {
	// extract($context);
});

$app->on('login', function ($context) use ($app) {
	extract($context);
	echo "$fd ".$message->username;
	$app->users->login($fd, $message->username);
});

$app->on('close', function ($context) use ($app) {
	extract($context);

	$user = $app->users->logout($fd);
	
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
