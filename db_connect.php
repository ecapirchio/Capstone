<?php
$servername = "sql.neit.edu\studentsqlserver,4500";
$db_username = "Capstone_Capirchio_202440";
$db_password = "008018071";
$dbname = "Capstone_Capirchio_202440";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
