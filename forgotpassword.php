<?php 
session_start();
include_once("db_connect.php");

if(isset($_SESSION['userID']) && isset($_SESSION['customerID']))  {
    header("Location: customer/index.php");
}
if(isset($_SESSION['userID']) && isset($_SESSION['serviceProviderID']))  {
    header("Location: serviceprovider/index.php");
}

$error = false;
$emailExists = false;
$securityAnswer = '';
if (isset($_POST['submit'])) {
	$email = mysqli_real_escape_string($conn, $_POST['email']);

    if (!$error) {
        $stmt = $conn->prepare("SELECT * FROM accounts WHERE email = ?"); //as Email is set to UNIQUE
        // Bind the email as a parameter
        $stmt->bind_param("s",$email);
        // Execute the statement
        $stmt->execute();
        // Get the result set
        $rows = $stmt->get_result();
        // Fetch the data (assuming you want to retrieve user information)
        //$user = mysqli_fetch_assoc($result);

        if($rows->num_rows > 0) {
            $user = $rows->fetch_assoc();
            $securityQuestion = $user['securityQuestion'];
            $securityAnswer = $user['securityAnswer'];
            
            //email is found
            $emailExists = true;

            if (isset($_POST['securityAnswer'])) {
                //echo "Success";
                $securityAnswer = $_POST['securityAnswer'];

                $result = $conn->query("SELECT * FROM accounts WHERE email = '$email' AND securityAnswer = '$securityAnswer'");
                if($result->num_rows > 0) {
                    $answerCorrect = true;

                    if (isset($_POST['newPassword'])) {
                        $newPassword = $_POST['newPassword'];
                        $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);

                        $updatequery = "UPDATE accounts SET password = '$hashed_password' WHERE email = '$email'";

                        if($conn->query($updatequery)) {
                            echo "<script>alert('Updated new password')</script>";
                        } else {
                            echo "<script>alert('Failed to new password')</script>";
                        }
                        //echo "$newPassword new pass";
                    }
                    //echo "Correct answer matched";
                } else {
                    $answerCorrect = false;
                    $errormsg = "Wrong answer";
                }
                
            }
            //echo "$securityQuestion "." $securityAnswer";
            
    

            }
        } else {
            $error = true;
            $errormsg = "Email doesn't exists in our system";
        }
    }


    

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/login.css">
    <link rel="shortcut icon" href="../images/png/logo.png" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100&display=swap" rel="stylesheet">
    <title>Urban Services - Forgot password</title>
    <style>
        input[type="text"] {
        background: #ffffff;
        }
    </style>

</head>
<body> 
    <header>
        <div class="toggleBtn">
            <img class="menu" src="./images/svg/burger-menu-left.svg" width="40px" height="40px">
        </div>
        <div class="logo-wrapper">
            <img src="./images/png/logo.jpeg" class="logo">
            <!-- <div class="title">Urban Services</div> -->
        </div>
        <ul class="nav-items">
            <li><a href="./index.php">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Register a service</a></li>
        </ul>
        <div class="nav-buttons">
            <!-- <a href="./login.html" class="loginBtn">Login</a> -->
            <a href="./login.php" class="loginBtn">Login</a>
        </div>
    </header>

    <form class="loginForm" name="loginForm" onsubmit="return validateForm()" action="./forgotpassword.php" method="POST"> 
        <div class="header">
            <?php if (isset($errormsg)) { ?>
                <p style="color:crimson;"><?php echo $errormsg; ?></p>
            <?php }?>
            <h1> Reset password </h1>   
        </div>
       <div class="container">   
           <label>Enter your email : </label>   
           <input type="text" placeholder="Enter your Email" name="email" required>  
       </div>
       <div class="container">   
            <?php if(isset($emailExists) && $emailExists == true) { ?>
           <label>Your Security Question: </label>
            <div id="securityQuestion">
                <input type="text" value="<?php if(isset($securityQuestion)) { echo $securityQuestion; }?>" name="securityAnswer" disabled>      
            </div> 
        </div>
        <div class="container">   
           <label>Your Security Answer: </label>
           <input type="text" placeholder="Enter your Answer" name="securityAnswer" required>      
       </div>
       <?php } ?>     
       <div class="container">
            <?php
                if (isset($answerCorrect) && $answerCorrect == true) {
            ?>
            <label>Your new Password: </label>
            <input type="text" placeholder="Enter the password" name="newPassword" required>  
            <?php
                }
            ?>
       </div>
        <div>
           <button type="submit" value="submit" name="submit">Send</button> 
        </div>  
       </div>   
    </form>

    <script src="./scripts/script.js"></script>
    <script src="./scripts/loginvalidate.js"></script>
</body>
</html>