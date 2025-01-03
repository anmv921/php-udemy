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

        $this->userService->create($_POST);

        redirectTo("/");
    }

    public function loginView()
    {
        $this->registerView->render("/login.php", ['title' => 'Login']);
    }

    public function login() {

        $this->validatorService->validateLogin($_POST);

        $this->userService->login($_POST);

        redirectTo("/");
    }

    public function logout() {

        $this->userService->logout();

        redirectTo("/login");
    }
}
