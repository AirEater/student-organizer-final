<?php
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;        
    $_SESSION['username'] = 'Demo User';
}


function current_user_id(): int {
    return (int)($_SESSION['user_id'] ?? 1);
}

function presets(): array {
    return [
        ['name'=>'Drink Water','icon'=>'fa-solid fa-droplet','unit'=>'liters','target'=>8,'period'=>'day','schedule'=>'Daily'],
        ['name'=>'Walking','icon'=>'fa-solid fa-person-walking','unit'=>'minutes','target'=>20,'period'=>'day','schedule'=>'Daily'],
        ['name'=>'Jogging','icon'=>'fa-solid fa-person-running','unit'=>'minutes','target'=>30,'period'=>'week','schedule'=>'Weekly'],
        ['name'=>'Sleep','icon'=>'fa-solid fa-bed','unit'=>'hours','target'=>8,'period'=>'day','schedule'=>'Daily'],
        ['name'=>'Study','icon'=>'fa-solid fa-book','unit'=>'minutes','target'=>30,'period'=>'day','schedule'=>'Daily'],
        ['name'=>'Meditation','icon'=>'fa-solid fa-brain','unit'=>'minutes','target'=>15,'period'=>'day','schedule'=>'Daily'],
        ['name'=>'Gym','icon'=>'fa-solid fa-dumbbell','unit'=>'minutes','target'=>45,'period'=>'week','schedule'=>'Weekly'],
        ['name'=>'Reading','icon'=>'fa-solid fa-book-open','unit'=>'pages','target'=>20,'period'=>'day','schedule'=>'Daily'],
        ['name'=>'Cleaning','icon'=>'fa-solid fa-broom','unit'=>'times','target'=>1,'period'=>'week','schedule'=>'Weekly'],
        ['name'=>'Cooking','icon'=>'fa-solid fa-utensils','unit'=>'times','target'=>3,'period'=>'week','schedule'=>'Weekly'],
        ['name'=>'Steps','icon'=>'fa-solid fa-shoe-prints','unit'=>'steps','target'=>10000,'period'=>'day','schedule'=>'Daily'],
    ];
}

function get_habit(PDO $pdo, int $id, int $userId) {
    $stmt = $pdo->prepare("SELECT * FROM habits WHERE id=? AND user_id=?");
    $stmt->execute([$id, $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function delete_habit(PDO $pdo, int $id, int $userId) {
    $pdo->prepare("DELETE FROM habit_logs WHERE habit_id=?")->execute([$id]);
    $stmt = $pdo->prepare("DELETE FROM habits WHERE id=? AND user_id=?");
    return $stmt->execute([$id, $userId]);
}

function applicable_habits(array $allHabits, string $date): array {
    return array_values(array_filter($allHabits, function($h) use ($date) {
        $start = $h['start_date'] ?? null;
        if (!$start || $date < $start) return false;

        $schedule = strtolower($h['schedule'] ?? 'daily');

        if ($schedule === 'daily') {
            return true;
        }

        if ($schedule === 'weekly') {
            $end = date('Y-m-d', strtotime($start . ' +6 days'));
            return ($date >= $start && $date <= $end);
        }

        if ($schedule === 'monthly') {
            $end = date('Y-m-d', strtotime($start . ' +29 days'));
            return ($date >= $start && $date <= $end);
        }

        return false;
    }));
}

function done_set_for_date($pdo, $userId, $date) {
    $stmt = $pdo->prepare("
        SELECT hl.habit_id
        FROM habit_logs hl
        JOIN habits h ON hl.habit_id = h.id
        WHERE h.user_id = ? AND hl.log_date = ? AND hl.status = 'done'
    ");
    $stmt->execute([$userId, $date]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $doneSet = [];
    foreach ($rows as $r) {
        $doneSet[(int)$r['habit_id']] = true;
    }
    return $doneSet;
}



function done_map_for_range($pdo, $userId, $start, $end) {
    $stmt = $pdo->prepare("
        SELECT hl.habit_id, hl.log_date
        FROM habit_logs hl
        JOIN habits h ON hl.habit_id = h.id
        WHERE hl.log_date BETWEEN ? AND ? AND h.user_id=? AND hl.status='done'
    ");
    $stmt->execute([$start, $end, $userId]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $map = [];
    foreach($rows as $r) {
        $map[$r['log_date']][(int)$r['habit_id']] = true;
    }
    return $map;
}



function build_calendar(PDO $pdo, int $userId, string $selected_date = null, array $allHabits = []): string {
    $selected_date = $selected_date ?? date('Y-m-d');
    $today = date('Y-m-d');

    $month = isset($_GET['month']) ? (int)$_GET['month'] : (int)date('m', strtotime($selected_date));
    $year  = isset($_GET['year'])  ? (int)$_GET['year']  : (int)date('Y', strtotime($selected_date));

    $start = sprintf('%04d-%02d-01', $year, $month);
    $end   = date('Y-m-t', strtotime($start));

    $stmt = $pdo->prepare("
        SELECT hl.habit_id, hl.log_date, h.name, h.icon
        FROM habit_logs hl
        JOIN habits h ON hl.habit_id = h.id
        WHERE h.user_id = ? AND hl.log_date BETWEEN ? AND ?
        ORDER BY hl.log_date, h.name
    ");
    $stmt->execute([$userId, $start, $end]);
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $logsByDate = [];
    foreach($logs as $l){
        $logsByDate[$l['log_date']][] = $l;
    }

    $calendarHTML = "<div class='calendar mt-3'>";
    $calendarHTML .= "<h5>Habit Calendar (Monthly)</h5>";
    $calendarHTML .= "<form method='GET' class='d-flex gap-2 mb-2' action='habit_page.php'>";
    $calendarHTML .= "<input type='hidden' name='date' value='".htmlspecialchars($selected_date, ENT_QUOTES)."'>";
    $calendarHTML .= "<select name='month' class='form-select' style='width:auto'>";
    for ($m = 1; $m <= 12; $m++) {
        $sel = ($m === (int)$month) ? "selected" : "";
        $calendarHTML .= "<option value='$m' $sel>" . date('F', mktime(0,0,0,$m,1)) . "</option>";
    }
    $calendarHTML .= "</select>";
    $calendarHTML .= "<select name='year' class='form-select' style='width:auto'>";
    for ($y = (int)date('Y')-1; $y <= (int)date('Y')+1; $y++) {
        $sel = ($y === (int)$year) ? "selected" : "";
        $calendarHTML .= "<option value='$y' $sel>$y</option>";
    }
    $calendarHTML .= "</select>";
    $calendarHTML .= "<button class='btn btn-sm btn-primary' type='submit'>Go</button>";
    $calendarHTML .= "</form>";

    $calendarHTML .= "<table class='table table-bordered text-center'>";
    $calendarHTML .= "<thead><tr>";
    foreach (['Mon','Tue','Wed','Thu','Fri','Sat','Sun'] as $dayName) {
        $calendarHTML .= "<th>$dayName</th>";
    }
    $calendarHTML .= "</tr></thead><tbody><tr>";

    $firstDayOfMonthN = (int)date('N', strtotime($start));
    for ($i=1; $i<$firstDayOfMonthN; $i++) {
        $calendarHTML .= "<td class='bg-light'></td>";
    }

    $curTs = strtotime($start);
    $endTs = strtotime($end);
    while ($curTs <= $endTs) {
        $dateStr = date('Y-m-d', $curTs);
        $classes = [];
        if ($dateStr === $today)         $classes[] = 'table-success';
        if ($dateStr === $selected_date) $classes[] = 'table-primary';

        $calendarHTML .= "<td class='".implode(' ', $classes)."'>";
        $calendarHTML .= "<div><strong>".date('j', $curTs)."</strong></div>";

        $calendarHTML .= "<a href='progress.php?date=$dateStr' class='btn btn-sm btn-link'>View</a>";
        $calendarHTML .= "</td>";

        if ((int)date('N', $curTs) === 7 && $curTs < $endTs) {
            $calendarHTML .= "</tr><tr>";
        }

        $curTs = strtotime('+1 day', $curTs);
    }

    $lastDayN = (int)date('N', strtotime($end));
    if ($lastDayN < 7) {
        for ($i=$lastDayN + 1; $i<=7; $i++) {
            $calendarHTML .= "<td class='bg-light'></td>";
        }
    }

    $calendarHTML .= "</tr></tbody></table>";
    $calendarHTML .= "</div>";
    return $calendarHTML;
}
