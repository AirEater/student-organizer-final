<?php

require_once __DIR__ . '/../models/User.php';

class DashboardController {
    public function index() {
        // Authentication and session management handled by auth.php

        $userModel = new User();
        $user = $userModel->getUserById($_SESSION['user_id']);

        $username = $user['username'] ?? 'Guest';
        $userInitial = !empty($username) ? strtoupper(substr($username, 0, 1)) : '?';

        date_default_timezone_set('Asia/Kuala_Lumpur');
        $hour = date('H');
        if ($hour < 12) {
            $greeting = "Good morning";
        } elseif ($hour < 18) {
            $greeting = "Good afternoon";
        } else {
            $greeting = "Good evening";
        }

        include __DIR__ . '/../views/templates/header.php';
        include __DIR__ . '/../views/dashboard.php';
        include __DIR__ . '/../views/templates/footer.php';
    }

    // In User.php
public function logout() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    session_unset();
    session_destroy();
    header("Location: ../student_organizer/index.php?session_expired=1");
    exit();
}
}

?>