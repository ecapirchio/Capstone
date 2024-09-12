<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* Styles from your existing pages */
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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
        .header-left, .footer-left {
            display: flex;
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
        .main {
            flex: 1;
            padding: 20px;
            margin-top: 60px; /* To avoid content overlap with the fixed header */
            margin-bottom: 60px; /* To avoid content overlap with the fixed footer */
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
            <a href='admin_dashboard.php' class="header-button">Home</a>
            <a href="admin_addWorkout.php" class="header-button">Add Workouts</a>
            <a href="all_users.php" class="header-button">Users</a>
        </div>
        <div class="header-right">
            <div class="profile" onclick="toggleDropdown()">U</div>
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
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
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
