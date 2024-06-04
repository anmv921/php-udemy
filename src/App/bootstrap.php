<?php

declare(strict_types=1);

require __DIR__ . "/../../vendor/autoload.php";

use Framework\App;
use App\Controllers\HomeController;
use App\Controllers\AboutController;

$app = new App();

// HomeController::class returns 
// the name of the class in a string with full path
$app->get('/', [HomeController::class, 'home']);
// aboutPage is the function in AboutController that points
// to the template
$app->get('/about', [AboutController::class, 'aboutPage']);

//dd($app);

return $app;
