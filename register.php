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
function createUser($username, $email, $name, $password) {
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (UName, Email, PW) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    $stmt->execute();
    $stmt->close();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Register'])) {
    $username = filter_input(INPUT_POST, 'username');
    $email = filter_input(INPUT_POST, 'email');
    $name = filter_input(INPUT_POST, 'name'); // Assuming 'name' is also part of your users table
    $password = filter_input(INPUT_POST, 'password');

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
            createUser($username, $email, $name, $password);
            header('Location: login.php');
            exit;
        }
    }
} elseif (isset($_POST['Cancel'])) {
    header('Location: login.php');
    exit;
}

// Load the registration form view
require ('../register.view.php');
?>

