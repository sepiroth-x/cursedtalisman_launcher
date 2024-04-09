<?php
//include '../controllers/register-controller.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursed Talisman Online - Registration</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rakkas&display=swap" rel="stylesheet">
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
            background-image: url('../contents/dashboard/src/img/cursedtalisman.jpg');
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

        .registration-box {
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
        input[type="password"],
        input[type="email"] {
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

        .login-link {
            margin-top: 10px;
            color: #000;
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        h1 {
            margin-bottom: 10px;
        }
    </style>

    <div class="container">
    <script>
        // JavaScript function to display a notification
        function showNotification(response) {
            if (response === "success") {
                alert("Account created successfully!");
            } else if (response === "error") {
                alert("Error: Account creation failed!");
            }
        }
    </script>
</head>
<body onload="showNotification('<?php echo isset($response) ? $response : '' ?>')">
   

        <h1 class="rakkas-regular">Cursed Talisman Online</h1>
        <div class="registration-box">
            <form action="../controllers/register-controller.php" method="post">
                <input type="text" name="firstName" placeholder="First Name" required><br>
                <input type="text" name="middleName" placeholder="Middle Name"><br>
                <input type="text" name="lastName" placeholder="Last Name" required><br>
                <input type="email" name="email" placeholder="Email Address" required><br>
                <input type="text" name="username" placeholder="Username" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <input type="password" name="confirmPassword" placeholder="Confirm Password" required><br>
                <input type="submit" value="Register">
            </form>
            <a href="../" class="login-link">Already have an account? Login</a>
        </div>
    </div>
</body>
</html>
