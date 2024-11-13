<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;
use App\Controllers\{
    HomeController,
    AboutController,
    AuthController
};

function registerRoutes(App $app)
{
    // HomeController::class returns 
    // the name of the class in a string with full path
    // home and aboutPage is the function 
    // in HomeController and AboutController that points
    // to the template

    $app->get('/', [HomeController::class, 'home']);


    $app->get('/about', [AboutController::class, 'about']);

    $app->get('/register', [AuthController::class, 'registerView']);
    $app->post('/register', [AuthController::class, 'register']);
}
