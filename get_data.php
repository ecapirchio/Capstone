<?php

header('Content-Type: application/json');

include 'db_connect.php'; 

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit();
}

$sql = "SELECT calories, steps FROM user_stats WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userId);
$userId = 1;
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
