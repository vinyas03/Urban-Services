<?php 
session_start();
include_once("../db_connect.php");

if(!isset($_SESSION['serviceProviderID'])) {
    header('Location: ../index.php');
}

include_once("./includes/fetchProfileIMG.php");


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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css" integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <!-- jQuery Modal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

    <title>Urban Services - Home</title>


    <style>
        /* dashboard.css */

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.dashboard-container {
    max-width: 1200px;
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


/*Profile box*/
.profile-box {
    display: grid;
    grid-template-columns: 2fr 1fr;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
}
.profile-box .profile-image {
    align-self: stretch; 
    /* place-self: center; */
    display: grid;
    place-items: center;
}
.profile-box .profile-image img {
    max-width: 100%;
}

/*availability*/
.availability-container{
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
    background-color: rgb(255, 255, 255);
}

/*Employee management*/
.employee-container {
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
    background-color: rgb(255, 255, 255);
}

.addEmployee-btn, .removeEmployee-btn, .edit-btn {
    padding: 5px 10px;
    margin: 2px;
    cursor: pointer;   
    text-decoration: none;
}

.addEmployee-btn {
    background: #33b249;
    color:#f4f4f4;
}

.removeEmployee-btn {
    background: #D80032;
    color: #f4f4f4;
}

.edit-btn {
    background: #4681f4;
    color:#f4f4f4;
}




/* Forms*/

.form-container {
    max-width: 400px;
    margin: 20px auto;
    padding: 20px;
    background-color: #f4f4f4;
    border: 1px solid #ddd;
}

h2 {
    text-align: center;
    color: #333;
}

form {
    display: grid;
    gap: 10px;
}

label {
    display: block;
    margin-bottom: 5px;
    color: #555;
}

input, textarea {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
}
/* #addEmployee-box .choose-photo {
    background: #ffaa00;
    cursor: pointer;
    display: inline-block;
    width: max-content;
    padding: 4px;
    border-radius: 2px;
    color: #f4f4f4;
}
#addEmployee-box input[type="file"]{
    display: none;
} */

button {
    background-color: #3498db;
    color: #fff;
    padding: 10px;
    border: none;
    cursor: pointer;
}


.employee-img {
    max-width: 70px;
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
                <a href="./myprofile.php"><img src="<?php echo (isset($profileIMGData)) ? "data:image/jpg;base64,$profileIMGData" : "../images/png/user.png"; ?>" alt="profile image"></a>
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

    <div class="dashboard-container profile-container">
        <div class="dashboard-header profile-title">
            <h2>My Profile</h2>
        </div>
        <div class="profile-box">
            <div class="profile-info">
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
                <a class="edit-btn" href="#editProfile-box" rel="modal:open">Edit Profile</a>
            </div>

            <div class="profile-image">
            <img src="<?php echo (isset($profileIMGData)) ? "data:image/jpg;base64,$profileIMGData" : "../images/png/user.png"; ?>" alt="profile image">
            </div>
        </div>   

    <div id="editProfile-box" class="modal">
    <form action="./editprofile.php" method="post" enctype="multipart/form-data">
            <label for="phone">Phone:</label>
            <input type="tel" placeholder="Enter 10-digit Phone no." name="phone" minlength="10" maxlength="10" required>    
            <label for="photo" class="choose-photo">Profile Photo: </label>
            <input type="file" id="photo" name="profileIMG" accept="image/*">
            <button type="submit" name="submit">Submit</button>
        </form>       
    </div>


    <div class="dashboard-container availability-container">
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
                        <td><a class="edit-btn" href="#editAvailability-box" rel="modal:open">Edit</a></td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>

    <div id="editAvailability-box" class="modal">
    <form action="./editavailability.php" method="post" enctype="multipart/form-data">
            <label for="startTime">Start Time:</label>
            <input type="time" id="startTime" name="startTime" required>
            <label for="endTime">End Time:</label>
            <input type="time" id="endTime" name="endTime" required>
            <button type="submit" name="submit">Submit</button>
        </form>       
    </div>

    <div class="dashboard-container employee-container">
    <div class="dashboard-section">
            <h3>Employee Management</h3>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Photo</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <!-- <th>Availability Schedule</th>-->
                        <th>Service Type</th> 
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="employees-list">

                    <!-- fetch more employee rows as needed -->
                </tbody>
            </table>

    </div>
    <div class="dashboard-section">
                <a class="addEmployee-btn" href="#addEmployee-box" rel="modal:open">Add new Employee</a>
            </div>
    </div>

    <div id="addEmployee-box" class="modal">
    <form action="addemployee.php" method="post" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" minlength="10" maxlength="10" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
             
            <label for="servicelist">Service Type</label>   
                    <select name="serviceTypeName" id="servicelist">
                        <option value="Plumbing">Plumbing</option>
                        <option value="Electricals">Electricals</option>
                        <option value="Carpentry">Carpentry</option>
                        <option value="Cleaning">Cleaning</option>
                        <option value="Pest Control">Pest Control</option>
                    </select>
            <label for="photo" class="choose-photo">Choose Photo</label>
            <input type="file" id="photo" name="employeeIMG" accept="image/*" required>

            <button type="submit" name="submit">Add Employee</button>
        </form>       
    </div>


    <script src="../scripts/script.js"></script>
    <script>
        //get employees
        $(function() {
            $.get('getEmployees.php'
            , function(res){
                var employees = JSON.parse(res);
                var employeesResult = "";

                if (employees.failed == true) {
                    employeesResult = `<p style="color:red">You have not added any employees yet...<p>`;
                } else {
                    employees.forEach(function(employee, i) {
                    
                    employeesResult += `
                    <tr>
                        <td>${employee.employeeName}</td>
                        <td><img class="employee-img" src="${(employee.profileIMG !== '')?'data:image/jpg;base64,'+`${employee.profileIMG}` : './images/png/user.png'}" alt="profile image"></td>
                        <td>${employee.phone}</td>
                        <td> ${employee.email}</td>
                        <td>${employee.serviceTypeName}</td>
                        <td><a class="removeEmployee-btn" href="./removeEmployee.php?employeeID=${employee.employeeID}">Remove</a></td>
                        
                    </tr>`;                      
                    });
                }
                $("#employees-list").html(employeesResult);
            });
        });
    </script>
</body>
</html>