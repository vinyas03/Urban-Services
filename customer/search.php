<?php
session_start();
include_once("../db_connect.php");


if (isset($_POST['searchCity']) && isset($_POST['serviceType'])) {
    $input = $_POST;
    
    $city = $input['searchCity'];
    $serviceType = $input['serviceType'];


     $result = $conn->query(
    "SELECT * FROM serviceproviders P, serviceprovidercities C, cities T, serviceproviderservices S, servicetypes Y 
    WHERE P.serviceProviderID=C.serviceProviderID AND T.cityID=C.cityID AND S.serviceProviderID=P.serviceProviderID
     AND Y.serviceTypeID = S.serviceTypeID AND Y.serviceTypeName ='$serviceType' AND T.cityName='$city';
    ");

    //$rows = $result->fetch_all(MYSQLI_ASSOC);
    while ($row = $result->fetch_assoc()) {
        // Encode image data using base64
        $row['profileIMG'] = base64_encode($row['profileIMG']);
        $rows[] = $row;
        }
        //var_dump($rows);
    
        // if (count($rows) > 0) {
        if(isset($rows)) {
            echo json_encode($rows);
        } else {
            echo '{"failed": true }';
        }
    

}

?>

