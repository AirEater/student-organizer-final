<?php
session_start(); // Start the session

require_once(__DIR__ . '/config/database.php'); // $pdo connection
require_once(__DIR__ . '/controllers/DashboardController.php');

// --- LOGOUT HANDLER ---
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $dashboardController = new DashboardController();
    $dashboardController->logout();

    // Destroy session and remove "remember me" cookie
    session_unset();
    session_destroy();
    setcookie('user_email', '', time() - 3600, '/');

    header('Location: auth/login.php');
    exit;
}

// --- REMEMBER ME COOKIE LOGIN ---
if (!isset($_SESSION['loggedin']) && isset($_COOKIE['user_email'])) {
    $email = $_COOKIE['user_email'];

    $stmt = $pdo->prepare("SELECT user_id, username, email FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $user['email'];
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
    } else {
        // Invalid cookie: remove it
        setcookie('user_email', '', time() - 3600, '/');
    }
}

// --- DASHBOARD OR LOGIN REDIRECT ---
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    include(__DIR__ . '/auth/auth.php'); // optional: session timeout check

    $dashboardController = new DashboardController();
    $dashboardController->index();
    exit;
} else {
    header('Location: auth/login.php');
    exit;
}
?>
