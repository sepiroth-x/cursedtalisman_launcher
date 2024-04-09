<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    // User is not logged in, redirect to login page
    header("Location: ../login.php");
    exit(); // Stop further execution
}

// Database connection parameters
$servername = "192.168.1.99"; // Change this to your database server hostname
$username = "kiddiekeyk"; // Change this to your database username
$password = "anonymouswhite143"; // Change this to your database password
$database = "db_account"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query
$sql = "SELECT * FROM t_account"; // Change this to your table name and query

// Execute query
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["accountid"] . " - Name: " . $row["name"] . "<br>";
        // Change "id" and "name" to your actual column names

        // Specify the path to your HTML file
        $html_file_path = 'contents/dashboard3.html';

        // Load the HTML file into a string
        $html_content = file_get_contents($html_file_path);

        // Output the HTML content
        echo $html_content;
    }
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>
