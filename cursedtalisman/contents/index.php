


<?php
// Start the session
session_start();

// Check if a session is active
if (isset($_SESSION)) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();
    
    // Check if the session is really gone
    if (empty($_SESSION)) {
        //echo "Session has been destroyed successfully.";
    } else {
        echo "Failed to destroy session. . . . investigate further";
    }
} else {
    echo "No active session found.";
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursed Talisman Online - Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rakkas&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>

        .rakkas-regular {
                font-family: "Rakkas", serif;
                font-weight: 600;
                font-style: normal;
         }
    

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('contents/dashboard/src/img/cursedtalisman.jpg');
            background-size: cover;
            background-position: center;
            color: #000;
        }
        .container {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .login-box {
            background-color: rgba(255, 255, 255, 0.8); /* Transparent white background */
            border: 2px solid #000;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 80%;
            text-align: center;
        }
        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #000;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .register-link {
            margin-top: 10px;
            color: #000;
            text-decoration: none;
        }
        .register-link:hover {
            text-decoration: underline;
        }
        h1 {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php
    // Check if user has just logged out and display pop-up notification
    if (isset($_SESSION['logged_out']) && $_SESSION['logged_out'] === true) {
        echo '<script>alert("You have been logged out.");</script>';
        // Unset the session variable after displaying the notification
        unset($_SESSION['logged_out']);
        session_destroy();
    }
    ?>
    <div class="container">
        <h1 class="rakkas-regular">Cursed Talisman Online</h1>
        <p>Developed by: Sepiroth X | http://rebzone.net</p>
        <div class="login-box">
            <form action="controllers/" method="post">
                <input type="text" name="username" placeholder="Username" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <input type="submit" value="Login">
            </form>
            <a href="register/" class="register-link">Register</a>
        
        </div>
    </div>

</body>
</html>
