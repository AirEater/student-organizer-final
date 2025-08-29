<?php
session_start();
require_once('../config/database.php'); // $pdo from database.php
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method.');
    }

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = !empty($_POST['remember_me']);

    if (!$email || !$password) {
        throw new Exception('Email and password are required.');
    }

    $stmt = $pdo->prepare("SELECT user_id, username, email, password FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($password, $user['password'])) {
        throw new Exception('Email or password is incorrect.');
    }

    // Set session
    $_SESSION['user_id'] = (int)$user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['loggedin'] = true;
    $_SESSION['last_timestamp'] = time();

    if ($remember) {
        setcookie('user_email', $_SESSION['email'], time() + 86400*30, '/', '', false, true);
    }

    echo json_encode(['success' => true, 'message' => 'Logged in successfully.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
