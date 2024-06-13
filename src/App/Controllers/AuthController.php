<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;

class AuthController
{
    public function __construct(
        private TemplateEngine $registerView
    ) {
    }

    public function registerView()
    {
        $this->registerView->render(
            "/registerTemplate.php",
            [
                'title' => 'Register'
            ]
        );
    }

    public function register()
    {
        dd($_POST);
    }
}
