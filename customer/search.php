<?php
session_start();
include_once("../db_connect.php");


if (isset($_POST['searchCity']) && isset($_POST['serviceType'])) {
    $input = $_POST;
    
    $city = $input['searchCity'];
    $serviceType = $input['serviceType'];


     $result = $conn->query(
    "SELECT T.cityName, Y.serviceTypeID, Y.serviceTypeName, P.companyName, P.serviceProviderID, P.startTime, P.endTime FROM serviceproviders P, serviceprovidercities C, cities T, serviceproviderservices S, servicetypes Y 
    WHERE P.serviceProviderID=C.serviceProviderID AND T.cityID=C.cityID AND S.serviceProviderID=P.serviceProviderID
     AND Y.serviceTypeID = S.serviceTypeID AND Y.serviceTypeName ='$serviceType' AND T.cityName='$city';
    ");


    $rows = $result->fetch_all(MYSQLI_ASSOC);

    //var_dump($rows);

    if (count($rows) > 0) {
        echo json_encode($rows);
    } else {
        echo '{"failed": true }';
    }


}

?>

