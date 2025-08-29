<?php
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Clear the "remember me" cookie
if (isset($_COOKIE['user_email'])) {
    unset($_COOKIE['user_email']);
    setcookie('user_email', '', time() - 3600, '/'); // Expire the cookie
}

// Redirect to the login page
header("Location: ../login.php");
exit;

?>