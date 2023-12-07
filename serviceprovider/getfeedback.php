<?php 
session_start();
include_once("../db_connect.php");

if(!isset($_SESSION['serviceProviderID'])) {
    header('Location: ../index.php');
}

//not that secure, bookingID anyone can send it. Better use serviceProivder session ID with joins.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $bookingID = $_POST['bookingID'];
    $selectquery = "SELECT * FROM feedback WHERE bookingID = '$bookingID'";

    $result = $conn->query($selectquery);
    //$error = false;
    $row = $result->fetch_assoc();
    // $rating = $row['rating'];
    // $remarks = $row['remarks'];
    

if ($result) {
    echo json_encode($row);
} else {
    echo json_encode(['failed' => true]);
}

}
?>