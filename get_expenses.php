<?php
require 'db.php';

$result = $conn->query("SELECT * FROM expenses ORDER BY id DESC");
$expenses = [];

while ($row = $result->fetch_assoc()) {
    $expenses[] = $row;
}

header('Content-Type: application/json');
echo json_encode($expenses);
