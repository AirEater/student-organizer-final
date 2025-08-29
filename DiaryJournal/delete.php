<?php
session_start();
require_once __DIR__ . '/../auth/auth.php';
require_once __DIR__ . '/../config/database.php';
$pdo = $GLOBALS['pdo'];

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$userId = $_SESSION['user_id'];

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM journal_entries WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $userId]);

    header("Location: view.php?message=Entry deleted successfully!");
    exit();
} else {
    header("Location: view.php?message=Invalid request");
    exit();
}