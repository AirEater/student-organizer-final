<?php
session_start();
require_once __DIR__ . '/../auth/auth.php';
require_once __DIR__ . '/../config/database.php';
$pdo = $GLOBALS['pdo'];

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$userId = $_SESSION['user_id'];

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: view.php?message=Invalid entry ID");
    exit();
}

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM journal_entries WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $userId]);
$entry = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$entry) {
    header("Location: view.php?message=Entry not found");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $entry_date = $_POST['entry_date'];
    $mood = $_POST['mood'];
    $content = $_POST['content'];

    $stmt = $pdo->prepare("UPDATE journal_entries 
                           SET title = ?, entry_date = ?, mood = ?, content = ? 
                           WHERE id = ? AND user_id = ?");
    $stmt->execute([$title, $entry_date, $mood, $content, $id, $userId]);

    header("Location: view.php?message=Entry updated successfully!");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Diary Entry</title>
    <link rel="stylesheet" href="diary.css">
    <style>
        .form-container {
            background: #1c1c1c;
            padding: 20px;
            border-radius: 15px;
            width: 50%;
            margin: 40px auto;
            color: white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.6);
        }

        h2 {
            text-align: center;
            margin-bottom: 40px;
            color: #FFD700;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input[type="text"], input[type="date"], textarea, select {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 8px;
            margin-bottom: 15px;
            background: #2b2b2b;
            color: white;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .button-row {
            display: flex;
            justify-content: center;
            gap: 25px;
            margin-top: 20px;
        }
        .btn {
            padding: 10px 50px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            color: #fff;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            transition: 0.2s ease;
        }
        .btn-save { background: #4CAF50; }
        .btn-cancel { background: #f39c12; }
        .btn-back { background: #3498db; }
        .btn:hover { opacity: 0.85; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>✏️ Edit Diary Entry</h2>
        <form method="POST">
            <label for="title">Diary Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($entry['title']); ?>" required>

            <label for="content">Diary Description:</label>
            <textarea name="content" required><?php echo htmlspecialchars($entry['content']); ?></textarea>

            <label for="mood">Mood:</label>
            <select name="mood" required>
                <option value="😊 Happy" <?php if($entry['mood']=='😊 Happy') echo 'selected'; ?>>😊 Happy</option>
                <option value="😔 Sad" <?php if($entry['mood']=='😔 Sad') echo 'selected'; ?>>😔 Sad</option>
                <option value="😡 Angry" <?php if($entry['mood']=='😡 Angry') echo 'selected'; ?>>😡 Angry</option>
                <option value="😴 Tired" <?php if($entry['mood']=='😴 Tired') echo 'selected'; ?>>😴 Tired</option>
                <option value="😎 Excited" <?php if($entry['mood']=='😎 Excited') echo 'selected'; ?>>😎 Excited</option>
                <option value="🤔 Thoughtful" <?php if($entry['mood']=='🤔 Thoughtful') echo 'selected'; ?>>🤔 Thoughtful</option>
                <option value="🥴 Anxious" <?php if($entry['mood']=='🥴 Anxious') echo 'selected'; ?>>🥴 Anxious</option>
            </select>

            <label for="entry_date">Date:</label>
            <input type="date" name="entry_date" value="<?php echo $entry['entry_date']; ?>" required>

            <div class="button-row">
                <button type="submit" class="btn btn-save">Save Changes</button>
                <button type="reset" class="btn btn-cancel">Cancel</button>
                <a href="view.php" class="btn btn-back">Back to Entries</a>
            </div>
        </form>
    </div>
</body>
</html>