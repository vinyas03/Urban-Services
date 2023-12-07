<?php
session_start();
include_once("../db_connect.php");

if(!isset($_SESSION['serviceProviderID'])) {
    header('Location: ../index.php');
    }


    $error = false;

    $serviceProviderID = $_SESSION['serviceProviderID'];
    $bookingID = $_GET['bookingID'];

    //delete only Pending booking
    // $deletequery = "DELETE FROM bookings 
    //     WHERE serviceProviderID='$serviceProviderID' AND bookingID='$bookingID'
    //     AND status='Pending'";

    $updatequery = "UPDATE bookings SET status = 'Canceled' WHERE serviceProviderID = '$serviceProviderID' AND bookingID = '$bookingID'";

    if($conn->query($updatequery)) {
        //echo "Successfully cancelled booking";
        $rejecterror = false;
    } else {
        //echo "Failed to cancel booking";
        $rejecterror = true;
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reject booking</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php
    if(!isset($rejecterror)) { ?>
    <script>
    Swal.fire({
    icon: 'error',
    //type: 'error',
    title: 'Oops...',
    confirmButtonText: 'OK',
    text: 'Failed to reject booking.',
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
    title: 'Rejected!',
    confirmButtonText: 'OK',
    text: 'Rejected successfully !',
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

     <?php }?>
</body>
</html>
