<?php
// inc/exercise_catalog.php
// Lightweight CSV-backed catalog for exercise lookups and suggestions.
// Place workout_data.csv in the ExerciseTracker folder (same level as this inc/).
// Encoding fallback supports latin1 (your file uses it).

function catalog_csv_path(): string {
    // Support both locations: ExerciseTracker/workout_data.csv and ExerciseTracker/data/workout_data.csv
    $candidates = [
        __DIR__ . '/../workout_data.csv',
        __DIR__ . '/../data/workout_data.csv',
    ];
    foreach ($candidates as $p) {
        if (is_file($p)) return $p;
    }
    return $candidates[0]; // default path even if missing
}

/**
 * Read CSV once per request.
 * @return array<int, array<string,mixed>>
 */
function catalog_all_rows(): array {
    static $CACHE = null;
    if ($CACHE !== null) return $CACHE;

    $file = catalog_csv_path();
    $rows = [];

    if (!is_file($file)) {
        $CACHE = $rows;
        return $rows;
    }

    // Try UTF-8 first; fallback to latin1
    $csv = @file_get_contents($file);
    if ($csv === false) {
        $CACHE = $rows;
        return $rows;
    }
    // Detect if it looks like UTF-8; otherwise convert
    if (!mb_check_encoding($csv, 'UTF-8')) {
        $csv = mb_convert_encoding($csv, 'UTF-8', 'ISO-8859-1');
    }

    $fh = fopen('php://memory', 'r+');
    fwrite($fh, $csv);
    rewind($fh);

    $header = fgetcsv($fh);
    if ($header === false) {
        fclose($fh);
        $CACHE = $rows;
        return $rows;
    }
    // Normalize header names
    $norm = [];
    foreach ($header as $h) {
        $key = strtolower(trim($h));
        $norm[] = $key;
    }

    while (($cols = fgetcsv($fh)) !== false) {
        if (count($cols) === 1 && $cols[0] === null) continue;
        $row = [];
        foreach ($cols as $i => $val) {
            $row[$norm[$i] ?? ('col'.$i)] = trim((string)$val);
        }
        // map standard fields
        $name  = $row['name'] ?? '';
        $cat   = $row['category'] ?? '';
        $steps = $row['steps to do'] ?? ($row['steps_to_do'] ?? '');
        $sets  = $row['sets'] ?? '';
        $reps  = $row['reps/duration'] ?? ($row['reps_duration'] ?? '');
        $cal   = $row['estimated_calories (kcal)'] ?? ($row['estimated_calories'] ?? '');

        // normalize calories to float
        $cal = str_replace([',','kcal'], ['.',''], strtolower((string)$cal));
        $cal = floatval(preg_replace('/[^0-9.\-]+/', '', $cal));

        $rows[] = [
            'name' => $name,
            'category' => $cat,
            'steps' => $steps,
            'sets' => $sets,
            'reps_duration' => $reps,
            'calories_est' => $cal,
        ];
    }
    fclose($fh);

    // De-duplicate by name (keep first)
    $seen = [];
    $unique = [];
    foreach ($rows as $r) {
        $n = mb_strtolower($r['name']);
        if (isset($seen[$n])) continue;
        $seen[$n] = true;
        $unique[] = $r;
    }
    $CACHE = $unique;
    return $unique;
}

/**
 * Get a case-insensitive map: name => calories_est
 * @return array<string,float>
 */
function catalog_name_to_calories(): array {
    $map = [];
    foreach (catalog_all_rows() as $r) {
        $map[mb_strtolower($r['name'])] = (float)$r['calories_est'];
    }
    return $map;
}

/**
 * Lookup a single exercise by name (case-insensitive). Returns null if not found.
 * @return array<string,mixed>|null
 */
function catalog_lookup(string $name) {
    $name = mb_strtolower(trim($name));
    foreach (catalog_all_rows() as $r) {
        if (mb_strtolower($r['name']) === $name) return $r;
    }
    return null;
}

/**
 * Build HTML <datalist> for use with the exercise_name <input list="exerciseCatalog">
 * Echoes the element; call once on the form page.
 */
function render_exercise_datalist(): void {
    $rows = catalog_all_rows();
    echo '<datalist id="exerciseCatalog">';
    foreach ($rows as $r) {
        // show category as a hint
        $label = htmlspecialchars($r['name'] . ' — ' . $r['category']);
        $name  = htmlspecialchars($r['name']);
        echo "<option value=\"{$name}\" label=\"{$label}\"></option>";
    }
    echo '</datalist>';
}
