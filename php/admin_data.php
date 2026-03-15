<?php
require_once 'db.php';

header('Content-Type: application/json');

try {
    // 1. Fetch Users from MySQL
    $pdo = getMySQLConnection();
    $stmt = $pdo->query("SELECT id, name, email, password, created_at FROM users");
    $users = $stmt->fetchAll();

    // 2. Fetch Profiles from MongoDB
    $manager = getMongoDBConnection();
    $namespace = "internship_db.profiles";
    $query = new MongoDB\Driver\Query([]); // Fetch all
    $cursor = $manager->executeQuery($namespace, $query);
    $all_profiles = $cursor->toArray();

    // Group profiles by user_id for easier matching
    $profiles = [];
    foreach ($all_profiles as $profile) {
        // Convert BSON object to associative array
        $pArr = (array)$profile;
        if (isset($pArr['user_id'])) {
            $profiles[$pArr['user_id']] = $pArr;
        }
    }

    echo json_encode([
        'status' => 'success',
        'users' => $users,
        'profiles' => $profiles
    ]);

} catch (\Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
}
