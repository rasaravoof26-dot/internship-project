<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }

    try {
        $pdo = getMySQLConnection();
        $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Generate a random session token
            $token = bin2hex(random_bytes(32));
            
            // Store session in Redis (token => user_id)
            $redis = getRedisConnection();
            $redis->setex("session:$token", 3600, $user['id']); // 1 hour expiration

            echo json_encode([
                'status' => 'success', 
                'token' => $token,
                'message' => 'Login successful'
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
        }
    } catch (\Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
    }
}
?>
