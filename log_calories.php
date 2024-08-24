<?php
session_start();
include 'db_connect.php'; // Ensure this file contains your database connection settings

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$calories = $_POST['calories'];

// Get UserID based on the username
$stmt = $conn->prepare("SELECT UserID FROM users WHERE UName = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($userID);
$stmt->fetch();
$stmt->close();

// Update calories in the database
$stmt = $conn->prepare("UPDATE user_stats SET calories = ? WHERE UserID = ?");
$stmt->bind_param("ii", $calories, $userID);
$success = $stmt->execute();
$stmt->close();
$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode(['success' => $success]);
?>
