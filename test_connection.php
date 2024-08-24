<?php
include 'db_connect.php'; // Ensure this path is correct

if (isset($conn)) {
    echo "Database connection established successfully!";
} else {
    echo "Database connection failed!";
}
?>
