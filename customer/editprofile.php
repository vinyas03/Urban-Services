<?php 
session_start();
include_once("../db_connect.php");

//if not logged in as a customer, redirect to home page
if(!isset($_SESSION['customerID'])) {
    header('Location: ../index.php');
}


if (isset($_POST['submit'])) {
    // $phone = $_POST['phone'];
    
    if (is_uploaded_file($_FILES['profileIMG']['tmp_name'])) {
        $imgData = file_get_contents($_FILES['profileIMG']['tmp_name']);
    }
    // var_dump($phone);
    // var_dump($_FILES);
    // var_dump(base64_encode($imgData));

    $customerID = $_SESSION['customerID'];

    $updatequery = "UPDATE customers SET profileIMG = ? WHERE customerID = ?";
    $stmt = $conn->prepare($updatequery);
    $stmt->bind_param("ss", $imgData, $customerID);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $error = false;
            // update was successful, and at least one row was affected
            // header('Location: ../index.php');
        } else {
            $error = true;
        } 
    } 

    $stmt->close();
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit profile</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php
    if($error) { ?>
    <script>
    Swal.fire({
    icon: 'error',
    //type: 'error',
    title: 'Failed !',
    confirmButtonText: 'OK',
    text: 'Failed to update the profile',
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
    title: 'Updated !',
    confirmButtonText: 'OK',
    text: 'Profile updated successfully',
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
