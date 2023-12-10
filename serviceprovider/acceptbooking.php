<?php
session_start();
include_once("../db_connect.php");

if(!isset($_SESSION['serviceProviderID'])) {
    header('Location: ../index.php');
    }


// if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_SESSION['serviceProviderID'])) {
    
$serviceProviderID = $_SESSION['serviceProviderID'];
$bookingID = $_GET['bookingID'];
$employeeID = $_GET['employeeID'];


$insertquery = "INSERT INTO bookingemployees(bookingID, employeeID) VALUES ('$bookingID', '$employeeID')"; 

if ($conn->query($insertquery)) {

    $conn->query("UPDATE bookings SET status = 'Approved' WHERE bookingID = '$bookingID'");
    $error = false;

    //Fetch the employee details for sending through email
    $result = $conn->query(
        "SELECT S.profileIMG AS empIMG, S.employeeName AS employeeName, S.phone AS empPhone, V.phone AS cmpPhone,
        A.email AS cmpEmail, T.serviceTypeName AS serviceTypeName, V.companyName AS companyName
        FROM serviceemployees S, servicetypes T, serviceproviders V, accounts A
        WHERE S.serviceTypeID = T.serviceTypeID AND S.serviceProviderID = V.serviceProviderID 
        AND V.userID = A.userID AND employeeID = '$employeeID'
        ");
    $row = $result->fetch_assoc();
    $profileIMGData = base64_encode($row['empIMG']);
    $employeeName = $row['employeeName'];
    $employeePhone = $row['empPhone'];
    $companyPhone = $row['cmpPhone'];
    $companyEmail = $row['cmpEmail'];
    //$employeeMail = $row['S.email'];
    $serviceType = $row['serviceTypeName'];    
    $companyName = $row['companyName'];


    $result2 = $conn->query(
        "SELECT * FROM customers C, bookings B
        WHERE C.customerID = B.customerID AND bookingID = '$bookingID'
        ");
    $row2 = $result2->fetch_assoc();
    $customerName = $row2['customerName'];

    //send the confirmation mail with service man's details
    include_once('./includes/sendbookingmail.php');

    //echo "Approved succesfully";
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
    <title>Accept Booking</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php
    if(!isset($error)) { ?>
    <script>
    Swal.fire({
    icon: 'error',
    //type: 'error',
    title: 'Oops...',
    confirmButtonText: 'OK',
    text: 'Failed to accept booking.',
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
    title: 'Accepted!',
    confirmButtonText: 'OK',
    text: 'Accepted successfully !',
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