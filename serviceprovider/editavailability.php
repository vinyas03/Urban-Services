<?php 
session_start();
include_once("../db_connect.php");

//if not logged in as a service provider, redirect to home page
if(!isset($_SESSION['serviceProviderID'])) {
    header('Location: ../index.php');
}

if (isset($_POST['submit'])) {
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    

    // var_dump($phone);
    // var_dump($_FILES);
    // var_dump(base64_encode($imgData));
    $serviceProviderID = $_SESSION['serviceProviderID'];

    $updatequery = "UPDATE serviceproviders
     SET startTime = ?, endTime = ? WHERE serviceProviderID = ?";
    $stmt = $conn->prepare($updatequery);
    $stmt->bind_param("sss", $startTime, $endTime, $serviceProviderID);

    if ($stmt->execute()) {
        echo "Timings updated successfully";
    } else {
        echo "Failed to update the timings";
    }

    $stmt->close();
}