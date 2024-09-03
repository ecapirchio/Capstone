<?php
session_start();
include 'db_connect.php'; // Ensure this file path is correct
include 'admin_dashboard.php'; // Include the PHP logic to fetch users

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

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Helper - Admin</title>
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
        .header, .footer {
            background-color: #2196F3;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }
        .header-left, .footer-left, .footer-right {
            display: flex;
            gap: 20px;
        }
        .header-left a, .footer-right a {
            color: white;
            text-decoration: none;
            font-size: 1.5em;
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
        .main {
            flex: 1;
            padding: 20px;
        }
        form {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        label, select, button {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }
        button {
            background-color: #2196F3;
            color: white;
            border: none;
            padding: 10px;
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
    <div class="header">
        <div class="header-left">
            <a href="admin_home.php">Dashboard</a>
            <a href="manage_workouts.php">Manage Workouts</a>
        </div>
        <div class="profile" onclick="toggleDropdown()">U</div>
        <div class="dropdown" id="profileDropdown">
            <a href="#">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?></a>
            <a href="profile.php">Profile</a>
            <a href="settings.php">Settings</a>
            <a href="logout.php">Log Out</a>
        </div>
    </div>

    <div class="main">
        <h1>Admin Dashboard</h1>
        <p>Welcome to the admin dashboard. From here, you can manage users, monitor activities, and adjust application settings.</p>

        <h2>Manage Users</h2>
        <ul>
            <?php foreach ($users as $user): ?>
                <li>
                    <?php echo htmlspecialchars($user['UName']); ?>
                    <form action="admin_dashboard.php" method="post">
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['UserID']); ?>">
                        <label for="workout_id_<?php echo htmlspecialchars($user['UserID']); ?>">Workout ID:</label>
                        <input type="number" id="workout_id_<?php echo htmlspecialchars($user['UserID']); ?>" name="workout_id" placeholder="Enter Workout ID" required>
                        <button type="submit">Add Workout</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="footer">
        <div class="footer-left">
            <span>Workout Helper - Capirchio 2024©</span>
        </div>
        <div class="footer-right">
            <a href="#">About</a>
            <a href="#">Contact</a>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById("profileDropdown");
            if (dropdown.style.display === "block") {
                dropdown.style.display = "none";
            } else {
                dropdown.style.display = "block";
            }
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.profile')) {
                var dropdowns = document.getElementsByClassName("dropdown");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.style.display === "block") {
                        openDropdown.style.display = "none";
                    }
                }
            }
        }
    </script>
</body>
</html>
