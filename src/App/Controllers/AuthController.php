<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;
use App\Services\{ValidatorService, UserService};

class AuthController
{
    public function __construct(
        private TemplateEngine $registerView,
        private ValidatorService $validatorService,
        private UserService $userService
    ) {}

    public function registerView()
    {
        $this->registerView->render("/registerTemplate.php", ['title' => 'Register']);
    }

    public function register()
    {
        $this->validatorService->validateRegister($_POST);

        $this->userService->isEmailTaken($_POST['email']);

        $this->userService->insertUser($_POST);

        redirectTo("/");
    }
}
