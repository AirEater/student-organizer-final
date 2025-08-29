<?php
session_start();

// Ensure user is authenticated
require_once(__DIR__ . '/auth/auth.php');
require_once(__DIR__ . '/controllers/MoneyController.php');

$moneyController = new MoneyController();

// Basic routing
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'add_form':
        $moneyController->showAddForm();
        break;
    case 'add':
        $moneyController->addTransaction();
        break;
    case 'edit_form':
        $moneyController->showEditForm();
        break;
    case 'update':
        $moneyController->updateTransaction();
        break;
    case 'delete':
        $moneyController->deleteTransaction();
        break;
    case 'set_budget':
        $moneyController->setBudget();
        break;
    case 'index':
    default:
        $moneyController->index();
        break;
}
?>