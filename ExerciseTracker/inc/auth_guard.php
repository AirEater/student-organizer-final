<?php
// ExerciseTracker/inc/auth_guard.php
declare(strict_types=1);

// Always start a session before using $_SESSION
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

/**
 * Adjust these keys to match how your login stores user data.
 * Many dashboards use $_SESSION['user_id'] or $_SESSION['user']['user_id'].
 */
$uid = $_SESSION['user_id'] ?? ($_SESSION['user']['user_id'] ?? null);

// Not logged in? Kick back to the dashboard login or your app's login route.
if (!$uid) {
    header('Location: ../index.php'); // change if your login URL is different
    exit;
}

// Convenience helper you can use elsewhere
function auth_user_id(): int {
    return (int)($_SESSION['user_id'] ?? ($_SESSION['user']['user_id'] ?? 0));
}
