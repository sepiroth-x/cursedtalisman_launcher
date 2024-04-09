<?php
session_start();
include_once '../connection/db_account-config.php';


// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = ""; // Initialize error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];


    //implement hashing md5 hashing algorithm
    // Function to hash the password using MD5
    function hash_password($password) {
    return md5($password);
    }

    $hashed_password = hash_password($password);

    // Prepare a SQL query to retrieve user account based on username and password
    $stmt = $conn->prepare("SELECT * FROM t_account WHERE name = ? AND pwd = ?");
    
    // Check if the statement was prepared successfully
    if (!$stmt) {
        die("Error in SQL query: " . $conn->error);
    }
    
    $stmt->bind_param("ss", $username, $hashed_password);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User account found, set session variables and redirect to dashboard
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['accountid'];
        $_SESSION['username'] = $row['name'];
        //header("Location: ../dashboard");
        include 'load_dashboard.php';
        exit();
    } elseif ($result->num_rows == 0) {
        // User account not found, display error message
        $error = "Invalid username or password. Please try again.";
        echo "<script>alert('$error');</script>"; // Display JavaScript alert
    } else {
        // More than one user account found (unlikely), display error message
        $error = "Error: Multiple user accounts found.";
        echo "<script>alert('$error');</script>"; // Display JavaScript alert
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
