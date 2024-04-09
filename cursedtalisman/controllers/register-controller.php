<?php
include '../connection/db_account-config.php';
//include '../connection/db_players-config.php';

// Create connection
$conn1 = new mysqli($servername, $username, $password, $database);
//$conn2 = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn1->connect_error) {
    die("Connection failed: " . $conn1->connect_error);
}

// if ($conn2->connect_error) {
//     die("Connection failed: " . $conn2->connect_error);
// }


$error = ""; // Initialize error message variable


// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Prepare and bind the SQL statement

    $stmt1 = $conn1->prepare("INSERT INTO t_account (name, pwd, pw2, firstname, middlename, lastname, email) 
    VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param("sssssss", $username, $hashed_password, $password,
    $firstName,$middleName,$lastName,$email);

    // $stmt1 = $conn1->prepare("INSERT INTO t_account (name, pwd, pw2) 
    // VALUES (?, ?, ?)");
    // $stmt1->bind_param("sss", $username, $hashed_password, $password);


    // $stmt2 = $conn2->prepare("INSERT INTO users (firstname, middlename, lastname, email) VALUES (?, ?, ?, ?)");
    // $stmt2->bind_param("ssss", $firstName, $middleName, $lastName, $email);

    // Set parameters and execute

    $toLowerStrFirstname = $_POST['firstName'];;
    $toLowerStrMiddlename = $_POST['middleName'];
    $toLowerStrLastname = $_POST['lastName'];;
    $toLowerStrEmail = $_POST['email'];;

    //convert personal info entry to lowercases
    $firstName = strtolower($toLowerStrFirstname); 
    $middleName = strtolower($toLowerStrMiddlename);
    $lastName = strtolower($toLowerStrLastname);
    $email = strtolower($toLowerStrEmail);

    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Note: Please hash the password before storing it in the database for security reasons
    
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords don\\'t match! Please re-check!');</script>";
     
    }
    else 
    {
       $userCheckQuery = "SELECT * FROM t_account WHERE name = '$username'";
       $resultQuery = $conn1->query($userCheckQuery);
       if($resultQuery->num_rows > 0) {
          echo "<script>alert('REGISTRATION FAILED! Username already exists! Register a new one!');</script>";
        } 
       else 
       {
       // Hash the password
        function hash_password($password) {
        return md5($password);
         }
                $hashed_password = md5($password);

           // Execute the first statement
           if ($stmt1->execute()) {
            $response = "success"; // Account creation successful
            echo "<script>alert('Account created! You can now login!');</script>";
            include '../contents/header.php';
            include '../contents/dashboard.php';
            include '../contents/footer.php';

            
            //echo "creation successful";
            } 
              else 
           {
            //echo "Error: " . $stmt1->error;
            //$response = "error"; // Account creation failed
            echo "<script>alert('Account creation failed! Username UNAVAILABLE!');</script>";
            
        
             // echo "failed creation!";
             }

             // Execute the second statement
            // if ($stmt2->execute()) {
            //    $response = "success"; // User creation successful

            // } else {
            //    echo "Error: " . $stmt2->error;
            //     $response = "error"; // User creation failed
            // }
       
         // Close statements
         $stmt1->close();
         // $stmt2->close();
  
     }

        

       }
         
       
}

// Close connections
$conn1->close();
//$conn2->close();
?>