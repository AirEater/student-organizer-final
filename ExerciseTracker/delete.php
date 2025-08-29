<?php
// ExerciseTracker/delete.php (patched)
// Accepts POST *or* GET, uses PDO, and deletes from the correct table `exercises`.
declare(strict_types=1);
session_start();

require_once __DIR__ . '/inc/config_bridge.php';
require_once __DIR__ . '/inc/auth_guard.php';

$userId = (int)($_SESSION['user_id'] ?? 0);
$id = isset($_POST['id']) ? (int)$_POST['id'] : (int)($_GET['id'] ?? 0);

if ($userId <= 0 || $id <= 0) {
    header('Location: index.php');
    exit;
}

try {
    $st = $pdo->prepare('DELETE FROM exercises WHERE id = :id AND user_id = :uid');
    $st->execute(['id' => $id, 'uid' => $userId]);
    $_SESSION['flash_ok'] = 'Deleted successfully.';
} catch (Throwable $e) {
    $_SESSION['flash_err'] = 'DB error: ' . $e->getMessage();
}

header('Location: index.php?deleted=1');
exit;
