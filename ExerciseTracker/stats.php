<?php
require_once __DIR__ . '/inc/header_ex.php';

$userId = (int)($_SESSION['user_id'] ?? 0);
if ($userId <= 0) {
  header('Location: ' . ROOT_BASE . '/auth/login.php');
  exit;
}

try {
  $weekly = $pdo->prepare("
    SELECT DATE_FORMAT(exercise_date, '%x%v') AS weeknum,
           SUM(duration_minutes) AS minutes,
           SUM(calories) AS kcal
    FROM exercises
    WHERE user_id = :uid
      AND exercise_date >= (CURDATE() - INTERVAL 84 DAY)
    GROUP BY weeknum
    ORDER BY weeknum DESC
    LIMIT 12
  ");
  $weekly->execute([':uid' => $userId]);
  $weeklyRows = $weekly->fetchAll();

  $monthly = $pdo->prepare("
    SELECT DATE_FORMAT(exercise_date, '%Y-%m') AS ym,
           SUM(duration_minutes) AS minutes,
           SUM(calories) AS kcal
    FROM exercises
    WHERE user_id = :uid
      AND exercise_date >= (CURDATE() - INTERVAL 365 DAY)
    GROUP BY ym
    ORDER BY ym DESC
    LIMIT 12
  ");
  $monthly->execute([':uid' => $userId]);
  $monthlyRows = $monthly->fetchAll();
} catch (Throwable $e) {
  echo '<pre style="color:#b00020;background:#fff3f3;padding:12px;border:1px solid #f7c4c4;">';
  echo 'SQL Error: ' . htmlspecialchars($e->getMessage());
  echo '</pre>';
  $weeklyRows = $monthlyRows = [];
}
?>

<main class="flex-grow">
  <section class="w-full max-w-screen-xl mx-auto px-6 md:px-8 py-10">
    <div class="mb-6 flex items-center justify-between">
      <h1 class="text-2xl md:text-3xl font-bold">My Exercise Stats</h1>
      <a href="index.php" class="btn btn-ghost">Back to My Exercises</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <div class="card bg-base-100 shadow-soft overflow-hidden">
        <div class="card-body">
          <h2 class="card-title">Last 12 Weeks</h2>
          <div class="overflow-x-auto mt-4">
            <table class="table w-full">
              <thead class="bg-base-200">
                <tr><th>Week</th><th>Minutes</th><th>Calories</th></tr>
              </thead>
              <tbody>
              <?php if (!$weeklyRows): ?>
                <tr><td colspan="3" class="py-6 text-center text-base-content/70">No data</td></tr>
              <?php else: foreach ($weeklyRows as $r): ?>
                <tr>
                  <td><?= htmlspecialchars($r['weeknum']) ?></td>
                  <td><?= (int)$r['minutes'] ?></td>
                  <td><?= (int)$r['kcal'] ?></td>
                </tr>
              <?php endforeach; endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="card bg-base-100 shadow-soft overflow-hidden">
        <div class="card-body">
          <h2 class="card-title">Last 12 Months</h2>
          <div class="overflow-x-auto mt-4">
            <table class="table w-full">
              <thead class="bg-base-200">
                <tr><th>Month</th><th>Minutes</th><th>Calories</th></tr>
              </thead>
              <tbody>
              <?php if (!$monthlyRows): ?>
                <tr><td colspan="3" class="py-6 text-center text-base-content/70">No data</td></tr>
              <?php else: foreach ($monthlyRows as $r): ?>
                <tr>
                  <td><?= htmlspecialchars($r['ym']) ?></td>
                  <td><?= (int)$r['minutes'] ?></td>
                  <td><?= (int)$r['kcal'] ?></td>
                </tr>
              <?php endforeach; endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php require_once __DIR__ . '/inc/footer_ex.php'; ?>
