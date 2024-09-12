<?php
header('Content-Type: application/json');

include 'db_connect.php';

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = $_GET['query'];
$filter = $_GET['filter'];

$sql = "SELECT * FROM exercises WHERE name LIKE ?";

if ($filter === 'my-routines') {
    // Add additional filtering for 'my-routines'
    $sql .= " AND user_id = ?";
}

$stmt = $conn->prepare($sql);

$likeQuery = "%$query%";
if ($filter === 'my-routines') {
    $userId = 1; // Example user ID; you should use the actual user ID
    $stmt->bind_param("si", $likeQuery, $userId);
} else {
    $stmt->bind_param("s", $likeQuery);
}

$stmt->execute();
$result = $stmt->get_result();

$exercises = array();
while ($row = $result->fetch_assoc()) {
    $exercises[] = $row;
}

echo json_encode($exercises);

$stmt->close();
$conn->close();
?>
