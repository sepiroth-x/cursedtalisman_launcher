<?php

// Check if the user is logged in
if(isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
    // User is logged in, retrieve user data
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];

    // You can now use $user_id and $username to retrieve additional user data from the database if needed
    // For example:
    // Query the database to retrieve user details based on $user_id or $username
    // Display the user's details on the dashboard or any other page
    include '../contents/header.php';
    include '../contents/dashboard.php';
   // header("Location: ../contents/dashboard/");
} else {
    // User is not logged in, redirect to login page
    header("Location: ../login.php");
    exit(); // Stop further execution
}
include '../contents/footer.php';
?>
