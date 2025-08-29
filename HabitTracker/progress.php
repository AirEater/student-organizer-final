<?php
session_start();
require_once __DIR__ . '/functions.php';

$pdo = $GLOBALS['pdo'];
$userId = current_user_id();

$today = date('Y-m-d');
$selected_date = $_GET['date'] ?? $today;
$view_mode = $_GET['view'] ?? 'daily';

// Fetch all habits for user
$habitsStmt = $pdo->prepare("SELECT id, name, icon, unit, target, target_period, start_date, schedule FROM habits WHERE user_id = ? ORDER BY name");
$habitsStmt->execute([$userId]);
$allHabits = $habitsStmt->fetchAll(PDO::FETCH_ASSOC);

$viewTitle = '';
$rows = [];

if ($view_mode === 'daily') {
    $viewTitle = 'Daily Progress';
    $habitsForDay = applicable_habits($allHabits, $selected_date);
    $doneSet = done_set_for_date($pdo, $userId, $selected_date);

} elseif ($view_mode === 'weekly') {
    $ts = strtotime($selected_date);
    $weekdayN = (int)date('N', $ts); 
    $weekStart = date('Y-m-d', strtotime("-".($weekdayN-1)." days", $ts));
    $weekEnd   = date('Y-m-d', strtotime("+".(7-$weekdayN)." days", $ts));
    $viewTitle = "Weekly Progress ($weekStart → $weekEnd)";
    $doneMap = done_map_for_range($pdo, $userId, $weekStart, $weekEnd);

    $cur = strtotime($weekStart);
    while ($cur <= strtotime($weekEnd)) {
        $d = date('Y-m-d', $cur);
        $habitsForDay = applicable_habits($allHabits, $d);
        $total = count($habitsForDay);
        $done = 0;
        if (!empty($doneMap[$d])) {
            foreach ($habitsForDay as $h) {
                if (isset($doneMap[$d][(int)$h['id']])) $done++;
            }
        }
        $rows[] = ['date'=>$d, 'done'=>$done, 'total'=>$total];
        $cur = strtotime('+1 day', $cur);
    }

} else { 
    $month = (int)date('m', strtotime($selected_date));
    $year  = (int)date('Y', strtotime($selected_date));
    $monthStart = sprintf('%04d-%02d-01', $year, $month);
    $monthEnd   = date('Y-m-t', strtotime($monthStart));

    $viewTitle = 'Monthly Progress ('. date('F Y', strtotime($selected_date)) .')';
    $doneMap = done_map_for_range($pdo, $userId, $monthStart, $monthEnd);

    $cur = strtotime($monthStart);
    while ($cur <= strtotime($monthEnd)) {
        $d = date('Y-m-d', $cur);
        $habitsForDay = applicable_habits($allHabits, $d);
        $total = count($habitsForDay);
        $done = 0;
        if (!empty($doneMap[$d])) {
            foreach ($habitsForDay as $h) {
                if (isset($doneMap[$d][(int)$h['id']])) $done++;
            }
        }
        $rows[] = ['date'=>$d, 'done'=>$done, 'total'=>$total];
        $cur = strtotime('+1 day', $cur);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Habit Progress</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="../assets/habit.css" rel="stylesheet">
</head>
<body class="p-3">

<div class="topbar">
  <div style="font-weight:700">Habit Tracker</div>
  <div class="d-flex gap-3">
    <a href="/student_organizer/index.php" class="text-decoration-none">Home</a>
    <a href="/student_organizer/ExerciseTracker/index.php" class="text-decoration-none">Exercise Tracker</a>
    <a href="/student_organizer/DiaryJournal/diary.php" class="text-decoration-none">Diary Journal</a>
    <a href="#" class="text-decoration-none">Money Tracker</a>
    <a href="habit_page.php" class="text-decoration-none">Back</a>
  </div>
</div>

<div class="mb-3 d-flex align-items-center gap-2">
    <form class="d-flex align-items-center gap-2" method="GET" action="progress.php">
        <input type="date" name="date" value="<?= htmlspecialchars($selected_date) ?>" class="form-control">
        <input type="hidden" name="view" value="<?= htmlspecialchars($view_mode) ?>">
        <button class="btn btn-primary">Go</button>
    </form>
    <div class="btn-group ms-auto">
        <a href="progress.php?view=daily&date=<?= urlencode($selected_date) ?>" class="btn btn-outline-primary <?= $view_mode==='daily'?'active':'' ?>">Daily</a>
        <a href="progress.php?view=weekly&date=<?= urlencode($selected_date) ?>" class="btn btn-outline-primary <?= $view_mode==='weekly'?'active':'' ?>">Weekly</a>
        <a href="progress.php?view=monthly&date=<?= urlencode($selected_date) ?>" class="btn btn-outline-primary <?= $view_mode==='monthly'?'active':'' ?>">Monthly</a>
    </div>
</div>

<div class="card card-custom p-3">
    <h4 class="mb-3"><?= htmlspecialchars($viewTitle) ?></h4>

<?php if ($view_mode === 'daily'): ?>
    <div class="mb-3">
        <?php
            $total = count($habitsForDay);
            $done  = 0;
            foreach ($habitsForDay as $h) if (isset($doneSet[(int)$h['id']])) $done++;
            $percent = $total > 0 ? round(($done/$total)*100) : 0;
        ?>
        <div class="d-flex justify-content-between mb-1">
            <small class="text-muted"><?= $done ?> of <?= $total ?> completed</small>
            <small class="fw-bold"><?= $percent ?>%</small>
        </div>
        <div class="progress" style="height:8px;">
            <div class="progress-bar bg-success" role="progressbar" style="width: <?= $percent ?>%;"></div>
        </div>
    </div>

    <?php if ($total === 0): ?>
        <p class="text-muted">No habits applicable on this date.</p>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($habitsForDay as $h): ?>
                <?php $done = isset($doneSet[(int)$h['id']]); ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="<?= htmlspecialchars($h['icon']) ?>"></i> <?= htmlspecialchars($h['name']) ?></span>
                    <span class="badge <?= $done ? 'bg-success' : 'bg-secondary' ?>">
                        <?= $done ? 'Done' : 'Not Done' ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>


<?php else: ?>
    <table class="table table-bordered text-center">
        <thead>
            <tr><th>Date</th><th>Done / Total</th></tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r): ?>
                <tr class="<?= $r['date']===$today ? 'table-success' : '' ?><?= $r['date']===$selected_date ? ' table-primary' : '' ?>">
                    <td><?= htmlspecialchars($r['date']) ?></td>
                    <td><?= (int)$r['done'] ?> / <?= (int)$r['total'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
</div>

<script>
function refreshProgress() {
    fetch('api_daily_progress.php?date=<?= $selected_date ?>')
        .then(r => r.json())
        .then(data => {
            const progressBar = document.querySelector('.progress-bar');
            const progressTextLeft = document.querySelector('.d-flex.justify-content-between small:first-child');
            const progressTextRight = document.querySelector('.d-flex.justify-content-between small:last-child');
            if (progressBar) progressBar.style.width = data.percent + '%';
            if (progressTextLeft) progressTextLeft.textContent = `${data.done} of ${data.total} completed`;
            if (progressTextRight) progressTextRight.textContent = `${data.percent}%`;
        });
}

refreshProgress();

setInterval(refreshProgress, 2000);
</script>

</script>

</body>
</html>
