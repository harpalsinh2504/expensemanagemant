<?php
require 'db.php';

$id = $_POST['id'];
$title = $_POST['title'];
$amount = $_POST['amount'];
$date = $_POST['expense_date'];
$category = $_POST['category'];
$notes = $_POST['notes'];

if (!$id || !$title || !$amount || !$date || !$category) {
    echo json_encode(['success' => false, 'error' => 'Missing fields']);
    exit;
}

$stmt = $conn->prepare("UPDATE expenses SET title=?, amount=?, expense_date=?, category=?, notes=? WHERE id=?");
$stmt->bind_param("sdsssi", $title, $amount, $date, $category, $notes, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'DB error']);
}
?>
