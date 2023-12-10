<?php
session_start();
include_once("../db_connect.php");

if(!isset($_SESSION['serviceProviderID'])) {
    header('Location: ../index.php');
    }


    $error = false;

    $serviceProviderID = $_SESSION['serviceProviderID'];
    $employeeID = $_GET['employeeID'];

    //delete only Pending booking
    // $deletequery = "DELETE FROM bookings 
    //     WHERE serviceProviderID='$serviceProviderID' AND bookingID='$bookingID'
    //     AND status='Pending'";

    $deletequery1 = "DELETE FROM serviceprovideremployees 
    WHERE serviceProviderID='$serviceProviderID' AND employeeID = '$employeeID'";

    if($conn->query($deletequery1)) {
        $deletequery2 = "DELETE FROM serviceemployees 
        WHERE employeeID = '$employeeID'";
        if ($conn->query($deletequery2)) {
            $error = false;
        }

    } else {
        $error = true;
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Employee</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>


<?php
    if(!isset($error)) { ?>
    <script> /*
    Swal.fire({
    icon: 'error',
    //type: 'error',
    title: 'Oops...',
    confirmButtonText: 'OK',
    text: 'Failed to remove employee.',
    footer: '',
    allowOutsideClick: false
    //showCloseButton: true
})
.then(function (result) {
    if (result.value) {
        window.location = "./myprofile.php";
    }
})

*/
    alert("Failed to remove employee");
    window.location = "./myprofile.php";
     </script>
   <?php     
    } else {   ?>   
        <script>/*
    Swal.fire({
    icon: 'success',
    //type: 'error',
    title: 'Success!',
    confirmButtonText: 'OK',
    text: 'Successfully removed!',
    footer: '',
    allowOutsideClick: false
    //showCloseButton: true
})
.then(function (result) {
    if (result.value) {
        window.location = "./myprofile.php";
    }
})

*/
    alert("Removed the employee");
    window.location = "./myprofile.php";
     </script>

     <?php }?>
</body>
</html>
