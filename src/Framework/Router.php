<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private array $routes = [];
    private array $middlewares = [];

    public function add(string $method, string $path, array $controller)
    {

        $path = $this->normalizePath($path);

        $arr_newRoute = [
            'path' => $path,
            'method' => strtoupper($method),
            'controller' => $controller
        ];

        if (!array($arr_newRoute, $this->routes, true)) {
            $this->routes[] = $arr_newRoute;
        }
    }

    private function normalizePath(string $path)
    {

        $path = trim($path, "/");

        $path = "/{$path}/";

        $path = preg_replace("#[/]{2,}#", "/", $path);

        return $path;
    }

    public function dispatch(string $path, string $method, Container $container = null)
    {
        $path = $this->normalizePath($path);
        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            if (
                !preg_match("#^{$route['path']}$#", $path) ||
                $route['method'] !== $method
            ) {
                continue;
            }

            [$class, $function] = $route['controller'];

            $controllerInstance = $container ?
                $container->resolve($class) :
                new $class;

            // The function is a string, but php allows us to use strings
            // to call method names if the method exists
            $action = fn () => $controllerInstance->{$function}();

            foreach ($this->middlewares as $middleware) {

                $middlewareInstance =
                    $container ?
                    $container->resolve($middleware)
                    : new $middleware;

                $action = fn () => $middlewareInstance->process($action);
            }

            $action();

            return;
        }
    }

    public function addMiddleware(string $middleware)
    {
        $this->middlewares[] = $middleware;
    }
}
