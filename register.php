<?php
session_start();
require 'db_connect.php'; // Ensure this file contains your database connection settings

$error_message = "";

// Helper function to find user by username
function findUserByUsername($username) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE UName = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_assoc();
}

// Helper function to find user by email
function findUserByEmail($email) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_assoc();
}

// Helper function to create user
function createUser($username, $email, $password) {
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (UName, Email, PW) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    $stmt->execute();
    $stmt->close();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['Register'])) {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        // Validate input and check for existing data
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message .= "Invalid email format. ";
        }

        if (empty($username) || empty($email) || empty($password)) {
            $error_message .= "Username, Email, and Password are required. ";
        } else {
            $existingUser = findUserByUsername($username);
            $existingEmail = findUserByEmail($email);

            if ($existingUser) {
                $error_message .= "Username already exists. ";
            }
            if ($existingEmail) {
                $error_message .= "Email already exists. ";
            }

            if (empty($error_message)) {
                createUser($username, $email, $password);
                header('Location: login.php'); // Redirect to login page
                exit;
            }
        }
    } elseif (isset($_POST['Cancel'])) {
        header('Location: login.php'); // Redirect to login page
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Workout Helper</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
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
            padding: 20px;
        }
        .right {
            background-color: white;
            flex: 1;
        }
        .title {
            font-size: 2.5em;
            margin-bottom: 20px;
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
            background-color: #fff;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            margin-top: 10px;
        }
        .form-group button.cancel {
            background-color: #f44336;
        }
        .error-message {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left">
            <div class="title">Register</div>
            <!-- Display error message if set -->
            <?php if (!empty($error_message)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
            <form method="POST" action="register.php">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="Register">Register</button>
                    <button type="submit" name="Cancel" class="cancel">Cancel</button>
                </div>
            </form>
        </div>
        <div class="right"></div>
    </div>
</body>
</html>
