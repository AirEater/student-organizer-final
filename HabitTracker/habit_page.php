<?php  
require_once __DIR__ . '/functions.php';

$pdo = $GLOBALS['pdo'];
$userId = current_user_id();
$presets = presets();

$today = (new DateTime('today'))->format('Y-m-d');
$selected_date = $_GET['date'] ?? $today;

$allStmt = $pdo->prepare("SELECT * FROM habits WHERE user_id = ? ORDER BY name");
$allStmt->execute([$userId]);
$allHabits = $allStmt->fetchAll(PDO::FETCH_ASSOC);

$habits = applicable_habits($allHabits, $selected_date);
$doneSet = done_set_for_date($pdo, $userId, $selected_date);
?>

<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8">
  <title>Habit Tracker Module</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/habit.css">
</head>
<body>
  <div class="topbar">
    <div style="font-weight:700">Habit Tracker</div>
    <div class="d-flex gap-3">
      <a href="/student_organizer/index.php" class="text-decoration-none">Home</a>
      <a href="/student_organizer/ExerciseTracker/index.php" class="text-decoration-none">Exercise Tracker</a>
      <a href="/student_organizer/DiaryJournal/diary.php" class="text-decoration-none">Diary Journal</a>
      <a href="#" class="text-decoration-none">Money Tracker</a>
    </div>
  </div>

  <div class="container-max">
    <!-- Quick Selection -->
    <div class="card p-3 mt-3 mb-3">
      <h5 class="mb-0">Quick Selection</h5>
      <div class="mt-3 d-flex flex-wrap gap-2">
        <?php foreach ($presets as $p): ?>
          <button type="button" class="btn btn-outline-primary preset-btn"
            onclick="fillPreset(
              '<?= htmlspecialchars($p['name'], ENT_QUOTES) ?>',
              '<?= htmlspecialchars($p['icon'], ENT_QUOTES) ?>',
              '<?= htmlspecialchars($p['unit'], ENT_QUOTES) ?>',
              '<?= (int)$p['target'] ?>',
              '<?= htmlspecialchars($p['schedule'], ENT_QUOTES) ?>'
            )">
            <i class="<?= htmlspecialchars($p['icon']) ?>"></i> <?= htmlspecialchars($p['name']) ?>
          </button>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="row g-3">
      <div class="col-lg-5">
        <div class="card p-3">
          <h5>Add / Edit Habit</h5>
          <form id="habitForm" method="POST" action="add_habit.php">
            <input type="hidden" name="habit_id" id="habit_id" value="">
            <div class="mb-2">
              <label class="form-label">Habit name</label>
              <input id="name" name="name" class="form-control" required>
              <div class="mt-2">
                <label class="form-label">Start Date</label>
                <input id="start_date" name="start_date" type="date" class="form-control" value="<?= date('Y-m-d') ?>">
              </div>
            </div>
            <div class="row g-2">
              <div class="col-6">
                <label class="form-label">Unit</label>
                <select id="unit" name="unit" class="form-select">
                  <option value="count">count</option>
                  <option value="minutes">minutes</option>
                  <option value="hours">hours</option>
                  <option value="liters">liters</option>
                  <option value="pages">pages</option>
                  <option value="times">times</option>
                  <option value="steps">steps</option>
                </select>
              </div>
              <div class="col-6">
                <label class="form-label">Target</label>
                <input id="target" name="target" type="number" min="1" class="form-control" value="1">
              </div>
            </div>
            <div class="mt-2">
              <label class="form-label">Schedule</label>
              <select id="schedule" name="schedule" class="form-select">
                <option value="Daily">1 day</option>
                <option value="Weekly">7 days</option>
                <option value="Monthly">30 days</option>
              </select>
            </div>

            <div class="mb-2 mt-2">
              <label class="form-label">Notes (optional)</label>
              <textarea id="notes" name="notes" class="form-control" rows="2"></textarea>
            </div>
            <input type="hidden" name="icon" id="icon" value="fa-solid fa-circle">
            <div class="d-flex gap-2 justify-content-end mt-2">
              <button type="submit" class="btn btn-primary">Save Habit</button>
              <button type="button" class="btn btn-secondary" onclick="resetForm()">Reset</button>
            </div>
          </form>
        </div>
      </div>

      <div class="col-lg-7">
        <div class="card p-3 mb-3">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="mb-0">Habits for <strong><?= htmlspecialchars($selected_date) ?></strong></h5>
            <form method="GET" class="d-flex gap-2" action="habit_page.php">
              <input type="date" name="date" value="<?= htmlspecialchars($selected_date) ?>" class="form-control">
              <button class="btn btn-sm btn-primary">Go</button>
            </form>
          </div>


          <div class="mb-3">
            <?php
                $total = count($habits);
                $done  = 0;
                foreach ($habits as $h) if (isset($doneSet[(int)$h['id']])) $done++;
                $percent = $total > 0 ? round(($done/$total)*100) : 0;
            ?>
            <div class="d-flex justify-content-between mb-1">
              <small id="progress-text" class="text-muted"><?= $done ?> of <?= $total ?> completed</small>
              <small id="progress-percent" class="fw-bold"><?= $percent ?>%</small>
            </div>
            <div class="progress" style="height:8px;">
              <div id="progress-bar" class="progress-bar bg-success" role="progressbar" style="width: <?= $percent ?>%;"></div>
            </div>
          </div>

          <?php if (empty($habits)): ?>
            <p class="text-muted">No habits yet.</p>
          <?php else: ?>
            <?php foreach ($habits as $h): ?>
              <div class="habit-row" id="habit-<?= (int)$h['id'] ?>">
                <div class="d-flex align-items-center gap-3">
                  <div class="icon-img"><i class="<?= htmlspecialchars($h['icon']) ?>"></i></div>
                  <div>
                    <div class="fw-semibold"><?= htmlspecialchars($h['name']) ?></div>
                    <div class="text-muted small"><?= (int)$h['target'] ?> <?= htmlspecialchars($h['unit']) ?> / <?= htmlspecialchars($h['target_period']) ?></div>
                  </div>
                </div>
                <div class="actions">
                  <?php if ($selected_date <= $today): ?>
                    <?php if (!empty($doneSet[(int)$h['id']])): ?>
                      <button type="button" class="btn btn-sm btn-success mark-undo" data-id="<?= (int)$h['id'] ?>">Undo</button>
                    <?php else: ?>
                      <button type="button" class="btn btn-sm btn-outline-success mark-done" data-id="<?= (int)$h['id'] ?>">Mark Done</button>
                    <?php endif; ?>
                  <?php endif; ?>
                  <button type="button" class="btn btn-sm btn-outline-primary" onclick="editHabit(<?= (int)$h['id'] ?>)">Edit</button>
                  <a class="btn btn-sm btn-outline-danger" href="delete.php?id=<?= (int)$h['id'] ?>" onclick="return confirm('Delete habit and logs?')">Delete</a>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <div class="card p-3 mb-3">
          <?= build_calendar($pdo, $userId, $selected_date, $allHabits) ?>
        </div>
      </div>
    </div>
  </div>

<script>
document.addEventListener('DOMContentLoaded', function () {

  window.fillPreset = function (name, icon, unit, target, schedule = 'Daily') {
    document.getElementById('habit_id').value = '';
    document.getElementById('name').value = name;
    document.getElementById('icon').value = icon;
    document.getElementById('unit').value = unit;
    document.getElementById('target').value = target;
    document.getElementById('schedule').value = schedule;
    document.getElementById('habitForm').scrollIntoView({ behavior: 'smooth', block: 'center' });
  };

  window.resetForm = function () {
    const f = document.getElementById('habitForm');
    if (f) f.reset();
    document.getElementById('icon').value = 'fa-solid fa-circle';
    document.getElementById('habit_id').value = '';
  };

  window.editHabit = function (id) {
    fetch('api_get_habit.php?id=' + id)
      .then(r => r.json())
      .then(h => {
        if (!h || !h.id) { alert('Habit not found'); return; }
        document.getElementById('habit_id').value = h.id;
        document.getElementById('name').value = h.name;
        document.getElementById('icon').value = h.icon;
        document.getElementById('unit').value = h.unit;
        document.getElementById('target').value = h.target;
        document.getElementById('schedule').value = h.schedule || 'Daily';
        document.getElementById('notes').value = h.notes || '';
        document.getElementById('habitForm').scrollIntoView({ behavior: 'smooth', block: 'center' });
      })
      .catch(err => { console.error(err); alert('Failed to load habit'); });
  };

  function updateProgress() {
    const items = document.querySelectorAll('.habit-row');
    let total = items.length;
    let done = 0;
    items.forEach(item => {
      const btn = item.querySelector('.mark-undo');
      if (btn) done++;
    });
    const percent = total > 0 ? Math.round((done / total) * 100) : 0;
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');
    const progressPercent = document.getElementById('progress-percent');
    if (progressBar) progressBar.style.width = percent + '%';
    if (progressText) progressText.textContent = `${done} of ${total} completed`;
    if (progressPercent) progressPercent.textContent = `${percent}%`;
  }

  document.body.addEventListener('click', function (e) {
    const doneBtn = e.target.closest('.mark-done');
    const undoBtn = e.target.closest('.mark-undo');

    const btn = doneBtn || undoBtn;
    if (!btn) return;

    const habitId = btn.dataset.id;
    const isDone = !!doneBtn;

    btn.disabled = true;
    btn.textContent = 'Saving...';

    fetch('mark_done.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'habit_id=' + encodeURIComponent(habitId) + '&date=<?= $selected_date ?>'
    })
    .then(r => r.json())
    .then(res => {
      if (res && res.success) {
        btn.outerHTML = isDone
          ? "<button type='button' class='btn btn-sm btn-success mark-undo' data-id='" + habitId + "'>Undo</button>"
          : "<button type='button' class='btn btn-sm btn-outline-success mark-done' data-id='" + habitId + "'>Mark Done</button>";
        updateProgress();
      } else {
        alert(res.error || 'Update failed');
        btn.disabled = false;
        btn.textContent = isDone ? 'Mark Done' : 'Undo';
      }
    });
  });

  updateProgress();
});
</script>
</body>
</html>
