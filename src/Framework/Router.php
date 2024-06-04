<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private array $routes = [];

    public function add( string $in_method, string $in_path, array $in_controller ) {

        $in_path = $this->normalizePath($in_path);

        $arr_newRoute = [
            'path' => $in_path,
            'method' => strtoupper($in_method),
            'controller' => $in_controller
        ];

        if ( ! in_array($arr_newRoute, $this->routes, true) ) {
            $this->routes[] = $arr_newRoute;
        }
    }

    private function normalizePath(string $io_path) {

        $io_path = trim($io_path, "/");

        $io_path = "/{$io_path}/";

        $io_path = preg_replace("#[/]{2,}#", "/", $io_path);

        return $io_path;
    }

    public function dispatch(string $in_path, string $in_method) {
        $in_path = $this->normalizePath($in_path);
        $in_method = strtoupper($in_method);

        //echo $in_path . $in_method;

        foreach($this->routes as $route) {
            if( 
                ! preg_match( "#^{$route['path']}$#", $in_path ) || $route['method'] !== $in_method
            ) {
                continue;
            }

            // echo 'route found';
            [$class, $function] = $route['controller'];

            $controllerInstance = new $class;

            // um... function is a string, but php allows us to use strings to call method names if the method exists
            $controllerInstance->{$function}();
        }
    }
}