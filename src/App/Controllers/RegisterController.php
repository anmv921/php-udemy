<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;

class RegisterController
{
    public function __construct(
        private TemplateEngine $registerView
    ) {
    }

    public function registerPage()
    {
        $this->registerView->render(
            "/registerTemplate.php",
            [
                'title' => 'Register'
            ]
        );
    }
}
