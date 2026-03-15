<?php
// Common database and connection helper functions

function getMySQLConnection() {
    // Railway provides MYSQL_URL or individual variables
    $host = getenv('MYSQLHOST') ?: '127.0.0.1';
    $db   = getenv('MYSQLDATABASE') ?: 'internship_db';
    $user = getenv('MYSQLUSER') ?: 'root'; 
    $pass = getenv('MYSQLPASSWORD') ?: ''; 
    $port = getenv('MYSQLPORT') ?: '3306';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
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
    // Railway provides REDIS_URL or REDISHOST/REDISPORT
    $host = getenv('REDISHOST') ?: '127.0.0.1';
    $port = getenv('REDISPORT') ?: 6379;
    $pass = getenv('REDISPASSWORD');

    $redis->connect($host, $port);
    if ($pass) {
        $redis->auth($pass);
    }
    return $redis;
}

function getMongoDBConnection() {
    // Railway provides MONGODB_URL
    $uri = getenv('MONGODB_URL') ?: "mongodb://localhost:27017";
    return new MongoDB\Driver\Manager($uri);
}
?>

