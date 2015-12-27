<?php

require __DIR__ . '/vendor/autoload.php';

$app = new Libs\App;
use core\Config;


$app->bind('users', new App\Repositories\UserRepository);
$app->bind('messages', new App\Repositories\MessageRepository);

require __DIR__ . '/app/events.php';

Libs\Server\ServerFactory::createWebSocket($app)
->configure(Config::get("socket"))
->listen(9501);

echo "server running...\n";

