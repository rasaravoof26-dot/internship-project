<?php
header('Content-Type: text/plain');
require_once 'php/db.php';

echo "Testing MySQL Connection...\n";
try {
    $pdo = getMySQLConnection();
    echo "MySQL SUCCESS\n";
} catch (Exception $e) {
    echo "MySQL FAILED: " . $e->getMessage() . "\n";
}

echo "\nTesting Redis Connection...\n";
try {
    $redis = getRedisConnection();
    echo "Redis SUCCESS\n";
    $redis->set("test_key", "hello");
    echo "Redis Set/Get SUCCESS: " . $redis->get("test_key") . "\n";
} catch (Exception $e) {
    echo "Redis FAILED: " . $e->getMessage() . "\n";
}

echo "\nTesting MongoDB Connection...\n";
try {
    $manager = getMongoDBConnection();
    $command = new MongoDB\Driver\Command(['ping' => 1]);
    $manager->executeCommand('admin', $command);
    echo "MongoDB SUCCESS\n";
} catch (Exception $e) {
    echo "MongoDB FAILED: " . $e->getMessage() . "\n";
}
?>
