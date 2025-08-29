<?php
require_once __DIR__ . '/functions.php';
$pdo = $GLOBALS['pdo'];
$userId = current_user_id();

$habitId = (int)($_POST['habit_id'] ?? 0);
$date = $_POST['date'] ?? date('Y-m-d');

$stmt = $pdo->prepare("UPDATE habit_logs hl JOIN habits h ON h.id = hl.habit_id SET hl.status = 0 WHERE hl.habit_id = ? AND hl.log_date = ? AND h.user_id = ?");
$ok = $stmt->execute([$habitId, $date, $userId]);

echo json_encode(['success' => $ok]);
