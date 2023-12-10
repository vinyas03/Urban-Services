<?php 
session_start();
include_once("../db_connect.php");

if(!isset($_SESSION['serviceProviderID'])) {
    header('Location: ../index.php');
}

$serviceProviderID = $_SESSION['serviceProviderID'];

if (isset($_POST['submit'])) {
    $employeeName = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $serviceTypeName = $_POST['serviceTypeName'];

    if (is_uploaded_file($_FILES['employeeIMG']['tmp_name'])) {
        $imgData = file_get_contents($_FILES['employeeIMG']['tmp_name']);
    }

    //find total employees in the database
    $result = $conn->query(
        "SELECT SUM(total_employees) AS total_employees 
        FROM totalaccounts"
    );
    $row = $result->fetch_assoc();
    $total_employees = $row['total_employees'];

    //Generate 20 character userID
    $length = strlen("$total_employees");
    $employeeID = "empl".str_repeat('0', 16 - $length).($total_employees + 1);
    
    //fetch the serviceTypeID correcponding to the input serviceType
     $result = $conn->query(
            "SELECT serviceTypeID FROM servicetypes
            WHERE serviceTypeName ='$serviceTypeName'
            "
            );
    $row = $result->fetch_assoc();
    $serviceTypeID = $row['serviceTypeID'];                



    
    $insertquery1 = "INSERT INTO serviceemployees (employeeID, employeeName, serviceProviderID, phone, email, serviceTypeID, profileIMG) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt1 = $conn->prepare($insertquery1);
    $stmt1->bind_param("sssssss",$employeeID, $employeeName, $serviceProviderID, $phone, $email, $serviceTypeID, $imgData);

    $insertquery2 = "INSERT INTO serviceprovideremployees (serviceProviderID, employeeID) VALUES (?, ?)";
    $stmt2 = $conn->prepare($insertquery2);
    $stmt2->bind_param("ss",$serviceProviderID, $employeeID);

    if($stmt1->execute() && $stmt2->execute()) {
        //echo "Employee added successfully";
        
        //increase user count
        $conn->query(
            "UPDATE totalaccounts SET
            total_employees = total_employees + 1
            "
            );
        $error = false;
    } else {
        //echo "Failed to add employee";
        $error = true;
    }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add an Employee</title>
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
    confirmButtonText: 'Back to Profile',
    text: 'Failed to add new employee',
    footer: '',
    allowOutsideClick: false
    //showCloseButton: true
})
.then(function (result) {
    if (result.value) {
        window.location = "./myprofile.php";
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
    text: 'Successfully added new employee.',
    footer: '',
    allowOutsideClick: false
    //showCloseButton: true
})
.then(function (result) {
    if (result.value) {
        window.location = "./myprofile.php";
    }
})


     </script>

     <?php }?>
</body>
</html>
