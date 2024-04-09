
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Cursed Talisman Online</title>
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
            background-color: #f2f2f2;
            color: #000;
        }

        .container {
            display: flex;
            height: 100vh; /* Fill entire viewport height */
        }

        .control-panel {
            flex: 1; /* Adjust the width of the control panel */
            max-width: 200px; /* Set maximum width for smaller screens */
            background-color: #fff;
            border-right: 2px solid #ccc;
            padding: 20px;
            text-align: center;
            overflow-y: auto; /* Add scrollbar if content exceeds height */
            transition: transform 0.3s ease; /* Add transition effect */
            transform: translateX(-100%); /* Initially hide off-screen */
        }

        .control-panel.active {
            transform: translateX(0); /* Slide in when active */
        }

        .control-panel img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .control-panel ul {
            list-style-type: none;
            padding: 0;
        }

        .control-panel li {
            margin-bottom: 10px;
            cursor: pointer;
            border-top: 1px solid #ccc; /* Add top border line */
            border-bottom: 1px solid #ccc; /* Add bottom border line */
            padding: 10px 0; /* Adjust padding for height */
        }

        .main-content {
            flex: 3; /* Fill available space by default */
            padding: 20px;
            display: flex;
            flex-wrap: wrap; /* Allow content to wrap */
        }

        .main-content-box {
            flex: 1; /* Fill available space */
            min-width: 200px; /* Minimum width */
            margin-bottom: 20px; /* Add space between items */
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            margin-top: 0;
        }

        p {
            margin-bottom: 20px;
        }

        .hamburger {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 999; /* Ensure it's above other content */
            cursor: pointer;
        }

        .hamburger span {
            display: block;
            width: 30px;
            height: 3px;
            background-color: #000;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="control-panel" id="controlPanel">
            <img src="img/user/unknownuser.png" alt="Avatar">
            <p class="rakkas-regular">Username: <?php echo isset($username) ? $username : ''; ?></p>
            <ul>
                <li onclick="showContent('dashboard')">Dashboard</li>
                <li onclick="showContent('accountDetails')">Account Details</li>
                <li onclick="showContent('changePassword')">Change Password</li>
                <li onclick="showContent('vote')">Vote</li>
                <li onclick="logout()">Logout</li>
            </ul>
        </div>
        <div class="main-content" id="mainContent">
            <div id="dashboard" class="main-content-box">
                <h2>Dashboard</h2>
                <p>UNDER CONSTRUCTION! Please come back again some other time...</p>
            </div>
            <div id="accountDetails" class="main-content-box" style="display: none;">
                <h2>Account Details</h2>
                <p>UNDER CONSTRUCTION! Please come back again some other time...</p>
            </div>
            <div id="changePassword" class="main-content-box" style="display: none;">
                <h2>Change Password</h2>
                <p>UNDER CONSTRUCTION! Please come back again some other time...</p>
            </div>
            <div id="vote" class="main-content-box" style="display: none;">
                <h2>Vote</h2>
                <p>UNDER CONSTRUCTION! Please come back again some other time...</p>
            </div>
            <div id="logout" class="main-content-box" style="display: none;">
                <h2>Logout</h2>
            </div>
        </div>
    </div>

    <!-- Hamburger Icon -->
    <div class="hamburger" onclick="toggleControlPanel()">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <script>
        function showContent(contentId) {
            // Hide all content boxes
            var contentBoxes = document.querySelectorAll('.main-content-box');
            contentBoxes.forEach(function(box) {
                box.style.display = 'none';
            });

            // Show the selected content box
            var selectedBox = document.getElementById(contentId);
            selectedBox.style.display = 'block';
        }

        function toggleControlPanel() {
            var controlPanel = document.getElementById('controlPanel');
            controlPanel.classList.toggle('active');

            var mainContent = document.getElementById('mainContent');
            if (controlPanel.classList.contains('active')) {
                mainContent.style.flex = '1'; // Fill entire width when control panel is hidden
            } else {
                mainContent.style.flex = '3'; // Revert to default flex value when control panel is shown
            }
        }

        // Show dashboard content by default
        window.onload = function() {
            showContent('dashboard');
        };
    </script>

    <script>
        function logout() {

            var script = document.createElement("script");

            script.src="../controllers/logout.php";
            document.body.appendChild(script);

            // Redirect to index.php
            window.location.href = "../../";



        }
    </script> 



</body>
</html>
