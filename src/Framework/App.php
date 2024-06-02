<?php
declare(strict_types=1);

namespace Framework;

class App {

    private Router $router;

    public function __construct() {
        $this->router = new Router();
    }

    public function run() {
        echo "Application is running";
    }

    // Add a route with the method get associated with it
    // Doesnt seem like a good idea but teacher said so
    public function get(string $in_path) {
        $this->router->add('GET', $in_path);
    }
}