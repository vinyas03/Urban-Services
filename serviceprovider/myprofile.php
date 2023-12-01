<?php 
session_start();
include_once("../db_connect.php");

if(!isset($_SESSION['serviceProviderID'])) {
    header('Location: ../index.php');
}

$serviceProviderID = $_SESSION['serviceProviderID'];
$result = $conn->query("
    SELECT * FROM accounts, serviceproviders, cities
    WHERE accounts.userID = serviceproviders.userID AND serviceproviders.cityID = cities.cityID 
    AND serviceproviders.serviceProviderID = '$serviceProviderID' 
");
$row = $result->fetch_assoc();
$userID = $row['userID'];
$serviceProviderID = $row['serviceProviderID'];                
$companyName = $row['companyName'];
$email = $row['email'];
$phone = $row['phone'];
$city = $row['cityName'];
$startTime = $row['startTime'];
$endTime = $row['endTime'];

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
            <div class="dashboard-header">
                <h2>Profile</h2>
            </div>
            <div class="profile-info" id="">
                <div class="user-id">
                    <p>User ID: <span><?php echo $userID; ?> </span></p>
                </div>
                <div class="serviceprovider-id">
                    <p>Service Provider ID: <span><?php echo $serviceProviderID; ?> </span></p>
                </div>
                <div class="customer-name">
                    <p>Service Provider Name: <span><?php echo $companyName; ?> </span></p>
                </div>
                <div class="customer-email">
                    <p>Email: <span><?php echo $email; ?> </span></p>
                </div>
                <div class="customer-phone">
                    <p>Phone: <span><?php echo $phone;?> </span></p>
                </div>
                <div class="customer-city">
                    <p>City: <span><?php echo $city;?> </span></p>
                </div>
            </div>
    </div>   


    <div class="dashboard-container">

        <div class="dashboard-section">
            <h3>Schedule and Availability</h3>
            <table>
                <thead>
                    <tr>
                        
                        <th>Availability</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        
                        <td><?php echo "$startTime - $endTime"?></td>
                        <td><button class="edit-btn">Edit</button></td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>

    <script src="../scripts/script.js"></script>
</body>
</html>