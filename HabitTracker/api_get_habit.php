<?php

require_once __DIR__ . '/functions.php';

$pdo = $GLOBALS['pdo'];
$userId = current_user_id();
$id = (int)($_GET['id'] ?? 0);

    if (!$id) { echo json_encode(['error'=>'missing']); exit; }

    $h = get_habit($pdo, $id, $userId);

    echo json_encode($h ?: []);
