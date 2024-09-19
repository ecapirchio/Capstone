<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

$stmt = $conn->prepare("SELECT UserID FROM users WHERE UName = ?");
if ($stmt === false) {
    die("Failed to prepare the statement.");
}
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($userID);
$stmt->fetch();
$stmt->close();

$stmt = $conn->prepare("SELECT steps, calories, step_goal FROM user_stats WHERE UserID = ?");
if ($stmt === false) {
    die("Failed to prepare the statement.");
}
$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->bind_result($steps, $calories, $step_goal);

if ($stmt->fetch() === false) {
    $steps = 'N/A';
    $calories = 'N/A';
    $step_goal = 'N/A';
}

$stmt->close();

$searchResults = [];
if (isset($_GET['query']) || isset($_GET['workout_type'])) {
    $query = $_GET['query'] ?? '';
    $workoutType = $_GET['workout_type'] ?? '';

    $searchQuery = "SELECT * FROM workouts WHERE WorkoutName LIKE ?";

    if ($workoutType !== '') {
        $searchQuery .= " AND WorkoutType = ?";
        $stmt = $conn->prepare($searchQuery);
        if ($stmt === false) {
            die("Failed to prepare the statement.");
        }
        $paramType = 'ss';
        $paramValue = "%$query%";
        $stmt->bind_param($paramType, $paramValue, $workoutType);
    } else {
        $stmt = $conn->prepare($searchQuery);
        if ($stmt === false) {
            die("Failed to prepare the statement.");
        }
        $paramType = 's';
        $paramValue = "%$query%";
        $stmt->bind_param($paramType, $paramValue);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $searchResults[] = $row;
    }

    $stmt->close();
}

$conn->close();
 
header('Content-Type: application/json');
echo json_encode([
    'steps' => $steps,
    'calories' => $calories,
    'step_goal' => $step_goal,
    'searchResults' => $searchResults
]);
?>
