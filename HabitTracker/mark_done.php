<?php
require_once __DIR__ . '/functions.php';
$pdo = $GLOBALS['pdo'];
$userId = current_user_id();

$habitId = (int)($_POST['habit_id'] ?? 0);
$date = $_POST['date'] ?? date('Y-m-d');

if (!$habitId) {
    echo json_encode(['success'=>false,'error'=>'Invalid habit']);
    exit;
}

$stmt = $pdo->prepare("SELECT id FROM habits WHERE id=? AND user_id=?");
$stmt->execute([$habitId, $userId]);
if (!$stmt->fetch()) {
    echo json_encode(['success'=>false,'error'=>'Habit not found']);
    exit;
}

$check = $pdo->prepare("SELECT id FROM habit_logs WHERE habit_id=? AND log_date=?");
$check->execute([$habitId, $date]);
$existing = $check->fetch(PDO::FETCH_ASSOC);

if ($existing) {
    
    $stmt = $pdo->prepare("DELETE FROM habit_logs WHERE id=?");
    $ok = $stmt->execute([$existing['id']]);
} else {

    $stmt = $pdo->prepare("INSERT INTO habit_logs (habit_id, log_date, status) VALUES (?, ?, 'done')");
    $ok = $stmt->execute([$habitId, $date]);
}

echo json_encode(['success'=>!!$ok]);
