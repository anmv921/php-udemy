<?php

include __DIR__ . '/src/Framework/Database.php';

use Framework\Database;

$db = new Database(
    in_driver: 'mysql', 
    in_config: [
            'host' => 'localhost',
            'port' => 3306,
            'dbname' => 'phpiggy',
            "charset" => 'utf8mb4'
    ],
    in_username: 'root',
    in_password: ''
);

echo "Connected to database";

if ($db) {
    $query = $db->connection->prepare("SELECT * FROM products");
    $query->execute();
    $result = $query->fetchAll();
    print_r($result);
}
