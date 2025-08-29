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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];          // <-- ADD THIS
    $entry_date = $_POST['entry_date'];
    $mood = $_POST['mood'];
    $content = $_POST['content'];

    // Include title in the INSERT query
    $stmt = $pdo->prepare("
        INSERT INTO journal_entries (user_id, title, entry_date, mood, content) 
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([$userId, $title, $entry_date, $mood, $content]);

    header("Location: view.php?message=Entry added successfully!");
    exit();
}

// Calendar setup
$month = isset($_GET['month']) ? (int)$_GET['month'] : date("n");
$year = isset($_GET['year']) ? (int)$_GET['year'] : date("Y");

// Adjust month/year if out of range
if ($month < 1) {
    $month = 12;
    $year--;
} elseif ($month > 12) {
    $month = 1;
    $year++;
}

// Fetch entries count for this month
$stmt = $pdo->prepare("
    SELECT entry_date, COUNT(*) as total 
    FROM journal_entries 
    WHERE user_id = ? AND MONTH(entry_date) = ? AND YEAR(entry_date) = ?
    GROUP BY entry_date
");
$stmt->execute([$userId, $month, $year]);
$entries = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $entries[$row['entry_date']] = $row['total'];
}


?>


<!DOCTYPE html>
<html>
<head>
    <title>Diary Journal</title>
    <link rel="stylesheet" href="diary.css">
    <style>
        .month-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 15px 0;
        }
        .month-nav .nav-center {
            font-weight: bold;
            font-size: 18px;
        }
        .calendar {
            border-collapse: collapse;
            width: 100%;
        }
        .calendar th, .calendar td {
            border: 1px solid #ccc;
            text-align: center;
            padding: 10px;
            height: 80px;
        }
        .calendar .has-entry {
            background-color: #d1ffd6;
            font-weight: bold;
        }
        .success {
            color: green;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<div class="navbar">
    <a href="http://localhost/student_organizer/index.php">Home</a>
    <a href="http://localhost/student_organizer/ExerciseTracker/index.php">Exercise Tracker</a>
    <a href="diary.php" class="active">Diary Journal</a>
    <a href="../money.php">Money Tracker</a>
    <a href="http://localhost/student_organizer/HabitTracker/habit_page.php">Habit Tracker</a>
</div>

<div class="container">
    <!-- Left: Add Diary Form -->
    <div class="form-container">
        <h2>Add New Diary Entry</h2>
        <?php if (!empty($message)) echo "<p class='success'>$message</p>"; ?>
        <form method="post">
            <input type="text" name="title" placeholder="Diary Title" required>
            <textarea name="content" placeholder="Write your thoughts..." rows="5" required></textarea>
            <select name="mood" required>
                <option value="">Select Mood</option>
                <option value="😊 Happy">😊 Happy</option>
                <option value="😔 Sad">😔 Sad</option>
                <option value="😡 Angry">😡 Angry</option>
                <option value="😴 Tired">😴 Tired</option>
                <option value="😎 Excited">😎 Excited</option>
                <option value="🤔 Thoughtful">🤔 Thoughtful</option>
                <option value="🥴 Anxious">🥴 Anxious</option>
            </select>
            <input type="date" name="entry_date" required>
            <button type="submit" name="add_entry">Add Entry</button>
        </form>
        <div class="nav-buttons">
            <a href="view.php" class="btn">View Past Entries</a>
        </div>
    </div>

    <!-- Right: Calendar -->
    <div class="calendar-container">
        <h2>📅 Diary Calendar</h2>

        <!-- Month navigation -->
        <div class="month-nav">
            <div class="nav-left">
                <a href="?month=<?php echo $month-1; ?>&year=<?php echo $year; ?>" class="btn">⬅ Prev</a>
            </div>
            <div class="nav-center">
                <?php echo date("F Y", strtotime("$year-$month-01")); ?>
            </div>
            <div class="nav-right">
                <a href="?month=<?php echo $month+1; ?>&year=<?php echo $year; ?>" class="btn">Next ➡</a>
            </div>
        </div>

        <?php
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $firstDay = date("w", strtotime("$year-$month-01"));

        echo "<table class='calendar'>";
        echo "<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th>
                  <th>Thu</th><th>Fri</th><th>Sat</th></tr><tr>";

        // Empty cells before first day
        for ($i = 0; $i < $firstDay; $i++) echo "<td></td>";

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dateStr = "$year-" . str_pad($month,2,"0",STR_PAD_LEFT) . "-" . str_pad($day,2,"0",STR_PAD_LEFT);
            $hasEntry = isset($entries[$dateStr]) ? $entries[$dateStr] : 0;

            if ($hasEntry > 0) {
                echo "<td class='has-entry'><a href='view.php?date=$dateStr'>$day<br><small>{$hasEntry} entries</small></a></td>";
            } else {
                echo "<td>$day</td>";
            }

            if (($day + $firstDay) % 7 == 0) echo "</tr><tr>";
        }
        echo "</tr></table>";
        ?>
    </div>
</div>

</body>
</html>