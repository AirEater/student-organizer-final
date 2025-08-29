<?php
// ExerciseTracker/inc/auth_bridge.php
require_once __DIR__ . '/config_bridge.php';

// If the dashboard already set user_id, we're good
if (empty($_SESSION['user_id'])) {
  // Try to resolve from email or username stored by the dashboard
  $uid = 0;

  if (!empty($_SESSION['email'])) {
    $st = $pdo->prepare('SELECT user_id FROM users WHERE email = ? LIMIT 1');
    $st->execute([$_SESSION['email']]);
    $row = $st->fetch();
    if ($row) $uid = (int)$row['user_id'];
  }

  if (!$uid && !empty($_SESSION['username'])) {
    $st = $pdo->prepare('SELECT user_id FROM users WHERE user_name = ? LIMIT 1');
    $st->execute([$_SESSION['username']]);
    $row = $st->fetch();
    if ($row) $uid = (int)$row['user_id'];
  }

  if ($uid) {
    $_SESSION['user_id'] = $uid;
  } else {
    // Not logged in → send to dashboard login
    header('Location: ' . ROOT_BASE . '/auth/login.php');
    exit;
  }
}
    