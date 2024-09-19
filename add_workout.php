<?php
session_start();
include 'db_connect.php';

if (!isset($conn)) {
    die("Database connection not established.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user']) && isset($_POST['workout']) && isset($_POST['date']) && isset($_POST['duration']) && isset($_POST['steps']) && isset($_POST['calories']) && isset($_POST['step_goal'])) {
    $user = $_POST['user'];
    $workout = $_POST['workout'];
    $date = $_POST['date'];
    $duration = $_POST['duration'];
    $steps = $_POST['steps'];
    $calories = $_POST['calories'];
    $step_goal = $_POST['step_goal'];


    $stmt = $conn->prepare("SELECT UserID FROM users WHERE UName = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->bind_result($userID);
    $stmt->fetch();
    $stmt->close();

    if ($userID) {
        
        $stmt = $conn->prepare("SELECT WorkoutID FROM workouts WHERE WorkoutName = ?");
        $stmt->bind_param("s", $workout);
        $stmt->execute();
        $stmt->bind_result($workoutID);
        $stmt->fetch();
        $stmt->close();

        if ($workoutID) {
            
            $stmt = $conn->prepare("INSERT INTO user_stats (UserID, WorkoutID, Date, Duration, Steps, Calories, StepGoal)
                                    VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iissiii", $userID, $workoutID, $date, $duration, $steps, $calories, $step_goal);

            if ($stmt->execute()) {
                echo "Workout added successfully.";
            } else {
                echo "Error adding workout: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Workout not found.";
        }
    } else {
        echo "User not found.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Workout</title>
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
        .profile {
            position: relative;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #2196F3;
            font-size: 1.2em;
            font-weight: bold;
            cursor: pointer;
        }
        .dropdown {
            display: none;
            position: absolute;
            top: 60px;
            right: 0;
            background-color: white;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
            width: 200px;
        }
        .dropdown a {
            display: block;
            padding: 10px;
            color: black;
            text-decoration: none;
        }
        .dropdown a:hover {
            background-color: #f1f1f1;
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
        input[type="text"], input[type="date"], input[type="number"] {
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
            padding: 10px 20px;
            border-radius: 4px;
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
            <a href="user_home.php">Home</a>
        </div>
        <div class="header-right">
            <div class="profile" onclick="toggleDropdown()">U</div>
            <div class="dropdown" id="profileDropdown">
                <?php if (isset($_SESSION['username'])): ?>
                    <a href="#">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?></a>
                    <a href="#">Profile</a>
                    <a href="settings.php">Settings</a>
                    <a href="logout.php">Log Out</a>
                <?php else: ?>
                    <a href="login.php">Log In</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <div class="main">
        <h1>Add Workout</h1>
        <form action="add_workout.php" method="post">
            <input type="hidden" name="user" value="<?php echo htmlspecialchars($_GET['user']); ?>">
            <label for="workout">Workout:</label>
            <input type="text" id="workout" name="workout" required>
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>
            <label for="duration">Duration (minutes):</label>
            <input type="number" id="duration" name="duration" required>
            <label for="steps">Steps:</label>
            <input type="number" id="steps" name="steps" required>
            <label for="calories">Calories:</label>
            <input type="number" id="calories" name="calories" required>
            <label for="step_goal">Step Goal:</label>
            <input type="number" id="step_goal" name="step_goal" required>
            <button type="submit">Add Workout</button>
        </form>
    </div>

    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById('profileDropdown');
            if (dropdown.style.display === 'none' || dropdown.style.display === '') {
                dropdown.style.display = 'block';
            } else {
                dropdown.style.display = 'none';
            }
        }
    </script>
</body>
</html>
