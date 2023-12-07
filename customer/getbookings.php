<?php
session_start();
include_once("../db_connect.php");

if(!isset($_SESSION['customerID'])) {
    header('Location: ../index.php');
    }


if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_SESSION['customerID'])) {
    $customerID = $_SESSION['customerID'];
    $result = $conn->query(
        "SELECT * FROM bookings B, cities C, servicetypes S, serviceproviders T
        WHERE customerID = '$customerID' AND B.cityID = C.cityID AND B.serviceTypeID = S.serviceTypeID AND B.serviceProviderID = T.serviceProviderID;
        ");
    
        //$rows = $result->fetch_all(MYSQLI_ASSOC);
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

