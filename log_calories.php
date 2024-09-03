<?php
// log_calories.php

header('Content-Type: application/json');

$servername = "mysql.neit.edu";
$username = "capstone_202440_capirchio";
$password = "008018071";
$dbname = "capstone_202440_capirchio";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

$calories = intval($_POST['calories']);

$sql = "UPDATE user_stats SET calories = calories + ? WHERE UserID = ?"; // Replace ? with the actual user ID
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $calories, $userId); // Replace $userId with the actual user ID
$userId = 1; // For example purposes, set this to the current user's ID
$success = $stmt->execute();

echo json_encode(['success' => $success]);

$stmt->close();
$conn->close();
?>
