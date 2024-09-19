<?php
session_start();
include 'db_connect.php';


if (!isset($conn)) {
    die("Database connection not established.");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['username']) && isset($_POST['password'])) {
        
        $user = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        
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

           
            if (password_verify($pass, $hashed_password)) {
                
                $_SESSION['username'] = $user;

                
                session_regenerate_id(true);

                
                header("Location: user_home.html");
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "Invalid username.";
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
