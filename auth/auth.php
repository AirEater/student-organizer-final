<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$timeout_duration = 900; # 15 min

if (!isset($_SESSION['username']) || (time() - $_SESSION['last_timestamp']) > $timeout_duration) {
 session_unset();
 session_destroy();
 header("Location: auth/login.php?session_expired=1");
 exit();
} else {
 session_regenerate_id(true);
 $_SESSION['last_timestamp'] = time();
}
?>