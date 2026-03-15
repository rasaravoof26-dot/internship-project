<?php
// Common database and connection helper functions

function getMySQLConnection() {
    // Railway provides MYSQL_URL or individual variables
    $host = getenv('MYSQLHOST') ?: ($_ENV['MYSQLHOST'] ?? ($_SERVER['MYSQLHOST'] ?? 'caboose.proxy.rlwy.net'));
    $db   = getenv('MYSQLDATABASE') ?: ($_ENV['MYSQLDATABASE'] ?? ($_SERVER['MYSQLDATABASE'] ?? 'internship_db'));
    $user = getenv('MYSQLUSER') ?: ($_ENV['MYSQLUSER'] ?? ($_SERVER['MYSQLUSER'] ?? 'root')); 
    $pass = getenv('MYSQLPASSWORD') ?: ($_ENV['MYSQLPASSWORD'] ?? ($_SERVER['MYSQLPASSWORD'] ?? '')); 
    $port = getenv('MYSQLPORT') ?: ($_ENV['MYSQLPORT'] ?? ($_SERVER['MYSQLPORT'] ?? '20565'));
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
    $host = getenv('REDISHOST') ?: 'centerbeam.proxy.rlwy.net';
    $port = getenv('REDISPORT') ?: 45582;
    $pass = getenv('REDISPASSWORD');

    $redis->connect($host, $port);
    if ($pass) {
        $redis->auth($pass);
    }
    return $redis;
}

function getMongoDBConnection() {
    // Railway provides MONGODB_URL
    $uri = getenv('MONGODB_URL') ?: "mongodb://gondola.proxy.rlwy.net:50310";
    return new MongoDB\Driver\Manager($uri);
}
?>

