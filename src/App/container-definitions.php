<?php

declare(strict_types=1);

use Framework\{TemplateEngine, Database, Container};
use App\Config\Paths;
use App\Services\{
    TransactionService, 
    ValidatorService, 
    UserService};

// Factory function
// Where is my mind?
return [
    TemplateEngine::class => fn () => new TemplateEngine(Paths::VIEW),
    ValidatorService::class => fn () => new ValidatorService(),
    Database::class => fn() => new Database(
        in_driver: $_ENV["DB_DRIVER"], 
        in_config: [
                'host' => $_ENV["DB_HOST"],
                'port' =>$_ENV["DB_PORT"],
                'dbname' => $_ENV["DB_NAME"],
                "charset" => $_ENV["DB_CHARSET"]
        ],
        in_username: $_ENV["DB_USER"],
        in_password: $_ENV["DB_PASS"]),
    UserService::class => function(Container $container) {
        $db = $container->get(Database::class);

        return new UserService($db);
    },
    TransactionService::class => function(Container $container) {
        $db = $container->get(Database::class);

        return new TransactionService($db);
    }
];
