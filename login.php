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

if (isset($_POST['submit'])) {
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = $_POST['password'];


    //Google recaptcha v2
    $secret = "6LcV79QoAAAAACVYSUDlzLQxI97er_uIiMWV7JPi";
    $response = $_POST['g-recaptcha-response'];
    $remoteip = $_SERVER['REMOTE_ADDR'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip";
    $data = file_get_contents($url);
    $row = json_decode($data, true);

    if ($row['success'] == "true") {
        //echo "<script>alert('You are a Human.');</script>";
        $error = false;
    } else {
        //echo "<script>alert('Bot detected !');</script>";
        $error = true;
        $loginerror = "Error: Captcha not verified";
    }

    //$hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // Create a prepared statement
    //$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE Email = ?");
    //if ($stmt) {
    // Bind the email as a parameter
    //mysqli_stmt_bind_param($stmt, "s", $email);
    // Execute the statement
    //mysqli_stmt_execute($stmt);
    // Get the result
    //$result = mysqli_stmt_get_result($stmt);
    // Fetch the data (assuming you want to retrieve user information)
    //$user = mysqli_fetch_assoc($result);
    //$user = $result->fetch_assoc();

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
        $user = $rows->fetch_assoc();

        //if 1 row is found (since email is unique) and then verify password
        if ($user && password_verify($password, $user['password'])) {
            if($user['role'] == 'Customer') {
                $result = $conn->query("
                SELECT * FROM accounts, customers
                WHERE accounts.userID = customers.userID AND accounts.email = '$email' 
                ");
                $row = $result->fetch_assoc();

                $_SESSION['userID'] = $row['userID'];
                $_SESSION['customerID'] = $row['customerID'];
                $_SESSION['customerName'] = $row['customerName'];

                header('Location: customer/index.php');

            }
            if($user['role'] == 'ServiceProvider') {
                $result = $conn->query("
                SELECT * FROM accounts, serviceproviders
                WHERE accounts.userID = serviceproviders.userID AND accounts.email = '$email' 
                ");
                $row = $result->fetch_assoc();

                $_SESSION['userID'] = $row['userID'];
                $_SESSION['serviceProviderID'] = $row['serviceProviderID'];
                $_SESSION['companyName'] = $row['companyName'];

                header('Location: serviceprovider/index.php');

            }
	
        } else {
            $error = true;
            $loginerror = "Incorrect Email or Password!!!";
        }
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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Urban Services - Login</title>
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
            <a href="./signup.php" class="signupBtn">Register</a>
        </div>
    </header>

    <form class="loginForm" name="loginForm" onsubmit="return validateForm()" action="./login.php" method="POST"> 
        <div class="header">
            <?php if (isset($loginerror)) { ?>
                <p style="color:crimson;"><?php echo $loginerror; ?></p>
            <?php }?>
            <h1> Login </h1>   
        </div>
       <div class="container">   
           <label>Email : </label>   
           <input type="text" placeholder="Enter your Email" name="email" required>  
       </div>
       <div class="container">
           <label>Password : </label>   
           <input type="password" placeholder="Enter Password" name="password" required>
        </div>

        <div class="captcha-box">
            <div class="g-recaptcha" data-sitekey="6LcV79QoAAAAAF9vV56fVudfAFfLdNcNK0jyyx2-"></div>
        </div>
        

        <div>
           <button type="submit" value="submit" name="submit">Login</button> 
        </div>  
        <!--   <input type="checkbox" checked="checked"> Remember me  
           <br> 
         <button type="button" class="cancelbtn"> Cancel</button> -->   
        <div class="form-footer">
           <div class="forgot-password">
                <p>Forgot<a href="./forgotpassword.php"> password? </a></p>
           </div>
            <div class="register-here">
                <p class="register-link">Don't have an account? <a href="./signup.php">Register</a> Here</p>
            </div>   
        </div>   

       </div>   
    </form>

    <script src="./scripts/script.js"></script>
    <script src="./scripts/loginvalidate.js"></script>
</body>
</html>