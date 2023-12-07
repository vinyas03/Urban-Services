<?php
session_start();
include_once("../db_connect.php");

if(!isset($_SESSION['serviceProviderID'])) {
    header('Location: ../index.php');
    }


// if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_SESSION['serviceProviderID'])) {
    
$serviceProviderID = $_SESSION['serviceProviderID'];
$bookingID = $_GET['bookingID'];

$updatequery = "UPDATE bookings SET status = 'Completed' 
WHERE bookingID = '$bookingID' AND serviceProviderID = '$serviceProviderID'"; 

if ($conn->query($updatequery)) {
   $error = false;
    //echo "Completed successfully";
} else {
    $error = true;
    //echo "Failed";
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accept Booking page</title>
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
    confirmButtonText: 'OK',
    text: 'Failed to complete.',
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
    title: 'Completed!',
    confirmButtonText: 'OK',
    text: 'Completed successfully !',
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
</body>
</html>