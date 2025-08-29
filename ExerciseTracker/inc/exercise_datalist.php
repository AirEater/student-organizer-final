<?php
// inc/exercise_datalist.php
require_once __DIR__ . '/exercise_catalog.php';
render_exercise_datalist();
?>
<script>
// If the calories input is empty, auto-fill when an exercise is chosen.
document.addEventListener('DOMContentLoaded', function () {
  const nameInput = document.querySelector('input[name="exercise_name"]');
  const calInput  = document.querySelector('input[name="calories"]');
  if (!nameInput || !calInput) return;

  nameInput.addEventListener('change', async () => {
    try {
      const ex = nameInput.value.trim();
      if (!ex) return;
      // simple endpoint-less way: embed a map on page via data-* attributes
      // We'll call a tiny inline fetch using a generated JSON dataset.
    } catch (err) {}
  });
});
</script>
