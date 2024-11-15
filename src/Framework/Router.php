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

        $arr_new_route = [
            'path' => $path,
            'method' => strtoupper($method),
            'controller' => $controller,
            'middlewares' => []
        ];

        if (!in_array($arr_new_route, $this->routes, true)) {
            $this->routes[] = $arr_new_route;
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

            $allMiddleware = [];

            foreach ( $route["middlewares"] as $mw  ) {
                $allMiddleware[] = $mw;
            }
            foreach ( $this->middlewares as $mw  ) {
                $allMiddleware[] = $mw;
            }

            foreach ($allMiddleware as $middleware) {

                $middlewareInstance = $container ? $container->resolve($middleware) : new $middleware;
                    
                $action = fn () => $middlewareInstance->process($action);
            } // End foreach middleware

            $action();

            return;
        } // End foreach route
    } // End function dispatch

    public function addMiddleware(string $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function addRouteMiddleware(string $middleware) { 

        $lastRouteKey = array_key_last($this->routes);

        $this->routes[$lastRouteKey]['middlewares'][] = $middleware;
    }
}
