<?php

declare(strict_types=1);

namespace Framework;

use PDO, PDOException, PDOStatement;

class Database 
{
    private PDO $connection;
    private PDOStatement $stmt;

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


    public function query(string $query, array $params = []) : Database {

        $this->stmt = $this->connection->prepare($query);

        $this->stmt->execute($params);

        return $this;

    } // End function query


    public function count() {
        return $this->stmt->fetchColumn();
    }

    public function find() {
        return $this->stmt->fetch();
    }

    public function id() {
        return $this->connection->lastInsertId();
    }

    public function findAll() {
        return $this->stmt->fetchAll();
    }

} // End class