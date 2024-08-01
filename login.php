<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        // Handle login
        $username = $_POST['username'];
        $password = $_POST['password'];
        // Validate and authenticate the user
        // Example: Check the username and password against a database
        echo "Login button clicked. Username: $username, Password: $password";
    } elseif (isset($_POST['register'])) {
        // Handle registration
        $username = $_POST['username'];
        $password = $_POST['password'];
        // Validate and register the user
        // Example: Insert the user details into a database
        echo "Register button clicked. Username: $username, Password: $password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Helper</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            height: 100%;
        }
        .left {
            background-color: #2196F3;
            color: white;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .right {
            background-color: white;
            flex: 1;
        }
        .title {
            font-size: 2em;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
            width: 100%;
            max-width: 300px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #F5F5F5;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 1em;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left">
            <div class="title">Workout Helper</div>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="login">Login</button>
                </div>
                <div class="form-group">
                    <button type="submit" name="register">Register</button>
                </div>
            </form>
        </div>
        <div class="right"></div>
    </div>
</body>
</html>
