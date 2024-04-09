<?php
include '../connection/db_account-config.php';
include '../connection/db_players-config.php';
#include '../contents/dashboard/register/index.php';




// Create connection
$conn1 = new mysqli($servername, $username, $password, $database);
$conn2 = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn1->connect_error) {
    die("Connection failed: " . $conn1->connect_error);
}

if ($conn2->connect_error) {
    die("Connection failed: " . $conn2->connect_error);
}


$error = ""; // Initialize error message variable


// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Prepare and bind the SQL statement

    $stmt1 = $conn1->prepare("INSERT INTO t_account (name, pwd, pw2) VALUES (?, ?, ?)");
    $stmt1->bind_param("sss", $username, $hashed_password, $password);

    $stmt2 = $conn2->prepare("INSERT INTO users (firstname, middlename, lastname, email) VALUES (?, ?, ?, ?)");
    $stmt2->bind_param("ssss", $firstName, $middleName, $lastName, $email);
    
    // Set parameters and execute
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
   
    // Note: Please hash the password before storing it in the database for security reasons
    
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords don\\'t match! Please re-check!');</script>";
    }


    function hash_password($password) {
        return md5($password);
    }
    
    $hashed_password = hash_password($password);

    // Execute the first statement
    if ($stmt1->execute()) {
        $response = "success"; // Account creation successful
        echo "<script>alert('Account created! You can now login!');</script>";
        echo "creation successful";
    } else {
        echo "Error: " . $stmt1->error;
        $response = "error"; // Account creation failed
        echo "failed creation!";
    }

    // // Close statement
    $stmt1->close();

    //Execute the second statement
    if ($stmt2->execute()) {
        $response = "success"; // User creation successful
    } else {
        echo "Error: " . $stmt2->error;
        $response = "error"; // User creation failed
    }

    // Close statement
    $stmt2->close();
}

// Close connection
$conn1->close();
$conn2->close();
?>
