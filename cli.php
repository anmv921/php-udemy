<?php

echo "hi\n";

$driver = 'mysql';

$config = http_build_query(data: [
    'host' => 'localhost',
    'port' => 3306,
    'dbname' => 'phpiggy',
    "charset" => 'utf8mb4'
], arg_separator: ';');

$dsn = "{$driver}:{$config}";

$username = "root";
$password = "";

$db = null;

try {

    $db = new PDO(dsn: $dsn, username: $username, password: $password,
    options: [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_STRINGIFY_FETCHES => false
    ]);
} catch(Exception $e) {
    echo $e;
}
    
var_dump($db);

$query = $db->prepare("SELECT * FROM products");

$query->execute();

$result = $query->fetchAll();

print_r($result);