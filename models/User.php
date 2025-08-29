<?php
// models/User.php — robust version for your schema (username/email/password)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

class User {
    /** @var mysqli */
    private $con;

    public function __construct(?mysqli $mysqli = null) {
        if ($mysqli instanceof mysqli) {
            // If a connection is passed in (optional)
            $this->con = $mysqli;
            return;
        }

        // Load the app's DB config (defines $con and/or $host/$user/$password/$dbname)
        $cfg = __DIR__ . '/../config/database.php';
        if (!file_exists($cfg)) {
            throw new Exception("DB config not found: $cfg");
        }
        require $cfg; // expects $con OR $host/$user/$password/$dbname

        if (isset($con) && $con instanceof mysqli) {
            $this->con = $con;
        } else {
            if (!isset($host, $user, $password, $dbname)) {
                throw new Exception("DB connection not provided and config did not define \$con or credentials.");
            }
            $this->con = new mysqli($host, $user, $password, $dbname);
        }
        $this->con->set_charset('utf8mb4');
    }

    public function getUserById(int $id): ?array {
        $sql  = "SELECT user_id, username AS username, email, created_at
                 FROM users WHERE user_id = ? LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res ? $res->fetch_assoc() : null;
        $stmt->close();
        return $row ?: null;
    }

    public function getAllUsers(): array {
        $res = $this->con->query("SELECT user_id, username AS username, email, created_at
                                  FROM users ORDER BY user_id DESC");
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function createUser(string $username, string $email, string $password): int {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->con->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $username, $email, $hash);
        $stmt->execute();
        $id = $stmt->insert_id;
        $stmt->close();
        return $id;
    }
}
