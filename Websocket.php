<?php
$serv = new swoole_websocket_server ( "127.0.0.1", 9501 );
$users = array ();

$serv->on ( 'Open', function ($server, $req) {
	echo "connection open: " . $req->fd . "\n";
} );

$serv->on ( 'Message', function ($server, $frame) {
	$msg = json_decode ( $frame->data, true );
	echo $frame->data;
	if ($msg ['cmd'] == 'register') {
		$user = array (
				"fd" => $frame->fd,
				"name" => $msg ['name'] 
		);
		$users [] = $user;
		$_msg = "Welcome <font color='blue'>" . $msg ["name"] . "</font> join chat room!";
	} else {
		$_msg = "<font color='blue'>" . $msg ["from"] . "</font>  <br/>";
		$_msg .= $msg ["data"];
	}
	var_dump($users);
	foreach ( $users as $user ) {
		$server->push ( $user["fd"], json_encode ( [ 
				$_msg 
		] ) );
	}
} );

$serv->on ( 'Close', function ($server, $fd) {
	echo "connection close: " . $fd . "\n";
} );

$serv->start ();