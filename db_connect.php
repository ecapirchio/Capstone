<?php
$servername = "mysql.neit.edu";
$port = 5500;
$username = "capstone_202440_capirchio";
$password = "008018071";
$dbname = "capstone_202440_capirchio";


$conn = new mysqli($servername, $username, $password, $dbname, $port);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . " - " . $conn->connect_errno);
}
?>
