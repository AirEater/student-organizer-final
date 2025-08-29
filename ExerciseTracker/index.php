<?php
require_once __DIR__ . '/inc/header_ex.php';


$userId = (int)($_SESSION['user_id'] ?? 0);
if ($userId <= 0) {
  header('Location: ' . ROOT_BASE . '/auth/login.php');
  exit;
}

$from = ($_GET['from'] ?? '') ?: null;
$to   = ($_GET['to']   ?? '') ?: null;

$rows = [];
try {
  $sql = "SELECT id, exercise_date, exercise_name, duration_minutes, calories, notes
          FROM exercises
          WHERE user_id = :uid";
  $params = [':uid' => $userId];

  if ($from) { $sql .= " AND exercise_date >= :from"; $params[':from'] = $from; }
  if ($to)   { $sql .= " AND exercise_date <= :to";   $params[':to']   = $to;   }

  $sql .= " ORDER BY exercise_date DESC, id DESC";
  $st = $pdo->prepare($sql);
  $st->execute($params);
  $rows = $st->fetchAll();
} catch (Throwable $e) {
  // surface the error while we’re fixing
  echo '<pre style="color:#b00020;background:#fff3f3;padding:12px;border:1px solid #f7c4c4;">';
  echo 'SQL Error: ' . htmlspecialchars($e->getMessage());
  echo '</pre>';
}
?>

<main class="flex-grow">
  <section class="w-full max-w-screen-xl mx-auto px-6 md:px-8 py-10">
    <div class="mb-6 flex items-center justify-between">
      <h1 class="text-2xl md:text-3xl font-bold">My Exercises</h1>
      <div class="flex items-center gap-2">
        <a href="stats.php" class="btn btn-ghost">Stats</a>
        <a href="form.php" class="btn btn-primary">+ Add Exercise</a>
      </div>
    </div>

    <!-- Filters -->
    <form method="get" class="mb-6">
      <div class="grid grid-cols-1 sm:grid-cols-5 gap-3">
        <label class="form-control w-full sm:col-span-2">
          <div class="label"><span class="label-text">From</span></div>
          <input type="date" name="from" value="<?= htmlspecialchars($from ?? '') ?>" class="input input-bordered w-full">
        </label>
        <label class="form-control w-full sm:col-span-2">
          <div class="label"><span class="label-text">To</span></div>
          <input type="date" name="to" value="<?= htmlspecialchars($to ?? '') ?>" class="input input-bordered w-full">
        </label>
        <div class="flex items-end gap-2">
          <button type="submit" class="btn btn-primary">Filter</button>
          <a href="index.php" class="btn btn-ghost">Clear</a>
        </div>
      </div>
    </form>

    <!-- Table card -->
    <div class="card bg-base-100 shadow-soft overflow-hidden">
      <div class="card-body p-0">
        <div class="overflow-x-auto">
          <table class="table table-zebra w-full">
            <thead class="bg-base-200">
              <tr>
                <th class="text-left">Date</th>
                <th class="text-left">Exercise</th>
                <th class="text-left">Duration (min)</th>
                <th class="text-left">Calories</th>
                <th class="text-left">Notes</th>
                <th class="text-left">Actions</th>
              </tr>
            </thead>
            <tbody>
            <?php if (!$rows): ?>
              <tr>
                <td colspan="6" class="text-center py-8 text-base-content/70">No exercises found.</td>
              </tr>
            <?php else: foreach ($rows as $r): ?>
              <tr>
                <td><?= htmlspecialchars($r['exercise_date']) ?></td>
                <td class="font-medium"><?= htmlspecialchars($r['exercise_name']) ?></td>
                <td><?= (int)$r['duration_minutes'] ?></td>
                <td><?= (int)$r['calories'] ?></td>
                <td class="truncate max-w-[18rem]"><?= htmlspecialchars($r['notes'] ?? '') ?></td>
                <td class="flex gap-2">
                  <a class="btn btn-sm btn-outline" href="form.php?id=<?= (int)$r['id'] ?>">Edit</a>
                  <a class="btn btn-sm btn-error"
                     href="delete.php?id=<?= (int)$r['id'] ?>"
                     onclick="return confirm('Delete this exercise?');">Delete</a>
                </td>
              </tr>
            <?php endforeach; endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</main>

<?php require_once __DIR__ . '/inc/footer_ex.php'; ?>
