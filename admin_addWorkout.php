<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Workout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .header, .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #2196F3;
            color: white;
            padding: 10px;
            position: fixed;
            width: 100%;
            z-index: 1000;
        }
        .header {
            top: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .footer {
            bottom: 0;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
        }
        .footer-left {
            display: flex;
        }
        .header-left {
            display: flex;
            gap: 20px;
        }
        .header-button, .footer-link {
            background: none;
            border: none;
            color: white;
            font-size: 16px;
            margin-right: 15px;
            cursor: pointer;
        }
        .header-button:hover, .footer-link:hover {
            text-decoration: underline;
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
            margin-left: auto;
            margin-right: 20px;
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
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 80px auto;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-group textarea {
            height: 100px;
        }
        .btn {
            background-color: #2196F3;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #1976D2;
        }
        .spacer {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-left">
            <a href='admin_dashboard.php' class="header-button">Home</a>
            <a href='all_users.php' class="header-button">Users</a>
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

    <div class="container">
        <h1>Add New Workout</h1>
        <form action="admin_addWorkout.php" method="post">
            <div class="form-group">
                <label for="workoutName">Title</label>
                <input type="text" id="workoutName" name="workoutName" required>
            </div>
            <div class="form-group">
                <label for="descript">Description</label>
                <textarea id="descript" name="descript" required></textarea>
            </div>
            <button type="submit" class="btn">Add Workout</button>
        </form>
    </div>

    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include 'db_connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $conn = new mysqli($servername, $username, $password, $dbname, $port);
        var_dump($conn);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Use AUTO_INCREMENT for WorkoutID to handle primary key automatically
        $stmt = $conn->prepare("INSERT INTO workouts (WorkoutName, Descript) VALUES (?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ss", $workoutName, $descript);

        $workoutName = $_POST['workoutName'];
        $descript = $_POST['descript'];

        if ($stmt->execute()) {
            echo "<p style='color: green;'>New workout added successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error adding workout: " . $stmt->error . "</p>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>

    <footer class="footer">
        <div class="footer-left">
            <button class="footer-link">About</button>
            <button class="footer-link">Contact</button>
        </div>
        <div class="footer-center">
            Workout Helper - Capirchio 2024©
        </div>
    </footer>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.style.display = dropdown.style.display === 'block';

        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.profile')) {
                const dropdowns = document.getElementsByClassName('dropdown');
                for (let i = 0; i < dropdowns.length; i++) {
                    const openDropdown = dropdowns[i];
                    if (openDropdown.style.display === 'block') {
                        openDropdown.style.display = 'none';
                    }
                }
            }
        }
    </script>
</body>
</html>
