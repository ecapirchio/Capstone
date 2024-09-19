<?php

header('Content-Type: application/json');

include 'db_connect.php'; 

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

$steps = intval($_POST['steps']);

$sql = "UPDATE user_stats SET steps = steps + ? WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $steps, $userId);
$userId = 1;
$success = $stmt->execute();

echo json_encode(['success' => $success]);

$stmt->close();
$conn->close();
?>
