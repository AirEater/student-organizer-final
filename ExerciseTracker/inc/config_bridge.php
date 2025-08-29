<?php
// ExerciseTracker/inc/config_bridge.php
// Bridge the tracker to the dashboard's DB + set base paths.

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

/**
 * ABSOLUTE base paths for links/redirects. Adjust if your URL is different.
 * Example install: http://localhost/student_organizer/
 */
if (!defined('ROOT_BASE')) define('ROOT_BASE', '/student_organizer');
if (!defined('EX_BASE'))   define('EX_BASE',   ROOT_BASE . '/ExerciseTracker');

// 1) Load the app's mysqli config (correct relative path from /inc/)
$cfg = dirname(__DIR__, 2) . '/config/database.php'; // -> .../student_organizer/config/database.php
if (!is_file($cfg)) {
  throw new RuntimeException("DB config not found: $cfg");
}
require_once $cfg; // should define $con (mysqli) and often $host,$user,$password,$dbname

// 2) Create a PDO handle ($pdo) so ExerciseTracker code can use PDO.
if (!isset($pdo) || !($pdo instanceof PDO)) {
  // Try to use explicit credentials if provided by database.php
  if (isset($host, $user, $password, $dbname) && $host !== '' && $dbname !== '') {
    $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $password, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
  } else {
    // Fallback: derive db name from mysqli and assume localhost credentials
    if (!isset($con) || !($con instanceof mysqli)) {
      throw new RuntimeException('No mysqli connection ($con) available from database.php.');
    }
    $res = $con->query('SELECT DATABASE() AS db');
    $row = $res ? $res->fetch_assoc() : null;
    $db  = $row && !empty($row['db']) ? $row['db'] : 'student_organizer';
    $dsn = "mysql:host=127.0.0.1;dbname={$db};charset=utf8mb4";
    $pdo = new PDO($dsn, 'root', '', [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
  }
}
