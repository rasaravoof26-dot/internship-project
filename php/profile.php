<?php
require_once 'db.php';

// Better token retrieval for various server setups
$authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
if (!$authHeader) {
    $headers = getallheaders();
    $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';
}
$token = preg_replace('/^Bearer\s+/i', '', $authHeader);

if (!$token) {
    // Check if token is in cookie as fallback (if implemented later) or query
    $token = $_GET['token'] ?? '';
}

if (!$token) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized: No token provided']);
    exit;
}

try {
    $redis = getRedisConnection();
    $userId = $redis->get("session:$token");

    if (!$userId) {
        echo json_encode(['status' => 'error', 'message' => 'Session expired or invalid']);
        exit;
    }

    $manager = getMongoDBConnection();
    $namespace = "internship_db.profiles";

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $filter = ['user_id' => (int)$userId];
        $query = new MongoDB\Driver\Query($filter);
        $cursor = $manager->executeQuery($namespace, $query);
        $profile = current($cursor->toArray());
        
        echo json_encode(['status' => 'success', 'data' => $profile]);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'age' => $_POST['age'] ?? '',
            'dob' => $_POST['dob'] ?? '',
            'contact' => $_POST['contact'] ?? '',
            'address' => $_POST['address'] ?? '',
            'user_id' => (int)$userId,
            'updated_at' => new MongoDB\BSON\UTCDateTime()
        ];

        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->update(
            ['user_id' => (int)$userId],
            ['$set' => $data],
            ['upsert' => true]
        );
        $manager->executeBulkWrite($namespace, $bulk);

        echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully']);
    }
} catch (\Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
}
?>
