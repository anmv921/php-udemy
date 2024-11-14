<?php

declare(strict_types=1);

namespace Framework;

use PDO, PDOException;

class Database 
{
    public PDO $connection;

    public function __construct(string $in_driver, array $in_config, string $in_username, string $in_password )
    {
        $config = http_build_query(
            data: $in_config, 
            arg_separator: ';'
        );

        $dsn = "{$in_driver}:{$config}";

        $db = null;

        try {
            $this->connection = new PDO(dsn: $dsn, username: $in_username, password: $in_password,
            options: [ 
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_STRINGIFY_FETCHES => false 
            ]);
        } catch(PDOException $e) {
            die("Unable to connect to database");
        }
    } // End function __construct
} // End class