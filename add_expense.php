<?php
header('Content-Type: application/json');
require 'db.php';

$title = $_POST['title'] ?? '';
$amount = $_POST['amount'] ?? '';
$expense_date = $_POST['expense_date'] ?? '';
$category = $_POST['category'] ?? '';
$notes = $_POST['notes'] ?? '';

if ($title && $amount && $expense_date && $category) {
    $stmt = $conn->prepare('INSERT INTO expenses (title, amount, expense_date, category, notes) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('sdsss', $title, $amount, $expense_date, $category, $notes);
    $success = $stmt->execute();
    echo json_encode(['success' => $success]);
} else {
    echo json_encode(['success' => false, 'error' => 'Missing fields']);
}
