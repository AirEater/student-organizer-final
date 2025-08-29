<?php
require_once __DIR__ . '/../models/MoneyModel.php';
require_once __DIR__ . '/../models/User.php';

class MoneyController {
    private $moneyModel;
    private $userModel;

    public function __construct() {
        $this->moneyModel = new MoneyModel();
        $this->userModel = new User();
    }

    public function index() {
        // User data for header
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        $username = $user['username'] ?? 'Guest';
        $userInitial = !empty($username) ? strtoupper(substr($username, 0, 1)) : '?';
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $hour = date('H');
        if ($hour < 12) {
            $greeting = "Good morning";
        } elseif ($hour < 18) {
            $greeting = "Good afternoon";
        } else {
            $greeting = "Good evening";
        }

        // Month and balance view navigation
        $currentMonth = isset($_GET['month']) ? (int)$_GET['month'] : date('n');
        $currentYear = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
        $balance_view = isset($_GET['balance_view']) && in_array($_GET['balance_view'], ['monthly', 'accumulated']) ? $_GET['balance_view'] : 'monthly';

        $dateObj = DateTime::createFromFormat('!m', $currentMonth);
        $monthName = $dateObj->format('F');
        $display_month_year = $monthName . ' ' . $currentYear;

        $prevMonth = $currentMonth - 1;
        $prevYear = $currentYear;
        if ($prevMonth == 0) {
            $prevMonth = 12;
            $prevYear--;
        }

        $nextMonth = $currentMonth + 1;
        $nextYear = $currentYear;
        if ($nextMonth == 13) {
            $nextMonth = 1;
            $nextYear++;
        }

        $base_link_params = "&balance_view=$balance_view";
        $prev_month_link = "money.php?month=$prevMonth&year=$prevYear" . $base_link_params;
        $next_month_link = "money.php?month=$nextMonth&year=$nextYear" . $base_link_params;

        // Financial data
        $filter_category = $_GET['category'] ?? 'all';
        $search_term = $_GET['search'] ?? '';

        $transactions = $this->moneyModel->getTransactionsByUserId($_SESSION['user_id'], $currentMonth, $currentYear, $filter_category, $search_term);
        $categories = $this->moneyModel->getCategoriesByUserId($_SESSION['user_id']);
        $summary = $this->moneyModel->getFinancialSummary($_SESSION['user_id'], $currentMonth, $currentYear);
        $budgets = $this->moneyModel->getBudgetsByUserId($_SESSION['user_id'], $currentMonth, $currentYear);

        // Determine which balance to display
        $display_balance = ($balance_view === 'monthly') ? $summary['monthly_balance'] : $summary['accumulated_balance'];

        // Load views
        include __DIR__ . '/../views/templates/header.php';
        include __DIR__ . '/../views/money_tracker.php';
        include __DIR__ . '/../views/templates/footer.php';
    }

    public function setBudget() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: money.php');
            exit;
        }
    
        $userId = $_SESSION['user_id'];
        $categoryName = $_POST['category'] ?? '';
        $amount = $_POST['amount'] ?? '';
        $month = $_POST['month'] ?? date('n');
        $year = $_POST['year'] ?? date('Y');

        // Create the YYYY-MM format string
        $budget_month = sprintf('%04d-%02d', $year, $month);
    
        if (empty($categoryName) || !isset($amount) || !is_numeric($amount) || $amount < 0) {
            $_SESSION['error_message'] = "Invalid budget data provided.";
            header("Location: money.php?month=$month&year=$year");
            exit;
        }
    
        $categoryId = $this->moneyModel->getCategoryByName($userId, $categoryName);
        if (!$categoryId) {
            $_SESSION['error_message'] = "Invalid category selected.";
            header("Location: money.php?month=$month&year=$year");
            exit;
        }
    
        try {
            // Call the updated model function with the budget_month
            $this->moneyModel->setBudget($userId, $categoryId, $amount, $budget_month);
            $_SESSION['success_message'] = "Budget set successfully for " . date('F Y', strtotime("$year-$month-01")) . "!";
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Error setting budget: " . $e->getMessage();
        }
    
        header("Location: money.php?month=$month&year=$year");
        exit;
    }

    public function showAddForm() {
        // User data for header
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        $username = $user['username'] ?? 'Guest';
        $userInitial = !empty($username) ? strtoupper(substr($username, 0, 1)) : '?';

        // Get categories for the dropdown
        $categories = $this->moneyModel->getCategoriesByUserId($_SESSION['user_id']);

        // Load the view for adding a transaction
        include __DIR__ . '/../views/add_transaction.php';
    }

    public function addTransaction() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            // Only allow POST requests
            header('Location: money.php?action=add_form');
            exit;
        }

        // --- Validation ---
        $errors = [];
        $type = $_POST['type'] ?? '';
        $categoryName = trim($_POST['category'] ?? '');
        $amount = $_POST['amount'] ?? '';
        $date = $_POST['date'] ?? '';
        $description = trim($_POST['description'] ?? '');
        $userId = $_SESSION['user_id'];
        $categoryId = null;

        if (empty($type) || !in_array($type, ['income', 'expense'])) {
            $errors[] = "Please select a valid transaction type.";
        }

        if ($categoryName === 'Other') {
            $otherCategory = trim($_POST['other_category'] ?? '');
            if (empty($otherCategory)) {
                $errors[] = "Please specify your category.";
            } else {
                // Check if this category already exists for the user
                $categoryId = $this->moneyModel->getCategoryByName($userId, $otherCategory);
                if (!$categoryId) {
                    // Add the new category
                    $categoryId = $this->moneyModel->addCategory($userId, $otherCategory);
                }
            }
        } elseif (empty($categoryName)) {
            $errors[] = "Category is required.";
        } else {
            // It's a pre-existing category, get its ID
            $categoryId = $this->moneyModel->getCategoryByName($userId, $categoryName);
            if (!$categoryId) {
                // This case should ideally not happen if the dropdown is populated correctly
                $errors[] = "Invalid category selected.";
            }
        }

        if (empty($amount) || !is_numeric($amount) || $amount <= 0) {
            $errors[] = "Please enter a valid positive amount.";
        }
        if (empty($date) || !DateTime::createFromFormat('Y-m-d', $date)) {
            $errors[] = "Please enter a valid date.";
        }

        if (!empty($errors)) {
            $_SESSION['error_message'] = implode('<br>', $errors);
            header('Location: money.php?action=add_form');
            exit;
        }

        // --- Add Transaction ---
        if ($categoryId) {
            try {
                $this->moneyModel->addTransaction($userId, $type, $amount, $categoryId, $description, $date);
                $_SESSION['success_message'] = "Transaction added successfully! Add another one.";
            } catch (Exception $e) {
                $_SESSION['error_message'] = "Error adding transaction: " . $e->getMessage();
                header('Location: money.php?action=add_form');
                exit;
            }
        } else {
            $_SESSION['error_message'] = "Could not determine the category for the transaction.";
            header('Location: money.php?action=add_form');
            exit;
        }

        header('Location: money.php?action=add_form');
        exit;
    }

    public function showEditForm() {
        if (!isset($_GET['id'])) {
            header('Location: money.php');
            exit;
        }

        $transactionId = $_GET['id'];
        $userId = $_SESSION['user_id'];

        $transaction = $this->moneyModel->getTransactionById($transactionId, $userId);

        if (!$transaction) {
            // Transaction not found or doesn't belong to the user
            header('Location: money.php');
            exit;
        }

        $user = $this->userModel->getUserById($userId);
        $username = $user['username'] ?? 'Guest';
        $userInitial = !empty($username) ? strtoupper(substr($username, 0, 1)) : '?';

        $categories = $this->moneyModel->getCategoriesByUserId($userId);

        include __DIR__ . '/../views/edit_transaction.php';
    }

    public function updateTransaction() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: money.php');
            exit;
        }

        $errors = [];
        $transactionId = $_POST['transaction_id'] ?? '';
        $type = $_POST['type'] ?? '';
        $categoryName = trim($_POST['category'] ?? '');
        $amount = $_POST['amount'] ?? '';
        $date = $_POST['date'] ?? '';
        $description = trim($_POST['description'] ?? '');
        $userId = $_SESSION['user_id'];
        $categoryId = null;

        if (empty($transactionId)) {
            $errors[] = "Transaction ID is missing.";
        }

        if (empty($type) || !in_array($type, ['income', 'expense'])) {
            $errors[] = "Please select a valid transaction type.";
        }

        if ($categoryName === 'Other') {
            $otherCategory = trim($_POST['other_category'] ?? '');
            if (empty($otherCategory)) {
                $errors[] = "Please specify your category.";
            } else {
                $categoryId = $this->moneyModel->getCategoryByName($userId, $otherCategory);
                if (!$categoryId) {
                    $categoryId = $this->moneyModel->addCategory($userId, $otherCategory);
                }
            }
        } elseif (empty($categoryName)) {
            $errors[] = "Category is required.";
        } else {
            $categoryId = $this->moneyModel->getCategoryByName($userId, $categoryName);
            if (!$categoryId) {
                $errors[] = "Invalid category selected.";
            }
        }

        if (empty($amount) || !is_numeric($amount) || $amount <= 0) {
            $errors[] = "Please enter a valid positive amount.";
        }
        if (empty($date) || !DateTime::createFromFormat('Y-m-d', $date)) {
            $errors[] = "Please enter a valid date.";
        }

        if (!empty($errors)) {
            $_SESSION['error_message'] = implode('<br>', $errors);
            header('Location: money.php?action=edit_form&id=' . $transactionId);
            exit;
        }

        if ($categoryId) {
            try {
                $this->moneyModel->updateTransaction($transactionId, $userId, $type, $amount, $categoryId, $description, $date);
                $_SESSION['success_message'] = "Transaction updated successfully!";
            } catch (Exception $e) {
                $_SESSION['error_message'] = "Error updating transaction: " . $e->getMessage();
                header('Location: money.php?action=edit_form&id=' . $transactionId);
                exit;
            }
        } else {
            $_SESSION['error_message'] = "Could not determine the category for the transaction.";
            header('Location: money.php?action=edit_form&id=' . $transactionId);
            exit;
        }

        header('Location: money.php');
        exit;
    }

    public function deleteTransaction() {
        if (isset($_GET['id'])) {
            $transactionId = $_GET['id'];
            $userId = $_SESSION['user_id'];
            $this->moneyModel->deleteTransaction($transactionId, $userId);
        }
        header('Location: money.php');
        exit;
    }
}
?>