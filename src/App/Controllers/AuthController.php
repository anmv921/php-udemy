<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;
use App\Services\ValidatorService;

class AuthController
{
    public function __construct(
        private TemplateEngine $registerView,
        private ValidatorService $validatorService
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
        $this->validatorService->validateRegister($_POST);
    }
}
