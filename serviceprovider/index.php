<?php 
session_start();
include_once("../db_connect.php");

if(!isset($_SESSION['serviceProviderID'])) {
    header('Location: ../index.php');
}

include_once("./includes/fetchProfileIMG.php");

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

.dashboard-container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 10px;
    background-color: #f8f8f8;
    border: 1px solid #ddd;
}

.dashboard-container h2 {
    text-align: center;
    color: #333;
}

.dashboard-section {
    margin: 20px 0;
    padding: 16px;
    background-color: rgb(255, 255, 255);
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);    
}

.dashboard-section h3 {
    color: #555;
}

.dashboard-section table {
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

.accept-btn, .reject-btn, .sendEmployee-Btn{
    padding: 3px 5px;
    margin: 2px;
    display: inline-block;
    border-radius: 1px;
    color: #f4f4f4;
    text-decoration: none;
}
.accept-btn {
    background: #33b249;
}
.reject-btn {
    background: #f01e1e;
}
.sendEmployee-Btn {
    background: #4681f4;
}
.approved {
    color: #0047AB;
    font-weight: 600;
}
.canceled {
    color: #f01e1e;
    font-weight: 600;
}
.completed {
    color: #33b249;
    font-weight: 600;
}
.view-feedback , .complete-btn{
    padding: 3px;
    display: inline-block;
    margin-left: 2px;
    border-radius: 3px;
    text-decoration: none;
}
.view-feedback {
    color: #f4f4f4;
    background: #e92c91;
}
.complete-btn {
    color: #f4f4f4;
    background: #33b249;
;
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


    <div class="dashboard-container">
        <h2>Service Provider Dashboard</h2>

        <div class="dashboard-section">
            <h3>My Service history</h3>
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Customer Name</th>
                        <th>Service Type</th>
                        <th>Address</th>
                        <th>Selected Date</th>
                        <th>Time slot</th>
                        <th>Phone</th>
                        <th>Status/Action</th>
                    </tr>
                </thead>
                <tbody id="bookings-list">

                    <!-- Fetch more rows as needed -->
                </tbody>
            </table>
        </div>

    </div>



    <script>
        //var counter = 0;
        //var bookingIDs = [];
        $(function() {
            $.get('getbookings.php'
            , function(res){
                var bookings = JSON.parse(res);
                var bookingsResult = "";

                if (bookings.failed == true) {
                    bookingsResult = `<p style="color:red">No bookings yet...<p>`;
                } else {
                    bookings.forEach(function(booking, i) {
                    //bookingIDs.push(booking.bookingID);

                    bookingsResult += `
                    <tr>
                        <td id="bookID">${booking.bookingID}</td>
                        <td>${booking.customerName}</td>
                        <td>${booking.serviceTypeName}</td>
                        <td> ${booking.customerAddress}</td>
                        <td>${booking.preferredDate}</td>
                        <td>${booking.preferredTimeSlotStart} to ${booking.preferredTimeSlotEnd}</td>
                        <td>${booking.phone}</td>
                        <td>
                        ${booking.status !== 'Pending' ? 
                        (() => {
                        switch (booking.status) {
                            case 'Approved':
                                return `<span class="approved">Approved</span><a class="complete-btn" href="./completedbooking.php?bookingID=${booking.bookingID}">Completed</a>`;
                            case 'Canceled':
                                return '<span class="canceled">Canceled<span>';
                            case 'Completed':
                                return `<span class="completed">Completed</span><a class="view-feedback" href="#viewFeedbackModal" data-bookingID="${booking.bookingID}"  rel="modal:open">Feedback</a>
                                <!--Show feedback -->
                                    <div id="viewFeedbackModal"  class="modal">
                                    <h2>Feedback recieved</h2>
                                    <!-- Modal content -->
                                    <div class="feedback-content">
                                    <h3>Rating</h3>
                                        <div id="rating"></div>
                                    <h3>Remarks</h3>
                                    <div id="remarks"></div>
                                    </div>
                                    </div>
                                `
                            default:
                                return '';
                        }
                        })()
                        : `
                        
                        <a class="accept-btn" rel="modal:open" data-bookingID="${booking.bookingID}" href="#employeeSelectModal"'+'">Accept</a><a class="reject-btn" href="rejectbooking.php?bookingID='+'${booking.bookingID}'+'">Reject</a>
                        
                        <!--Choose Employees-->
                        <div id="employeeSelectModal" class="modal">
                        <!-- Modal content -->
                        <div class="modal-content">
                        <h2>Choose an Employee</h2>
                            <table>
                            <thead>
                                <tr>
                                <th>Name</th>
                                <th>Photo</th>
                                <th>Service Type</th> 
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="employees-list">
                                <!-- fetch the employee rows and display here -->
                            </tbody>
                            </table>
                       
                        </div>
                        </div>


                        `
                    }
                        </td>
                    </tr>`;                      
                    });
                }

                $("#bookings-list").html(bookingsResult);

                $(".accept-btn").click(function() {
                    let bid = $(this).attr("data-bookingID");
                    //console.log(bid);
                $.get('getEmployees.php'
            , function(res){
                const article = document.querySelector(".accept-btn");
                
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
                        <td>${employee.serviceTypeName}</td>
                        <td><a class="sendEmployee-Btn" href="./acceptbooking.php?employeeID=${employee.employeeID}&bookingID=${bid}">Assign</a></td>
                    </tr>`;                      
                    });
                }
                
                $("#employees-list").html(employeesResult);


                
            });
        });

            $('.view-feedback').click(function() {
                let bid = $(this).attr("data-bookingID");
                //alert(bid);
                $.post("getfeedback.php",
                {
                bookingID: bid,
                },
                function(res, status){
                    let feedbackInfo = JSON.parse(res);
                    
                    console.log(feedbackInfo);
                    if(!feedbackInfo) {
                        $("#rating").html("---");
                        $("#remarks").html("---");                        
                    } else {
                        $("#rating").html(feedbackInfo.rating + "/5");
                        $("#remarks").html(feedbackInfo.remarks);
                    }

                });

            });
        });
        });
        


        //fetch and display employees for work when clicked on 'accept' button 

    </script>
    <script src="../scripts/script.js"></script>
</body>
</html>