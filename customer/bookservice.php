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
        $customerAddress = mysqli_real_escape_string($conn, $_POST['customerAddress']);
        $customerRequestInfo = mysqli_real_escape_string($conn, $_POST['customerRequestInfo']);
    
        $customerID = $_SESSION['customerID'];

        //find if there is existing booking for the same service type on the same date
        $result = $conn->query(
            "SELECT * FROM bookings 
            WHERE customerID = '$customerID' AND serviceTypeID = '$serviceTypeID' AND preferredDate = '$preferredDate'" 
        );
       
        if ($result->num_rows > 0) {
            $error = true;
            $bookingerror = "You already have a booking for the same service type on the selected date.";
        }
       
        //find if there is existing 'Pending' booking for the same service provider for same service type
        $result = $conn->query(
            "SELECT * FROM bookings 
            WHERE customerID = '$customerID' AND serviceProviderID = '$serviceProviderID' AND serviceTypeID = $serviceTypeID 
            AND status = 'Pending'
            "
        );
       
        if ($result->num_rows > 0) {
            $error = true;
            $bookingerror = "You have an existing 'Pending' booking waiting to be approved for the same service type from this service provider.";
        }

        //find if there is existing 'Pending' booking for the same service provider for same date
        $result = $conn->query(
            "SELECT * FROM bookings 
            WHERE customerID = '$customerID' AND serviceProviderID = '$serviceProviderID' AND preferredDate = '$preferredDate' 
            AND status = 'Pending'
            "
        );
       
        if ($result->num_rows > 0) {
            $error = true;
            $bookingerror = "You have an existing 'Pending' booking waiting to be approved for the selected date from this service provider.";
        }
         
           


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


            //Get customer cityID
            $result = $conn->query(
                "SELECT cityID
                 FROM customers
                 WHERE customerID = '$customerID'
                "
            );
            $row = $result->fetch_assoc();
            $cityID = $row['cityID'];

            //Default status of booking. (status can be: Pending, Approved, Completed, Canceled)
            $status = 'Pending';

            $insertquery = "INSERT INTO bookings 
            (bookingID, customerID, serviceTypeID, serviceProviderID, status, cityID, preferredDate, preferredTimeSlotStart, preferredTimeSlotEnd, customerAddress, customerRequestInfo) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertquery);
            $stmt->bind_param("sssssssssss", $bookingID, $customerID, $serviceTypeID, $serviceProviderID, $status, $cityID, $preferredDate, $preferredTimeSlotStart, $preferredTimeSlotEnd, $customerAddress, $customerRequestInfo);
            
            
            try {
                if($stmt->execute()) {
                    //increase user count
                    $conn->query(
                        "UPDATE totalaccounts SET total_bookings = total_bookings+1
                        "
                    );

                    //redirect to customer mybookings page
                    //echo "<script>alert('Booking successful !</script>";
                    $error = false;
                    //header('Location: ./mybookings.php');
                 }
            } catch (mysqli_sql_exception $e) {
                $error = true;
                $bookingerror = "Error in booking the service. ".$e->getMessage(); 
             }
        }     
    }
    
    // if(isset($bookingerror)) {
    //     echo "<script>alert('$bookingerror');</script>";
    //     header('Location: ./index.php');
    //     }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book service</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php
    if($error) { ?>
    <script>
    Swal.fire({
    icon: 'error',
    //type: 'error',
    title: 'Oops...',
    confirmButtonText: 'Back to Home',
    text: 'Booking failed.',
    footer: "<?php echo $bookingerror; ?>",
    allowOutsideClick: false
    //showCloseButton: true
})
.then(function (result) {
    if (result.value) {
        window.location = "./index.php";
    }
})


     </script>
   <?php     
    } else {   ?>   
        <script>
    Swal.fire({
    icon: 'success',
    //type: 'error',
    title: 'Booked !',
    confirmButtonText: 'Show Bookings',
    text: 'Booking successful.',
    footer: '',
    allowOutsideClick: false
    //showCloseButton: true
})
.then(function (result) {
    if (result.value) {
        window.location = "./mybookings.php";
    }
})


     </script>

     <?php }?>
</body>
</html>
