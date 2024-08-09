<?php
/*if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        // Login
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        
        echo "Login button clicked. Username: $username, Password: $password";
    } elseif (isset($_POST['register'])) {
        // Register
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        echo "Register button clicked. Username: $username, Password: $password";
    }
}*/
?>

<?php
include 'db_connect.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prepare and execute SQL query
        $sql = "SELECT * FROM users WHERE UName = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['PW'];

            // Verify password
            if (password_verify($password, $hashed_password)) {
                // Start session and set session variables
                session_start();
                $_SESSION['username'] = $username;
                
                // Redirect to home.html
                header("Location: home.html");
                exit;
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "No account found with that username.";
        }

        $stmt->close();
    }
}

$conn->close();
?>
