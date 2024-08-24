<?php
session_start();
include 'db_connect.php'; // Ensure this file contains your database connection settings

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Get UserID based on the username
$stmt = $conn->prepare("SELECT UserID FROM users WHERE UName = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($userID);
$stmt->fetch();
$stmt->close();

// Fetch user stats
$stmt = $conn->prepare("SELECT steps, calories, step_goal FROM user_stats WHERE UserID = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->bind_result($steps, $calories, $step_goal);
$stmt->fetch();
$stmt->close();

$conn->close();

// Output data as JSON for the client-side script
header('Content-Type: application/json');
echo json_encode([
    'steps' => $steps,
    'calories' => $calories,
    'step_goal' => $step_goal
]);
?>
