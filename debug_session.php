<?php
header('Content-Type: text/plain');
require_once 'php/db.php';

$token = $_GET['token'] ?? '';

if (!$token) {
    echo "No token provided. Usage: debug_session.php?token=YOUR_TOKEN\n";
    
    echo "\nListing all session keys in Redis:\n";
    try {
        $redis = getRedisConnection();
        $keys = $redis->keys('session:*');
        print_r($keys);
    } catch (Exception $e) {
        echo "Redis Error: " . $e->getMessage();
    }
    exit;
}

try {
    $redis = getRedisConnection();
    $userId = $redis->get("session:$token");
    
    echo "Token: $token\n";
    echo "User ID in Redis: " . ($userId === false ? "NOT FOUND" : $userId) . "\n";
    
    if ($userId) {
        echo "\nChecking MySQL for User ID $userId...\n";
        $pdo = getMySQLConnection();
        $stmt = $pdo->prepare("SELECT id, name, email FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        print_r($user);
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
