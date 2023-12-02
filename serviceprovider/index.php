<?php 
session_start();
include_once("../db_connect.php");

if(!isset($_SESSION['serviceProviderID'])) {
    header('Location: ../index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="shortcut icon" href="../images/png/logo.png" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100&display=swap" rel="stylesheet">
    
    <title>Urban Services - Home</title>


    <style>
        /* dashboard.css */

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.dashboard-container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #f4f4f4;
    border: 1px solid #ddd;
}

h2 {
    text-align: center;
    color: #333;
}

.dashboard-section {
    margin-bottom: 20px;
}

.dashboard-section h3 {
    color: #555;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 10px;
    text-align: left;
}

.accept-btn, .deny-btn, .edit-btn {
    padding: 5px 10px;
    margin: 2px;
    cursor: pointer;
}
    </style>
</head>
<body>

    <header>
        <div class="toggleBtn">
            <img class="menu" src="../images/svg/burger-menu-left.svg" width="40px" height="40px">
        </div>
        <div class="logo-wrapper">
            <img src="../images/png/logo.png" class="logo">
            <div class="title">Urban Services</div>
        </div>
        <ul class="nav-items">
            <li><a href="./index.php">Home</a></li>
            <li><a href="#">About</a></li>
            <!-- <li><a href="#">Register a service</a></li> -->
        </ul>
        <div class="nav-buttons">
        <?php if (isset($_SESSION['serviceProviderID'])) { ?>
                
			<a style="margin:8px 12px;text-align:center;display:block;font-weight:600;font-size:1.25rem;color:#D80032;"><?php echo $_SESSION['companyName']; ?></a>
			<div class="profileImg"  style="margin:0 14px 0 0;">
                <a href="./myprofile.php"><img src="../images/png/user.png" alt="profile image"></a>
            </div>
            <!-- <a style="margin:8px 6px;font-weight:500;font-size:1.2rem;color:gold;">Profile</a> -->
                
            <!-- <a style="margin:8px 6px;font-weight:500;font-size:1.2rem;color:gold;">Settings</a> -->
            <a href="../logout.php"class="loginBtn">Log Out</a>
			<?php } else { ?>
                    <a href="../login.php" class="loginBtn">Login</a>
                    <a href="../signup.php" class="signupBtn">Register</a>				
		    <?php } ?>
            <!-- <div class="profile-dropdown">
            <div class="profile-options">
                <p><a href="./myprofile.php">My Profile</a></p>
                <p><a href="./mybookings.php">My Bookings</a></p> 
            </div>
            </div> -->
        </div>
    </header>


    <div class="dashboard-container">
        <h2>Service Provider Dashboard</h2>

        <div class="dashboard-section">
            <h3>My Orders</h3>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Service Type</th>
                        <th>Date</th>
                        <th>Accept/Deny</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>John Doe</td>
                        <td>Plumbing</td>
                        <td>2023-01-01</td>
                        <td>
                            <button class="accept-btn">Accept</button>
                            <button class="deny-btn">Deny</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jane Smith</td>
                        <td>Electrical</td>
                        <td>2023-01-02</td>
                        <td>
                            <button class="accept-btn">Accept</button>
                            <button class="deny-btn">Deny</button>
                        </td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>

    </div>

    <script src="../scripts/script.js"></script>
</body>
</html>