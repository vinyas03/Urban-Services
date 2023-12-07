<?php 
session_start();
include_once("../db_connect.php");

if(!isset($_SESSION['customerID'])) {
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
</head>

<style>
    /*Feeback modal*/
    .feedback-container {
    max-width: 400px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
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

.submitBtn {
    background-color: #3498db;
    color: #fff;
    padding: 10px;
    border: none;
    cursor: pointer;
}
</style>

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
        <?php if (isset($_SESSION['customerID'])) { ?>
                
			<a style="margin:8px 12px;text-align:center;display:block;font-weight:600;font-size:1.25rem;color:#D80032;"><?php echo $_SESSION['customerName']; ?></a>
			<div class="profileImg"  style="margin:0 14px 0 0;">
            <img src="<?php echo (isset($profileIMGData)) ? "data:image/jpg;base64,$profileIMGData" : "../images/png/user.png"; ?>" alt="profile image">
            </div>
            <!-- <a style="margin:8px 6px;font-weight:500;font-size:1.2rem;color:gold;">Profile</a> -->
                
            <!-- <a style="margin:8px 6px;font-weight:500;font-size:1.2rem;color:gold;">Settings</a> -->
            <a href="../logout.php"class="loginBtn">Log Out</a>
			<?php } else { ?>
                    <a href="../login.php" class="loginBtn">Login</a>
                    <a href="../signup.php" class="signupBtn">Register</a>				
		    <?php } ?>
            <div class="profile-dropdown">
                <div class="profile-options">
                    <p><a href="./myprofile.php">My Profile</a></p>
                    <!-- <p><a href="./mybookings.php">My Bookings</a></p> -->
                </div>
            </div>
        </div>
    </header>

    <div class="bookings-container">
            <div class="bookings-header">
                <h2>My bookings</h2>
            </div>
            <div class="bookings-results" id="bookings-results">

                <!-- <div class="booking-result">
                    <div class="service-image">
                        <img src="../images/wallpaper-7415571_1280.jpg" alt="">
                    </div>
                    <div class="service-info">
                        <h3 class="title">ABC Plumbers</h3>
                        <div class="description">
                            <p class="booking-id">Booking ID: order3002183271</p>
                            <p class="booked-on">Booked on: 23/11/2023 10:34</p>
                            <p class="time-slot">Time slot: 29/11/2023 9:00-12:00</p>
                            <p class="booked-service">Service: Plumbing</p>
                            <p class="booked-location">Location: Bangalore</p>
                            <p class="booking-status" style="color:green;font-size:1.2rem;">Approved</p>
                        </div>
                         
                        <button class="cancelnow">Cancel</button> 
                    </div>
                    
                </div> -->
            </div>
    </div>   

    <script src="../scripts/script.js"></script>
    <script>
        //profile drop-down list
        $(".profileImg").click(function() {
            $(".profile-dropdown").toggle("fast");
        })


        //search services
        $(function() {
            $(".profile-dropdown").hide();
            $.get('getbookings.php'
            , function(res){
                var bookings = JSON.parse(res);
                var bookingsResult = "";

                if (bookings.failed == true) {
                    bookingsResult = `<p style="color:red">No bookings yet...<p>`;
                } else {
                    bookings.forEach(function(booking, i) {
                    
                    //status color
                    let statusColor = '';
                    if (booking.status === 'Canceled') {
                        statusColor = 'red';
                    } else if (booking.status === 'Pending') {
                        statusColor = 'orange';
                    } else if (booking.status === 'Completed') {
                        statusColor = 'green';
                    } else {
                        statusColor = 'blue';
                    }  

                    bookingsResult += `
                    <div class="booking-result">
                    <div class="service-image">
                    <img class="service-img" src="${(booking.profileIMG !== '')?'data:image/jpg;base64,'+`${booking.profileIMG}` : './images/png/user.png'}" alt="provider image">
                    </div>
                    <div class="service-info">
                        <h3 class="title"></h3>
                        <div class="description">
                            <p class="service-provider">Service Provider: ${booking.companyName}</p>
                            <p class="booking-id">Booking ID: ${booking.bookingID}</p>
                            <p class="booked-on">Booked on: ${booking.bookingTime}</p>
                            <p class="booked-service">Service: ${booking.serviceTypeName}</p>
                            <p class="time-slot">Time Slot: ${booking.preferredDate} - ${booking.preferredTimeSlotStart} to ${booking.preferredTimeSlotEnd}</p>
                            <p class="booked-location">City: ${booking.cityName}</p>
                            <p class="booking-status" style="color:${statusColor};font-size:1.2rem;">${booking.status}</p>
                        </div>
                        ${booking.status !== 'Pending' ? 
                        (() => {
                        switch (booking.status) {
                            case 'Approved':
                                return '';
                                break;
                            case 'Canceled':
                                return '';
                                break;
                            case 'Completed':
                                return `<a class="give-feedback" href="#modal-${booking.bookingID}" rel="modal:open"> Give Feedback</a>
                                <div id="modal-${booking.bookingID}" class="modal feedback-box">
                                    <form action="./submitfeedback.php" method="POST">
                                    <h2>Give your Feedback</h2>
                                    <input type="text" name="bookingID" id="sid" value="${booking.bookingID}" hidden> <br>
                                    
                                    <label for="rating">Rating:</label>
                                    <input type="number" id="rating" name="rating" min="1" max="5" required>

                                    <label for="remarks">Remarks:</label>
                                    <textarea id="remarks" name="remarks" rows="4" required></textarea>                                   
                                    <input type="submit" name="submit" class="submitBtn" value="submit">
                                    </form>
                                </div>`;
                                break;
                            default:
                                return '';
                        }
                        })()
                        : `<a href="cancelbooking.php?bookingID=${booking.bookingID}" class="cancelnow">Cancel</a>`}
                    </div>
                </div>`;                      
                    });
                }
                $("#bookings-results").html(bookingsResult);
            });
        });

    </script>
</body>
</html>
