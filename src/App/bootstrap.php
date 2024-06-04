<?php

declare(strict_types=1);

require __DIR__ . "/../../vendor/autoload.php";

use Framework\App;
use App\Controllers\HomeController;

$app = new App();

// HomeController::class returns the name of the class in a string with full path
$app->get( '/', [HomeController::class, 'home'] );


//dd($app);

return $app;