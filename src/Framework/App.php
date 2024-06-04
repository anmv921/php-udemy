<?php
declare(strict_types=1);

namespace Framework;

class App {

    private Router $router;

    public function __construct() {
        $this->router = new Router();
    }

    public function run() {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        $this->router->dispatch($path, $method);
    }

    // Add a route with the method get associated with it
    public function get(string $in_path, array $in_controller) {
        $this->router->add('GET', $in_path, $in_controller);
    }
    


}