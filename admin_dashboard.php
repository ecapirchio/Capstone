<?php
session_start(); // Ensure session management for admin login
include 'db_connect.php'; // Ensure this file path is correct

if (!isset($conn)) {
    die("Database connection not established.");
}

// Fetch all users
$sql = "SELECT UserID, UName FROM users";
$result = $conn->query($sql);

$users = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Fetch all workouts
$sql = "SELECT WorkoutID, WorkoutName FROM workouts";
$result = $conn->query($sql);

$workouts = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $workouts[] = $row;
    }
}

// Handle adding a workout to a user's list
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id']) && isset($_POST['workout_id'])) {
    $user_id = intval($_POST['user_id']);
    $workout_id = intval($_POST['workout_id']);

    // Prepare statement to avoid SQL injection
    $stmt = $conn->prepare("INSERT INTO user_stats (UserID, WorkoutID) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $workout_id);

    if ($stmt->execute()) {
        echo "Workout added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .header {
            background-color: #2196F3;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }
        .header-left {
            display: flex;
            gap: 20px;
        }
        .header-left a {
            color: white;
            text-decoration: none;
            font-size: 1.5em;
        }
        .main {
            flex: 1;
            padding: 20px;
        }
        form {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            margin: auto;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        select, button {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        button {
            background-color: #2196F3;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 1em;
        }
        button:hover {
            background-color: #1976D2;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-left">
            <a href="admin_dashboard.php">Admin Dashboard</a>
            <a href="user_home.php">Home</a>
        </div>
    </header>

    <div class="main">
        <h1>Admin Dashboard</h1>
        <form action="admin_dashboard.php" method="post">
            <label for="user_id">Select User:</label>
            <select id="user_id" name="user_id" required>
                <option value="">--Select User--</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?php echo htmlspecialchars($user['UserID']); ?>">
                        <?php echo htmlspecialchars($user['UName']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="workout_id">Select Workout:</label>
            <select id="workout_id" name="workout_id" required>
                <option value="">--Select Workout--</option>
                <?php foreach ($workouts as $workout): ?>
                    <option value="<?php echo htmlspecialchars($workout['WorkoutID']); ?>">
                        <?php echo htmlspecialchars($workout['WorkoutName']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Add Workout to User</button>
        </form>
    </div>
</body>
</html>
