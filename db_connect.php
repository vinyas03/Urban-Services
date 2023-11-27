<?php
/* Database connection start */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "urban services";

try {
    $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
} catch (mysqli_sql_exception $e) {
    echo "Database connection error";
}


// if (mysqli_connect_errno()) {
//     printf("Connect failed: %s\n", mysqli_connect_error());
//     exit();
// }
?>