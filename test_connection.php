<?php
include 'db_connect.php';

if (isset($conn)) {
    echo "Database connection established successfully!";
} else {
    echo "Database connection failed!";
}
?>
