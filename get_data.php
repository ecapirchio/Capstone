<?php
header('Content-Type: application/json');

$servername = "mysql.neit.edu";
$username = "capstone_202440_capirchio";
$password = "008018071";
$dbname = "capstone_202440_capirchio";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch data
$sql = "SELECT calories, steps FROM user_data WHERE user_id = 1";
$result = $conn->query($sql);

$response = array();

if ($result->num_rows > 0) {
    // Fetch data
    $row = $result->fetch_assoc();
    $response['calories'] = $row['calories'];
    $response['steps'] = $row['steps'];
} else {
    $response['calories'] = 'N/A';
    $response['steps'] = 'N/A';
}

$conn->close();

// Output the response as JSON
echo json_encode($response);
?>
