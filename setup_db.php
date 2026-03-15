<?php
header('Content-Type: text/plain');
require_once 'php/db.php';

// We need to connect without a database first to create it
$host = getenv('MYSQLHOST') ?: ($_ENV['MYSQLHOST'] ?? ($_SERVER['MYSQLHOST'] ?? 'caboose.proxy.rlwy.net'));
$user = getenv('MYSQLUSER') ?: ($_ENV['MYSQLUSER'] ?? ($_SERVER['MYSQLUSER'] ?? 'root')); 
$pass = getenv('MYSQLPASSWORD') ?: ($_ENV['MYSQLPASSWORD'] ?? ($_SERVER['MYSQLPASSWORD'] ?? 'OMAhZjCpuhcBGYxthbncNEUcIPrHZOJT')); 
$port = getenv('MYSQLPORT') ?: ($_ENV['MYSQLPORT'] ?? ($_SERVER['MYSQLPORT'] ?? '20565'));
$dbName = 'internship_db';

try {
    // 1. Connect without DB
    $dsn = "mysql:host=$host;port=$port;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    echo "Connected to MySQL server.\n";

    // 2. Create Database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database `$dbName` ensured.\n";

    // 3. Switch to Database
    $pdo->exec("USE `$dbName`");

    // 4. Create Tables
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "Table `users` ensured.\n";

    echo "\nInitialization successfully completed!\n";

} catch (PDOException $e) {
    die("Initialization failed: " . $e->getMessage());
}
?>
