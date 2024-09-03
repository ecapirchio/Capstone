<?php
// Connect to the database
$servername = "mysql.neit.edu";
$port = 5500;
$username = "capstone_202440_capirchio";
$password = "008018071";
$database = "capstone_202440_capirchio";

$conn = new mysqli($servername, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch workouts
$sql = "SELECT WorkoutID, WorkoutName, Description FROM workouts";
$result = $conn->query($sql);

$workouts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $workouts[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Workouts</title>
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
        .workout-list {
            margin: 20px;
            padding: 10px;
        }
        .workout-item {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .workout-item h3 {
            margin: 0 0 5px 0;
        }
        .workout-item p {
            margin: 0;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-left">
            <a href="admin_home.php" class="header-button">Home</a>
            <a href="workouts.php" class="header-button">Workouts</a>
        </div>
        <div class="header-right">
            <div class="profile" onclick="toggleDropdown()">U</div>
            <div class="dropdown" id="profileDropdown">
                <a href="#">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?></a>
                <a href="#">Profile</a>
                <a href="settings.php">Settings</a>
                <a href="logout.php">Log Out</a>
            </div>
        </div>
    </header>

    <div class="workout-list">
        <h1>Available Workouts</h1>
        <?php foreach ($workouts as $workout): ?>
            <div class="workout-item">
                <h3><?php echo htmlspecialchars($workout['WorkoutName']); ?> (ID: <?php echo htmlspecialchars($workout['WorkoutID']); ?>)</h3>
                <p><?php echo htmlspecialchars($workout['Description']); ?></p>
            </div>
        <?php endforeach; ?>
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
