<?php
require_once __DIR__ . '/functions.php';
$pdo = $GLOBALS['pdo'];
$userId = current_user_id();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: habit_page.php');
    exit;
}

$habitId   = isset($_POST['habit_id']) ? intval($_POST['habit_id']) : 0;
$name      = trim($_POST['name'] ?? '');
$icon      = trim($_POST['icon'] ?? 'fa-solid fa-circle');
$unit      = trim($_POST['unit'] ?? 'count');
$target    = intval($_POST['target'] ?? 1);
$schedule  = ucfirst(strtolower($_POST['schedule'] ?? 'daily'));
$notes     = trim($_POST['notes'] ?? '');
$startDate = $_POST['start_date'] ?? date('Y-m-d');
$target_period = $schedule;

if ($name === '') {
    header('Location: habit_page.php?error=empty');
    exit;
}

if ($habitId > 0) {

    $stmt = $pdo->prepare("
        UPDATE habits 
        SET name = ?, icon = ?, unit = ?, target = ?, target_period = ?, schedule = ?, notes = ?, start_date = ?
        WHERE id = ? AND user_id = ?
    ");
    $stmt->execute([
        $name, $icon, $unit, $target, $target_period, $schedule, $notes, $startDate, $habitId, $userId
    ]);


    header('Location: habit_page.php?updated=1');
    exit;

} else {
  
    $stmt = $pdo->prepare("
        INSERT INTO habits 
        (user_id, name, icon, unit, target, target_period, schedule, notes, start_date, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    $stmt->execute([
        $userId, $name, $icon, $unit, $target, $target_period, $schedule, $notes, $startDate
    ]);
    $habitId = $pdo->lastInsertId();

    $daysRange = 1;
    if (strtolower($schedule) === 'weekly') {
        $daysRange = 7;
    } elseif (strtolower($schedule) === 'monthly') {
        $daysRange = 30;
    }

    $start = new DateTime($startDate);
    for ($i = 0; $i < $daysRange; $i++) {
        $date = clone $start;
        $date->modify("+$i day");

        $stmt = $pdo->prepare("
            INSERT INTO habit_logs (habit_id, log_date, amount, status, created_at)
            VALUES (?, ?, 0, 'undone', NOW())
        ");
        $stmt->execute([$habitId, $date->format('Y-m-d')]);
    }

    header('Location: habit_page.php?success=1');
    exit;
}
