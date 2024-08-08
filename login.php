<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
}
?>
