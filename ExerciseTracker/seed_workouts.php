<?php
// Run once: http://localhost/StudentRoutineOrganizer/ExerciseTracker/seed_workouts.php
$csv = __DIR__ . '/workout_data.csv';
$out = __DIR__ . '/workouts_catalog.json';

if (!is_file($csv)) { exit('Put workout_data.csv into ExerciseTracker/ first.'); }

if (($fh = fopen($csv, 'r')) === false) { exit('Failed to open CSV'); }
$header = fgetcsv($fh);
$map = array_flip($header);

$catalog = [];
while (($row = fgetcsv($fh)) !== false) {
  $name = trim($row[$map['Name']] ?? '');
  if (!$name) continue;
  $catalog[$name] = [
    'category'       => $row[$map['Category']] ?? '',
    'steps'          => $row[$map['Steps to do']] ?? '',
    'sets'           => $row[$map['Sets']] ?? '',
    'reps_or_time'   => $row[$map['Reps/Duration']] ?? '',
    'estimated_cals' => (int)preg_replace('/\D+/', '', $row[$map['Estimated_Calories (kcal)']] ?? '0'),
  ];
}
fclose($fh);

file_put_contents($out, json_encode($catalog, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
echo "OK. Generated workouts_catalog.json with ".count($catalog)." items.";
