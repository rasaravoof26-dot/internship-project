<?php
require_once 'db.php';

// Simple token parser from header
$headers = getallheaders();
$authHeader = $headers['Authorization'] ?? '';
$token = str_replace('Bearer ', '', $authHeader);

if (!$token) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
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
