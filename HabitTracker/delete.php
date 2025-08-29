<?php

require_once __DIR__ . '/functions.php';

$pdo = $GLOBALS['pdo'];
$userId = current_user_id();
$id = (int)($_GET['id'] ?? 0);

    if ($id > 0) delete_habit($pdo, $id, $userId);
header('Location: habit_page.php');

exit;
