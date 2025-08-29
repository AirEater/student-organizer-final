<?php
require_once __DIR__ . '/inc/config_bridge.php';

function ex_all(PDO $pdo, int $userId, ?string $fromDate, ?string $toDate): array {
  $sql = "SELECT * FROM exercises WHERE user_id = :uid";
  $params = ['uid' => $userId];
  if ($fromDate) { $sql .= " AND exercise_date >= :fromd"; $params['fromd'] = $fromDate; }
  if ($toDate)   { $sql .= " AND exercise_date <= :tod";   $params['tod']   = $toDate; }
  $sql .= " ORDER BY exercise_date DESC, id DESC";
  $st = $pdo->prepare($sql);
  $st->execute($params);
  return $st->fetchAll();
}

function ex_find(PDO $pdo, int $id, int $userId): ?array {
  $st = $pdo->prepare("SELECT * FROM exercises WHERE id = :id AND user_id = :uid");
  $st->execute(['id'=>$id, 'uid'=>$userId]);
  $row = $st->fetch();
  return $row ?: null;
}

function ex_create(PDO $pdo, int $userId, string $name, int $mins, int $cals, string $date, ?string $notes): int {
  $st = $pdo->prepare(
    "INSERT INTO exercises (user_id, exercise_name, duration_minutes, calories, exercise_date, notes)
     VALUES (:uid, :name, :mins, :cals, :date, :notes)"
  );
  $st->execute([
    'uid'=>$userId, 'name'=>$name, 'mins'=>$mins, 'cals'=>$cals, 'date'=>$date, 'notes'=>$notes
  ]);
  return (int)$pdo->lastInsertId();
}

function ex_update(PDO $pdo, int $id, int $userId, string $name, int $mins, int $cals, string $date, ?string $notes): bool {
  $st = $pdo->prepare(
    "UPDATE exercises
     SET exercise_name=:name, duration_minutes=:mins, calories=:cals, exercise_date=:date, notes=:notes
     WHERE id=:id AND user_id=:uid"
  );
  return $st->execute([
    'name'=>$name, 'mins'=>$mins, 'cals'=>$cals, 'date'=>$date, 'notes'=>$notes, 'id'=>$id, 'uid'=>$userId
  ]);
}

function ex_delete(PDO $pdo, int $id, int $userId): bool {
  $st = $pdo->prepare("DELETE FROM exercises WHERE id=:id AND user_id=:uid");
  return $st->execute(['id'=>$id, 'uid'=>$userId]);
}

// exercise_model.php
function ex_stats(PDO $pdo, int $userId, string $period): array {
  // use ISO week numbers
  $group = ($period === 'WEEK')
    ? "YEARWEEK(exercise_date, 3)"
    : "DATE_FORMAT(exercise_date, '%Y-%m')";
  $sql = "SELECT $group AS grp, SUM(duration_minutes) AS total_minutes, SUM(calories) AS total_cals
          FROM exercises WHERE user_id=:uid
          GROUP BY $group
          ORDER BY MIN(exercise_date) DESC
          LIMIT 12";
  $st = $pdo->prepare($sql);
  $st->execute(['uid'=>$userId]);
  return $st->fetchAll();
}

