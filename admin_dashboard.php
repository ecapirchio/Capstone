<?php
session_start();
include 'db_connect.php';

if (!isset($conn)) {
    die("Database connection not established.");
}


$sql = "SELECT UserID, UName FROM users";
$result = $conn->query($sql);

$users = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}


$sql = "SELECT WorkoutID, WorkoutName FROM workouts";
$result = $conn->query($sql);

$workouts = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $workouts[] = $row;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id']) && isset($_POST['workout_id'])) {
    $user_id = intval($_POST['user_id']);
    $workout_id = intval($_POST['workout_id']);

   
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
            position: relative;
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
        .header-right {
            position: relative;
        }
        .profile {
            background: #fff;
            color: #2196F3;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            cursor: pointer;
        }
        .dropdown {
            display: none;
            position: absolute;
            top: 40px;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            width: 150px;
            z-index: 1000;
        }
        .dropdown a {
            display: block;
            padding: 10px;
            color: #2196F3;
            text-decoration: none;
        }
        .dropdown a:hover {
            background: #f1f1f1;
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
        .footer {
            background-color: #2196F3;
            color: white;
            text-align: center;
            padding: 10px 20px;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-left">
            <a href="admin_dashboard.php">Admin Dashboard</a>
            <a href="admin_addWorkout.php">Add Workouts</a>
            <a href="all_users.php">Users</a>
        </div>
        <div class="header-right">
            <div class="profile" onclick="toggleDropdown()">EC</div>
            <div class="dropdown" id="profileDropdown">
                <a href="#">Hello, </a>
                <a href="#">Profile</a>
                <a href="settings.php">Settings</a>
                <a href="logout.php">Log Out</a>
            </div>
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

    <footer class="footer">
        Workout Helper - Capirchio 2024©
    </footer>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }

       
        window.onclick = function(event) {
            const dropdown = document.getElementById('profileDropdown');
            if (!event.target.matches('.profile')) {
                if (dropdown.style.display === 'block') {
                    dropdown.style.display = 'none';
                }
            }
        }
    </script>
</body>
</html>
