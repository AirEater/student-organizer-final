<?php
require_once __DIR__ . '/inc/header_ex.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$userId = (int)$_SESSION['user_id'];

$exercise = [
  'exercise_date'    => date('Y-m-d'),
  'exercise_name'    => '',
  'duration_minutes' => 30,
  'calories'         => 0,
  'notes'            => ''
];

if ($id) {
  $st = $pdo->prepare("SELECT * FROM exercises WHERE id = :id AND user_id = :uid LIMIT 1");
  $st->execute([':id' => $id, ':uid' => $userId]);
  $row = $st->fetch();
  if ($row) $exercise = $row;
}
?>

<main class="flex-grow">
  <section class="w-full max-w-screen-md mx-auto px-6 md:px-8 py-10">
    <div class="mb-6 flex items-center justify-between">
      <h1 class="text-2xl md:text-3xl font-bold"><?= $id ? 'Edit Exercise' : 'Add Exercise' ?></h1>
      <a href="index.php" class="btn btn-ghost">Back</a>
    </div>

    <form action="save.php" method="post" class="card bg-base-100 shadow-soft">
      <div class="card-body grid grid-cols-1 gap-4">
        <input type="hidden" name="id" value="<?= $id ?>">

        <label class="form-control">
          <div class="label"><span class="label-text">Date</span></div>
          <input type="date" name="exercise_date" required
                 value="<?= htmlspecialchars($exercise['exercise_date']) ?>"
                 class="input input-bordered w-full">
        </label>

        <label class="form-control">
          <div class="label"><span class="label-text">Exercise</span></div>
          <input type="text" name="exercise_name" required placeholder="Jogging, Gym, etc."
                 value="<?= htmlspecialchars($exercise['exercise_name']) ?>"
                 class="input input-bordered w-full">
        </label>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <label class="form-control">
            <div class="label"><span class="label-text">Duration (minutes)</span></div>
            <input type="number" min="1" name="duration_minutes" required
                   value="<?= (int)$exercise['duration_minutes'] ?>"
                   class="input input-bordered w-full">
          </label>

          <label class="form-control">
            <div class="label">
              <span class="label-text">Calories</span>
              <span class="label-text-alt text-base-content/60">Tip: set 0 to auto-estimate</span>
            </div>
            <input type="number" min="0" name="calories"
                   value="<?= (int)$exercise['calories'] ?>"
                   class="input input-bordered w-full">
          </label>
        </div>

        <label class="form-control">
          <div class="label"><span class="label-text">Notes (optional)</span></div>
          <textarea name="notes" rows="3" class="textarea textarea-bordered w-full"
                    placeholder="Any comments..."><?= htmlspecialchars($exercise['notes'] ?? '') ?></textarea>
        </label>

        <div class="mt-4 flex gap-2 justify-end">
          <button type="submit" class="btn btn-primary"><?= $id ? 'Save Changes' : 'Save' ?></button>
          <a href="index.php" class="btn btn-ghost">Cancel</a>
        </div>
      </div>
    </form>
  </section>
</main>

<?php require_once __DIR__ . '/inc/footer_ex.php'; ?>
