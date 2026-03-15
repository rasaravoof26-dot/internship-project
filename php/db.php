<?php
// Common database and connection helper functions

function getMySQLConnection() {
    $host = '127.0.0.1';
    $db   = 'internship_db';
    $user = 'root'; 
    $pass = ''; 
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}

function getRedisConnection() {
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);
    return $redis;
}

function getMongoDBConnection() {
    // Returns the low-level driver manager
    return new MongoDB\Driver\Manager("mongodb://localhost:27017");
}
?>
