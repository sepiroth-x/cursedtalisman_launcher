<?php


session_destroy(); // Destroy all session data

// Set session variable to indicate logout status
$_SESSION['logged_out'] = true;

// Redirect to index.php after logout
header("Location: ../index.php");
exit();


?>