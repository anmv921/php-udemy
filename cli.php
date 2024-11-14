<?php

include __DIR__ . '/src/Framework/Database.php';
include __DIR__ . '/src/App/Config/Paths.php';
require __DIR__ . "/vendor/vlucas/phpdotenv/src/Dotenv.php";

require __DIR__ . "/vendor/autoload.php";


use Framework\Database;
use App\Config\Paths;

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(Paths::ROOT);
$dotenv->load();

$db = new Database(
    in_driver: $_ENV["DB_DRIVER"], 
    in_config: [
            'host' => $_ENV["DB_HOST"],
            'port' =>$_ENV["DB_PORT"],
            'dbname' => $_ENV["DB_NAME"],
            "charset" => $_ENV["DB_CHARSET"]
    ],
    in_username: $_ENV["DB_USER"],
    in_password: $_ENV["DB_PASS"]
);

echo "Connected to database\n";

$sqlFile = file_get_contents("./database.sql");

echo $sqlFile;

$db->query($sqlFile);

echo "\nQuery database.sql executed";

// try {
//     $db->connection->beginTransaction();
//     $db->connection->query("INSERT INTO products VALUES(99, 'Gloves')");
//     $search = "Gloves";
//     $query = "SELECT * FROM products WHERE name=:name";
//     $stmt = $db->connection->prepare($query);
//     $stmt->bindValue('name', $search, PDO::PARAM_STR);
//     $stmt->execute();
//     $result = $stmt->fetchAll(mode:PDO::FETCH_OBJ);
//     print_r($result);
//     $db->connection->commit();
// }
// catch (Exception $error) {
//     if ($db->connection->inTransaction()){
//         $db->connection->rollBack();
//     }
//     echo "Transaction failed";
// }


