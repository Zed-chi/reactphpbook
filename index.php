<?php
require 'vendor/autoload.php';

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;
use React\Http\Server;
include "./src/Router.php";

$loop = React\EventLoop\Factory::create();
$router = new Router();
$router->load(__DIR__ . '/routes.php');

$router->add('/', function () {
    echo 'главная страница' . PHP_EOL;
});
$router->add('/upload', function () {
    echo 'страница загрузки' . PHP_EOL;
});

$server = new Server(function (ServerRequestInterface $request) use ($router) {
    $router($request->getUri()->getPath());
    return new Response(
        200,
        ['Content-Type' => 'text/plain; charset=UTF-8'],
        'Привет, мир'
    );
}
);

$socket = new React\Socket\Server(8080, $loop);
$server->listen($socket);
echo 'Работает на ' . str_replace('tcp:', 'http:', $socket->getAddress()) . PHP_EOL;
$loop->run();
