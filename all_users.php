<?php
session_start();
include 'db_connect.php'; // Include the database connection

// Fetch all users
$sql = "SELECT UserID, UName, PW, Email FROM users";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 1200px;
            margin: 80px auto 60px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #2196F3;
            color: white;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-left">
            <a href="admin_dashboard.php" class="header-button">Home</a>
            <a href="admin_addWorkout.php" class="header-button">Workouts</a>
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
        <h1>Users List</h1>
        <?php
        if ($result->num_rows > 0) {
            echo "<table>
                    <thead>
                        <tr>
                            <th>UserID</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>";
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["UserID"]) . "</td>
                        <td>" . htmlspecialchars($row["UName"]) . "</td>
                        <td>" . htmlspecialchars($row["PW"]) . "</td>
                        <td>" . htmlspecialchars($row["Email"]) . "</td>
                      </tr>";
            }
            echo "  </tbody>
                  </table>";
        } else {
            echo "<p>No users found.</p>";
        }
        $conn->close();
        ?>
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
