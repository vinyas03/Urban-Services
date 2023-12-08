<?php
session_start();
include_once("../db_connect.php");

if(!isset($_SESSION['serviceProviderID'])) {
    header('Location: ../index.php');
    }


if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_SESSION['serviceProviderID'])) {
    $serviceProviderID = $_SESSION['serviceProviderID'];
    $result = $conn->query(
        "SELECT * FROM customers A, bookings B, cities C, servicetypes S
        WHERE serviceProviderID = '$serviceProviderID' AND B.customerID = A.customerID 
        AND B.cityID = C.cityID AND B.serviceTypeID = S.serviceTypeID
        ");


    // $rows = $result->fetch_all(MYSQLI_ASSOC);
        
        //var_dump($rows);
        while ($row = $result->fetch_assoc()) {
            // Encode image data using base64
            $row['profileIMG'] = base64_encode($row['profileIMG']);
            $rows[] = $row;
        }
        //var_dump($rows);
    
        if (count($rows) > 0) {
            echo json_encode($rows);
        } else {
            echo '{"failed": true }';
        }
    
}


?>

