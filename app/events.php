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

$app->on('chat', [
	function ($context) use ($app) {
		extract($context);
		sendMessage($server, 'chat',$message);
	}
]);

$app->on('load_history', [
	function ($context) use ($app) {
		extract($context);
		loadHistory($server,$message);
	}
]);
$app->on('service', [
	function ($context) use ($app) {
		extract($context);
		service($server,"service",$message);
	}
]);
$app->on('receive', [
	function ($context) use ($app) {
		extract($context);
		receive($server,"receive",$message);
	}
]);

