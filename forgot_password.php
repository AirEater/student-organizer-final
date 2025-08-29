<?php
session_start();
require_once __DIR__ . '/config/database.php'; 

$pdo = $GLOBALS['pdo'];

$message = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $newPassword = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);

    if (strlen($newPassword) < 6) {
        $message = "Password must be at least 6 characters long.";
    } elseif ($newPassword !== $confirmPassword) {
        $message = "Passwords do not match.";
    } else {

        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
          
            $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE users SET password = ? WHERE user_id = ?");
            $update->execute([$hashed, $user['user_id']]);

            $success = true;
            $message = "Password successfully reset. Redirecting to login...";
           
            header("refresh:2;url=auth/login.php");
        } else {
            $message = "No user found with that email.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

<div class="container" style="max-width:400px;">
    <h3 class="mb-4">Reset Password</h3>

    <?php if ($message): ?>
        <div class="alert <?= $success ? 'alert-success' : 'alert-danger' ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <?php if (!$success): ?>
    <form method="POST">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>New Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
    </form>
    <?php endif; ?>
</div>

</body>
</html>
