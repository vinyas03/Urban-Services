<?php 
    session_start();
    include_once("../db_connect.php");

    if(!isset($_SESSION['customerID'])) {
    header('Location: ../index.php');
    }

    $error = false;

//var_dump($_POST);

    foreach ($_POST as $key => $value) {
    if($value == '') {
        $error = true;
        $bookingerror = "Please fill out the complete details before booking.";
        break;
    }
    }

    // if(isset($bookingerror)) {
    // echo "<script>alert('$bookingerror');</script>";
    // // header('Location: ./index.php');
    // }



    if (isset($_POST['submit'])) {
        $serviceProviderID = mysqli_real_escape_string($conn, $_POST['serviceProviderID']);
        $serviceTypeID = mysqli_real_escape_string($conn, $_POST['serviceTypeID']);
        $preferredDate = mysqli_real_escape_string($conn, $_POST['preferredDate']);
        $preferredTimeSlotStart = mysqli_real_escape_string($conn, $_POST['preferredTimeSlotStart']);
        $preferredTimeSlotEnd = mysqli_real_escape_string($conn, $_POST['preferredTimeSlotEnd']);
        $customerRequestInfo = mysqli_real_escape_string($conn, $_POST['customerRequestInfo']);
    
        $customerID = $_SESSION['customerID'];


        //if no errors, we insert into the database
        if (!$error) {
            //find total bookings in the database
            $result = $conn->query(
                "SELECT SUM(total_bookings) AS total_bookings
                 FROM totalaccounts" 
            );
            $row = $result->fetch_assoc();
            $total_bookings = $row['total_bookings'];
            //Generate 20 character bookingID
            $length = strlen("$total_bookings");
            $bookingID = "book".str_repeat('0', 16 - $length).($total_bookings + 1);


            //Default status of booking. (status can be: Pending, Approved, Completed, Canceled)
            $status = 'Pending';

            $insertquery = "INSERT INTO bookings 
            (bookingID, customerID, serviceTypeID, serviceProviderID, status, preferredDate, preferredTimeSlotStart, preferredTimeSlotEnd, customerRequestInfo) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertquery);
            $stmt->bind_param("sssssssss", $bookingID, $customerID, $serviceTypeID, $serviceProviderID, $status, $preferredDate, $preferredTimeSlotStart, $preferredTimeSlotEnd, $customerRequestInfo);
            
            
            try {
                if($stmt->execute()) {
                    //increase user count
                    $conn->query(
                        "UPDATE totalaccounts SET total_bookings = total_bookings+1
                        "
                    );

                    //redirect to customer mybookings page
                    echo "<script>alert('Booking successful !</script>";

                    //header('Location: customer/index.php');
                 }
            } catch (mysqli_sql_exception $e) {
                $error = true;
                $bookingerror = "Error in booking the service. ".$e->getMessage(); 
             }
        }     
    }
    
    if(isset($bookingerror)) {
        echo "<script>alert('$bookingerror');</script>";
        header('Location: ./index.php');
        }
    

?>