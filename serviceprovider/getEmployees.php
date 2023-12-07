<?php
session_start();
include_once("../db_connect.php");

if(!isset($_SESSION['serviceProviderID'])) {
    header('Location: ../index.php');
    }


if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_SESSION['serviceProviderID'])) {
    $serviceProviderID = $_SESSION['serviceProviderID'];
    $result = $conn->query(
        "SELECT * FROM serviceemployees S, servicetypes T
        WHERE S.serviceProviderID = '$serviceProviderID' AND S.serviceTypeID = T.serviceTypeID
        ");

    // $result = $conn->query(
    //     "SELECT * FROM serviceemployees S, serviceprovideremployees T
    //     WHERE S.employeeID = T.employeeID AND serviceProviderID = '$serviceProviderID'
    //     ");

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