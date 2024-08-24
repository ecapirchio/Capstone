<?php
session_start();
include 'db_connect.php'; // Ensure this file path is correct

// Check if $conn is set
if (!isset($conn)) {
    die("Database connection not established.");
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username and password are set
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Retrieve and sanitize form data
        $user = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        // Prepare and execute query
        $stmt = $conn->prepare("SELECT PW FROM users WHERE UName = ?");
        if ($stmt === false) {
            die("Failed to prepare the statement.");
        }

        $stmt->bind_param("s", $user);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            // Verify password
            if (password_verify($pass, $hashed_password)) {
                $_SESSION['username'] = $user;
                header("Location: home.html");
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "Username does not exist.";
        }

        $stmt->close();
    } else {
        echo "Username or password not set.";
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
