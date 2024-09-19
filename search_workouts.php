<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Workouts</title>
    <style>
        body, h1, p {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            padding-bottom: 60px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #2196F3;
            padding: 10px;
            position: fixed;
            top: 0;
            width: 100%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .header-left {
            display: flex;
        }

        .header-button {
            background: none;
            border: none;
            color: white;
            font-size: 16px;
            margin-right: 15px;
            cursor: pointer;
        }

        .header-button:hover {
            text-decoration: underline;
        }

        .header-right {
            display: flex;
            align-items: center;
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
            z-index: 1000;
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

        .search-bar {
            text-align: center;
            margin: 20px;
        }

        .search-bar form {
            display: inline-block;
            margin-top: 10px;
        }

        .search-bar input[type="text"] {
            font-size: 16px;
            padding: 8px;
            border: 2px solid #ddd;
            border-radius: 4px;
            width: 300px;
        }

        .search-bar button {
            font-size: 16px;
            padding: 10px 20px;
            background-color: #2196F3;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #1976D2;
        }

        .search-bar select {
            font-size: 16px;
            padding: 8px;
            border: 2px solid #ddd;
            border-radius: 4px;
            margin-left: 10px;
            cursor: pointer;
        }

        .search-bar select:focus {
            border-color: #2196F3;
        }

        .result-container {
            margin: 20px;
        }

        .result-item {
            background-color: #F0F8FF;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .result-item h2 {
            margin: 0;
            font-size: 18px;
        }

        .result-item p {
            margin: 5px 0;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-left">
            <button class="header-button">Home</button>
            <a href="workouts.php" class="header-button">Workouts</a>
        </div>
        <div class="header-right">
            <div class="profile" onclick="toggleDropdown()">P</div>
            <div class="dropdown" id="profileDropdown">
                <a href="#">Hello, </a>
                <a href="#">Profile</a>
                <a href="settings.php">Settings</a>
                <a href="logout.php">Log Out</a>
            </div>
        </div>
    </header>

    <div class="search-bar">
        <form action="search_workouts.php" method="get">
            <input type="text" name="query" placeholder="Search workouts..." required>
            <select name="workout_type">
                <option value="">Select Workout Type</option>
                <option value="cardio">Cardio</option>
                <option value="strength">Strength Training</option>
                <option value="flexibility">Flexibility</option>
                <option value="balance">Balance</option>
            </select>
            <button type="submit">Search</button>
        </form>
    </div>
    
    <main class="result-container">
        <?php
        
        $servername = "mysql.neit.edu";
        $port = 5500;
        $username = "capstone_202440_capirchio";
        $password = "008018071";
        $dbname = "capstone_202440_capirchio";

        $conn = new mysqli($servername, $username, $password, $dbname, $port);

        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = isset($_GET['query']) ? $_GET['query'] : '';
        $workout_type = isset($_GET['workout_type']) ? $_GET['workout_type'] : '';

        
        $sql = "SELECT * FROM workouts WHERE WorkoutName LIKE ?";

        if (!empty($workout_type)) {
            $sql .= " AND WorkoutType = ?";
        }

        $stmt = $conn->prepare($sql);

        if (!empty($workout_type)) {
            $search_query = "%$query%";
            $stmt->bind_param("ss", $search_query, $workout_type);
        } else {
            $search_query = "%$query%";
            $stmt->bind_param("s", $search_query);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='result-item'>";
                echo "<h2>" . htmlspecialchars($row['WorkoutName']) . "</h2>";
                echo "<p>" . htmlspecialchars($row['Descript']) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No results found</p>";
        }

        $stmt->close();
        $conn->close();
        ?>
    </main>

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
