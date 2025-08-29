<?php

require_once __DIR__ . '/../config/database.php';

class MoneyModel {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function getTransactionsByUserId($userId, $month, $year, $categoryName = 'all', $searchTerm = '') {
        $sql = "SELECT t.*, c.name as category_name 
                FROM transactions t 
                JOIN categories c ON t.category_id = c.category_id 
                WHERE t.user_id = :user_id 
                AND MONTH(t.transaction_date) = :month 
                AND YEAR(t.transaction_date) = :year";

        $params = [':user_id' => $userId, ':month' => $month, ':year' => $year];

        if ($categoryName !== 'all') {
            $sql .= " AND c.name = :category_name";
            $params[':category_name'] = $categoryName;
        }

        if (!empty($searchTerm)) {
            $sql .= " AND t.description LIKE :search_term";
            $params[':search_term'] = "%" . $searchTerm . "%";
        }

        $sql .= " ORDER BY t.transaction_date DESC, t.created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTransactionById($transactionId, $userId) {
        $sql = "SELECT t.*, c.name as category_name 
                FROM transactions t 
                JOIN categories c ON t.category_id = c.category_id 
                WHERE t.transaction_id = :transaction_id AND t.user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':transaction_id' => $transactionId, ':user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addTransaction($userId, $type, $amount, $categoryId, $description, $date) {
        $sql = "INSERT INTO transactions (user_id, transaction_type, amount, category_id, description, transaction_date) VALUES (:user_id, :type, :amount, :category_id, :description, :date)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':user_id' => $userId,
            ':type' => $type,
            ':amount' => $amount,
            ':category_id' => $categoryId,
            ':description' => $description,
            ':date' => $date
        ]);
    }

    public function updateTransaction($transactionId, $userId, $type, $amount, $categoryId, $description, $date) {
        $sql = "UPDATE transactions 
                SET transaction_type = :type, amount = :amount, category_id = :category_id, description = :description, transaction_date = :date 
                WHERE transaction_id = :transaction_id AND user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':type' => $type,
            ':amount' => $amount,
            ':category_id' => $categoryId,
            ':description' => $description,
            ':date' => $date,
            ':transaction_id' => $transactionId,
            ':user_id' => $userId
        ]);
    }

    public function deleteTransaction($transactionId, $userId) {
        $sql = "DELETE FROM transactions WHERE transaction_id = :transaction_id AND user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':transaction_id' => $transactionId, ':user_id' => $userId]);
    }

    public function getFinancialSummary($userId, $month, $year) {
        $monthly_sql = "SELECT 
                    COALESCE(SUM(CASE WHEN transaction_type = 'income' THEN amount ELSE 0 END), 0) as total_income, 
                    COALESCE(SUM(CASE WHEN transaction_type = 'expense' THEN amount ELSE 0 END), 0) as total_expense 
                FROM transactions 
                WHERE user_id = :user_id 
                AND MONTH(transaction_date) = :month 
                AND YEAR(transaction_date) = :year";
        $stmt = $this->pdo->prepare($monthly_sql);
        $stmt->execute([':user_id' => $userId, ':month' => $month, ':year' => $year]);
        $summary = $stmt->fetch(PDO::FETCH_ASSOC);

        $end_of_month = date('Y-m-t', strtotime("$year-$month-01"));
        $balance_sql = "SELECT 
                            COALESCE(SUM(CASE WHEN transaction_type = 'income' THEN amount ELSE -amount END), 0) as balance
                        FROM transactions 
                        WHERE user_id = :user_id AND transaction_date <= :end_of_month";
        $balance_stmt = $this->pdo->prepare($balance_sql);
        $balance_stmt->execute([':user_id' => $userId, ':end_of_month' => $end_of_month]);
        $balance_data = $balance_stmt->fetch(PDO::FETCH_ASSOC);

        $summary['monthly_balance'] = $summary['total_income'] - $summary['total_expense'];
        $summary['accumulated_balance'] = $balance_data['balance'] ?? 0;
        return $summary;
    }

    public function getCategoriesByUserId($userId) {
        $sql = "SELECT name FROM categories WHERE user_id = :user_id ORDER BY name ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($categories)) {
            $default_categories = ["Food & Dining", "Transportation", "Salary", "Bills & Utilities", "Shopping", "Entertainment", "Health & Fitness", "Investment"];
            $this->addDefaultCategories($userId, $default_categories);
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':user_id' => $userId]);
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $categories;
    }

    private function addDefaultCategories($userId, $categories) {
        $sql = "INSERT INTO categories (user_id, name) VALUES (:user_id, :name)";
        $stmt = $this->pdo->prepare($sql);
        foreach ($categories as $category) {
            $stmt->execute([':user_id' => $userId, ':name' => $category]);
        }
    }

    public function getCategoryByName($userId, $name) {
        $sql = "SELECT category_id FROM categories WHERE user_id = :user_id AND LOWER(name) = LOWER(:name)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId, ':name' => $name]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);
        return $category ? $category['category_id'] : null;
    }

    public function addCategory($userId, $name) {
        $sql = "INSERT INTO categories (user_id, name) VALUES (:user_id, :name)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId, ':name' => $name]);
        return $this->pdo->lastInsertId();
    }

    public function getBudgetsByUserId($userId, $month, $year) {
        $budget_month = sprintf('%04d-%02d', $year, $month);

        $sql = "SELECT 
                    b.amount,
                    c.name as category_name,
                    (SELECT COALESCE(SUM(t.amount), 0) 
                     FROM transactions t 
                     WHERE t.user_id = b.user_id 
                       AND t.category_id = b.category_id 
                       AND t.transaction_type = 'expense'
                       AND MONTH(t.transaction_date) = :month 
                       AND YEAR(t.transaction_date) = :year) as spent
                FROM budgets b
                JOIN categories c ON b.category_id = c.category_id
                WHERE b.user_id = :user_id
                  AND b.budget_month = :budget_month";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':month' => $month,
            ':year' => $year,
            ':user_id' => $userId,
            ':budget_month' => $budget_month
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function setBudget($userId, $categoryId, $amount, $budget_month) {
        $sql = "INSERT INTO budgets (user_id, category_id, amount, budget_month, period) 
                VALUES (:user_id, :category_id, :amount, :budget_month, 'monthly')
                ON DUPLICATE KEY UPDATE amount = VALUES(amount)";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':user_id' => $userId,
            ':category_id' => $categoryId,
            ':amount' => $amount,
            ':budget_month' => $budget_month
        ]);
    }
}
?>