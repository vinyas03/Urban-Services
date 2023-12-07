<?php
$customerID = $_SESSION['customerID'];

$selectquery = "SELECT  * FROM customers
WHERE customerID = '$customerID'";

if ($result = $conn->query($selectquery)) {
    $row = $result->fetch_assoc();
    $profileIMGData = base64_encode($row['profileIMG']); //binary to base64

    //echo "data:image/jpg;base64,$profileIMGData";
} else {
    //echo "No profile image found";
}

?>