<?php


declare(strict_types=1);

require __DIR__ . "/../../vendor/autoload.php";

use Framework\App;
use App\Config\Paths;

// registerRoutes is inside Routes.php
// Composer.php does autoloading of functions
// need to run composer dump-autoload when adding autoload
use function App\Config\{registerRoutes, registerMiddleware};

// use App\Controllers\{AboutController};
// $aboutController = new AboutController();
// $app->get('/about', [AboutController::class, 'about']);

$app = new App(Paths::SOURCE . "app/container-definitions.php");

registerRoutes($app);


registerMiddleware($app);

return $app;
