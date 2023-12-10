<?php
session_start();
include_once("../db_connect.php");

if(!isset($_SESSION['customerID'])) {
    header('Location: ../index.php');
    }

if (isset($_POST['submit'])) {

    $bookingID = $_POST['bookingID'];
    $rating = $_POST['rating'];
    $remarks =$_POST['remarks'];
    $rating = intval($rating);
    //var_dump($_POST);

    //check for already existing feedback for that bookingID
    $error = false;
    $selectquery = "SELECT * FROM feedback where bookingID = '$bookingID'";
    $result = $conn->query($selectquery);
    if ($result->num_rows > 0) {
        $error = true;
    }

    if(!$error) {
        // $insertquery = "INSERT INTO feedback 
        // (bookingID, rating, remarks) 
        // VALUES (?, ?, ?)";
        // $stmt = $conn->prepare($insertquery);
        // $stmt->bind_param("sis", $bookingID, $rating, $remarks);
        // $stmt->execute();
        $conn->query("INSERT INTO feedback 
         (bookingID, rating, remarks) VALUES ('$bookingID', $rating, '$remarks')");
        //echo "$bookingID  $rating   $remarks";
        echo "Feedback submitted successfully";
    } else {
        $error = true;
        echo "Feedback submission failed! You have already sent a feedback.";
    }

    // if() {
    //     $error = false;
    //     echo "Feedback submitted successfully";
    // } else {
        
    // }
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit feedback</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php
    if($error) { ?>
    <script>
    Swal.fire({
    icon: 'error',
    //type: 'error',
    title: 'Failed!',
    confirmButtonText: 'OK',
    text: ' You have already sent a feedback.',
    footer: '',
    allowOutsideClick: false
    //showCloseButton: true
})
.then(function (result) {
    if (result.value) {
        window.location = "./mybookings.php";
    }
})


     </script>
   <?php     
    } else {   ?>   
        <script>
    Swal.fire({
    icon: 'success',
    //type: 'error',
    title: 'Success !',
    confirmButtonText: 'OK',
    text: 'Feedback submitted successfully',
    footer: '',
    allowOutsideClick: false
    //showCloseButton: true
})
.then(function (result) {
    if (result.value) {
        window.location = "./mybookings.php";
    }
})


     </script>

     <?php }?>
</body>
</html>
