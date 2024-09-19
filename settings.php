<?php
session_start();
include 'db_connect.php';

if (!isset($conn)) {
    die("Database connection not established.");
}


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save-goal'])) {
    
    $stepGoal = filter_input(INPUT_POST, 'step-goal', FILTER_SANITIZE_NUMBER_INT);

   
    if ($stepGoal > 0) {
        
        $username = $_SESSION['username'];

        
        $stmt = $conn->prepare("SELECT UserID FROM users WHERE UName = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($userID);
        $stmt->fetch();
        $stmt->close();

        if ($userID) {
            
            $stmt = $conn->prepare("UPDATE user_stats SET step_goal = ? WHERE UserID = ?");
            $stmt->bind_param("ii", $stepGoal, $userID);

            if ($stmt->execute()) {
                
                header("Location: user_home.php");
                exit();
            } else {
                echo "Error updating step goal: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "User not found.";
        }
    } else {
        echo "Invalid step goal. Please enter a positive number.";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Helper - Settings</title>
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
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .settings-title {
            color: #2196F3;
            font-size: 2em;
            margin: 20px 0;
        }
        .form-group {
            margin-bottom: 20px;
            width: 100%;
            max-width: 400px;
        }
        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-size: 1.2em;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #F5F5F5;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            font-size: 1.2em;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <a href="home.html">Home</a>
            <a href="#">Workouts</a>
        </div>
        <div class="profile" onclick="toggleDropdown()">U</div>
        <div class="dropdown" id="profileDropdown">
            <a href="#">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?></a>
            <a href="profile.html">Profile</a>
            <a href="settings.html">Settings</a>
            <a href="logout.html">Log Out</a>
        </div>
    </div>
    <div class="main">
        <h1 class="settings-title">Settings</h1>
        <form method="POST" action="settings.php">
            <div class="form-group">
                <label for="step-goal">Set Your Step Goal:</label>
                <input type="number" id="step-goal" name="step-goal" placeholder="Enter step goal" required>
                <button type="submit" name="save-goal">Save Goal</button>
            </div>
        </form>
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
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        }

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
