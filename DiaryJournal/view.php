<?php
session_start();
require_once __DIR__ . '/../auth/auth.php';
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch all entries for the user, ordered by date descending
$stmt = $pdo->prepare("SELECT * FROM journal_entries WHERE user_id = ? ORDER BY entry_date DESC, id DESC");
$stmt->execute([$userId]);
$entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group entries by date
$groupedEntries = [];
foreach ($entries as $entry) {
    $groupedEntries[$entry['entry_date']][] = $entry;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Diary Entries</title>
    <link rel="stylesheet" href="diary.css">
    <style>
        .entries-container {
            background: #203655;
            padding: 20px;
            border-radius: 15px;
            margin: 20px auto;
            width: 85%;
            color: white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.6);
        }

        h2, h3 {
            text-align: center;
            margin-bottom: 10px;
            color: #f6f1e5;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: #f6f1e5;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 30px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #444;
            text-align: left;
            color: black;
        }

        th {
            background: #d9c1a1;
            font-weight: bold;
            color: black;
        }

        tr:hover {
            background: #d9c1a1;
        }

        .action-buttons {
    display: flex;
    gap: 10px; /* space between buttons */
}

.action-buttons .action-btn {
    flex: 1; /* both buttons take equal width */
    padding: 8px 0; /* vertical padding */
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    font-weight: bold;
    text-align: center;
    transition: 0.3s;
}

        .edit-btn {
            background: #3498db;
            color: black;
        }

        .edit-btn:hover {
            background: #2980b9;
            color: white;
        }

        .delete-btn {
            background: white;
            color: black;
        }

        .delete-btn:hover {
            background: #c0392b;
            color: white;
        }

        .back-btn {
            display: block;
            width: 200px;
            margin: 20px auto 0;
            padding: 10px;
            text-align: center;
            background: #d9c1a1;
            color: black;
            font-weight: bold;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s;
        }

        .back-btn:hover {
            background: #45a049;
            color: white;
        }

        .success-message {
            background: #4CAF50;
            color: white;
            padding: 10px;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="entries-container">
        <h2>Diary Entries History</h2>

        <?php if (isset($_GET['message'])): ?>
            <div class="success-message">
                <?= htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>

        <?php if ($groupedEntries): ?>
            <?php foreach ($groupedEntries as $date => $entriesByDate): ?>
                <h3><?= htmlspecialchars($date) ?></h3>
                <table>
                    <tr>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Mood</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($entriesByDate as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td><?= htmlspecialchars($row['content']) ?></td>
                            <td><?= htmlspecialchars($row['mood']) ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="edit.php?id=<?= $row['id'] ?>" class="action-btn edit-btn">Edit</a>
                                    <a href="delete.php?id=<?= $row['id'] ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure?');">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align:center;">No entries found.</p>
        <?php endif; ?>

        <a href="diary.php" class="back-btn">Back to Diary</a>
    </div>
</body>
</html>