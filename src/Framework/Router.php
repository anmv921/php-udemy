<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private array $routes = [];

    public function add(string $in_method, string $in_path) {

        $in_path = $this->normalizePath($in_path);

        $arr_newRoute = [
            'path' => $in_path,
            'method' => strtoupper($in_method)
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
}