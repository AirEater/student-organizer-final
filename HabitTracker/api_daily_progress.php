<?php
require_once __DIR__ . '/functions.php';
$pdo = $GLOBALS['pdo'];
$userId = current_user_id();
$selected_date = $_GET['date'] ?? date('Y-m-d');

$allStmt = $pdo->prepare("SELECT * FROM habits WHERE user_id = ? ORDER BY name");
$allStmt->execute([$userId]);
$allHabits = $allStmt->fetchAll(PDO::FETCH_ASSOC);

$habitsForDay = applicable_habits($allHabits, $selected_date);
$doneSet = done_set_for_date($pdo, $userId, $selected_date);

$total = count($habitsForDay);
$done  = 0;
foreach ($habitsForDay as $h) if (isset($doneSet[(int)$h['id']])) $done++;

echo json_encode([
    'total' => $total,
    'done'  => $done,
    'percent'=> $total > 0 ? round(($done/$total)*100) : 0
]);
