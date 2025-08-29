<?php
require_once('../config/database.php');
header('Content-Type: application/json');

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($password !== $confirm_password) {
        echo json_encode(['success' => false, 'message' => "Passwords do not match."]);
        exit();
    }

    try {
        // Check if email exists
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => false, 'message' => "An account with this email already exists."]);
            exit();
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashed_password]);

        echo json_encode(['success' => true, 'message' => "Registration successful!"]);
        exit();
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => "Database error: " . $e->getMessage()]);
        exit();
    }
} else {
    echo json_encode(['success' => false, 'message' => "Invalid request method."]);
    exit();
}
