<?php 
    session_start();
    include_once("../db_connect.php");

    if(!isset($_SESSION['customerID'])) {
    header('Location: ../index.php');
    }


    $customerID = $_SESSION['customerID'];
    $bookingID = $_GET['bookingID'];

    //delete only Pending booking
    // $deletequery = "DELETE FROM bookings 
    //     WHERE customerID='$customerID' AND bookingID='$bookingID'
    //     AND status='Pending'";

    $updatequery = "UPDATE bookings SET status = 'Canceled' WHERE customerID = '$customerID' AND bookingID = '$bookingID'";
    
    if($conn->query($updatequery)) {
        //echo "Successfully cancelled booking";
        $cancelerror = false;
    } else {
        //echo "Failed to cancel booking";
        $cancelerror = true;
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel booking</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php
    if($cancelerror) { ?>
    <script>
    Swal.fire({
    icon: 'error',
    //type: 'error',
    title: 'Oops...',
    confirmButtonText: 'OK',
    text: 'Failed to cancel.',
    footer: '',
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
    confirmButtonText: 'OK',
    text: 'Cancel successful.',
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
