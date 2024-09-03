<?php
// get_data.php

header('Content-Type: application/json');

$servername = "mysql.neit.edu";
$username = "capstone_202440_capirchio";
$password = "008018071";
$dbname = "capstone_202440_capirchio";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit();
}

$sql = "SELECT calories, steps FROM user_stats WHERE UserID = ?"; // Replace ? with the actual user ID
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userId); // Replace $userId with the actual user ID
$userId = 1; // For example purposes, set this to the current user's ID
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['calories' => $row['calories'], 'steps' => $row['steps']]);
} else {
    echo json_encode(['calories' => 0, 'steps' => 0]);
}

$stmt->close();
$conn->close();
?>
