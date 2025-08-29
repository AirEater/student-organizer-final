<?php
// ExerciseTracker/save.php (CSV catalog × duration)
// - If user leaves Calories blank or 0, we look up the exercise in workout_data.csv
//   and compute: calories = round( Estimated_Calories_per_minute * duration_minutes ).

declare(strict_types=1);
session_start();

require_once __DIR__ . '/inc/config_bridge.php';
require_once __DIR__ . '/inc/auth_guard.php';
require_once __DIR__ . '/inc/exercise_catalog.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$userId = (int)($_SESSION['user_id'] ?? 0);
if ($userId <= 0) {
    header('Location: ' . ROOT_BASE . '/auth/login.php');
    exit;
}

$id               = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$exercise_date    = $_POST['exercise_date']    ?? date('Y-m-d');
$exercise_name    = trim($_POST['exercise_name'] ?? '');
$duration_minutes = (int)($_POST['duration_minutes'] ?? 0);
$calories         = (int)($_POST['calories'] ?? 0);
$notes            = trim($_POST['notes'] ?? '');

// Auto-calc calories from CSV if user didn't provide a positive number
if (($calories <= 0) && $exercise_name !== '') {
    $hit = catalog_lookup($exercise_name); // uses workout_data.csv
    if ($hit && !empty($hit['calories_est'])) {
        $per_min = (float)$hit['calories_est'];  // interpret as kcal per minute
        $mins = max(0, (int)$duration_minutes);
        if ($mins > 0) {
            $calories = (int) round($per_min * $mins);
        } else {
            // If duration not provided, just use the single estimate
            $calories = (int) round($per_min);
        }
    }
}

try {
    if ($id > 0) {
        $sql = "UPDATE exercises
                   SET exercise_date = :d,
                       exercise_name = :n,
                       duration_minutes = :m,
                       calories = :c,
                       notes = :notes
                 WHERE id = :id AND user_id = :uid";
        $st = $pdo->prepare($sql);
        $st->execute([
            'd' => $exercise_date,
            'n' => $exercise_name,
            'm' => $duration_minutes,
            'c' => $calories,
            'notes' => $notes,
            'id' => $id,
            'uid' => $userId
        ]);
    } else {
        $sql = "INSERT INTO exercises (user_id, exercise_date, exercise_name, duration_minutes, calories, notes)
                VALUES (:uid, :d, :n, :m, :c, :notes)";
        $st = $pdo->prepare($sql);
        $st->execute([
            'uid' => $userId,
            'd' => $exercise_date,
            'n' => $exercise_name,
            'm' => $duration_minutes,
            'c' => $calories,
            'notes' => $notes
        ]);
    }

    $_SESSION['flash_ok'] = 'Saved successfully.';
    header('Location: index.php?saved=1');
    exit;
} catch (Throwable $e) {
    $_SESSION['flash_err'] = 'DB error: ' . $e->getMessage();
    header('Location: index.php?error=1');
    exit;
}
