<?php
header('Content-Type: application/json');
require 'db.php';
$id = $_POST['id'] ?? '';
if ($id) {
    $stmt = $conn->prepare('DELETE FROM expenses WHERE id=?');
    $stmt->bind_param('i', $id);
    $success = $stmt->execute();
    echo json_encode(['success' => $success]);
} else {
    echo json_encode(['success' => false, 'error' => 'Missing id']);
}
?> 