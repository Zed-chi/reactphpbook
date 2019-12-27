<?php
use Psr\Http\Message\ServerRequestInterface;

class Router
{
    private $routes = [];

    public function __invoke($path, ServerRequestInterface $request)
    {
        if (!isset($this->routes[$path])) {
            echo "Нет обработчика запроса для $path\n";
            return;
        }
        echo "Запрос: $path\n";
        $handler = $this->routes[$path];
        $handler($request);
    }

    public function add($path, callable $handler)
    {
        $this->routes[$path] = $handler;
    }

    public function load($filename)
    {
        $routes = require $filename;
        foreach ($routes as $path => $handler) {
            $this->add($path, $handler);
        }
    }

}
