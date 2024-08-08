<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save-goal'])) {
    // Process the step goal here
    // Example: save the step goal to a database or session

    // Redirect to home.php after saving the goal
    header("Location: home.php");
    exit();
}
?>
