<?php
    ob_start();
    include_once("db_connect.php"); //database connection
    session_start();
    
    if(isset($_SESSION['user_id'])) {
        header("Location: index.php");
    }

    $error = false;

    if (isset($_POST['submit'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password1 = mysqli_real_escape_string($conn, $_POST['password1']);
        $password2 = mysqli_real_escape_string($conn, $_POST['password2']);
        $phone = mysqli_real_escape_string($conn,$_POST['phone']);
        $gender = mysqli_real_escape_string($conn,$_POST['gender']);
        $location = mysqli_real_escape_string($conn,$_POST['location']);
        $securityQuestion = mysqli_real_escape_string($conn,$_POST['securityQuestion']);
        $securityAnswer = mysqli_real_escape_string($conn,$_POST['securityAnswer']);	




        //Google recaptcha v2
        $secret = "6LcV79QoAAAAACVYSUDlzLQxI97er_uIiMWV7JPi";
        $response = $_POST['g-recaptcha-response'];
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip";
        $data = file_get_contents($url);
        $row = json_decode($data, true);

        if ($row['success'] == "true") {
            //echo "<script>alert('you are not a robot ');</script>";
            $error = false;
        } else {
            //echo "<script>alert('you are a robot ');</script>";
            $error = true;
            $registrationerror = "Error: Captcha not verified";
        }
        
        //echo "submitted";

        if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
            $error = true;
            $registrationerror = "Name must contain only alphabets and space";
        }

        if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            $error = true;
            $registrationerror = "Please Enter Valid Email ID";
        }
        if(strlen($password1) < 6) {
            $error = true;
            $registrationerror = "Password must be minimum of 6 characters";
        }
        if($password1 != $password2) {
            $error = true;
            $registrationerror = "Password and Confirm Password doesn't match";
        }

        
        if (!$error) {
            $hashed_password = password_hash($password1, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (Name, Email, Password, Phone, Gender, Location, Security_question, Security_answer) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ssssssss", $name, $email, $hashed_password, $phone, $gender, $location, $securityQuestion, $securityAnswer);
            
            try {
                if(mysqli_stmt_execute($stmt)) {
                    echo "<script>alert('Registered successfully ! Now you can Login.')</script>";
                }
            } catch (mysqli_sql_exception $e) {
                $error = true;
                $registrationerror = "Error in registration : Email or Phone number already exists - ".$e->getMessage(); // Duplicate entry 'spiderman@gmail.com' for key 'Email'
                //echo $conn->error; // Duplicate entry 'spiderman@gmail.com' for key 'Email'
            }
        } 
    }   
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/signup.css">
    <link rel="shortcut icon" href="../images/png/logo.png" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100&display=swap" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Urban Services - Sign Up</title>
</head>
<body>
    <header>
        <div class="toggleBtn">
            <img class="menu" src="./images/svg/burger-menu-left.svg" width="40px" height="40px">
        </div>
        <div class="logo-wrapper">
            <img src="./images/png/logo.png" class="logo">
            <div class="title">Urban Services</div>
        </div>
        <ul class="nav-items">
            <li><a href="./index.php">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Register a service</a></li>
        </ul>
        <div class="nav-buttons">
            <a href="./login.php" class="loginBtn">Login</a>
            <!-- <a href="./signup.html" class="signupBtn">Sign Up</a> -->
        </div>
    </header>

    <form name="regForm" onsubmit="return validateForm()" action="./signup.php" method="POST"> 
        <div class="header">
            <?php if (isset($registrationerror)) { ?>
                <p style="color:crimson;"><?php echo $registrationerror; ?></p>
            <?php }?>
            <h1> Register </h1>   
        </div>

        <div class="form-inputs">
            <div class="form-col form-col-left">
                <div class="container">   
                    <label> Name </label>   
                    <input type="text" placeholder="Name" name="name" required>    
                </div>
                <div class="container">   
                 <label> Phone </label>
                 <input type="tel" placeholder="Enter 10-digit Phone no." name="phone" minlength="10" maxlength="10" required>    
                </div>
                <div class="container">
                    <label> Email </label>   
                    <input type="text" placeholder="Enter your Email" name="email" required> 
                </div>
                
                <div class="container">
                <label for="gender">Gender:</label>
                </div>
                <div class="gender-options">
                    <input type="radio" id="male" name="gender" value="Male" required>
                    <label for="male">Male</label>
                    <input type="radio" id="female" name="gender" value="Female" required>
                    <label for="female">Female</label>
                </div>
                <div class="captcha-box">
                    <div class="g-recaptcha" data-sitekey="6LcV79QoAAAAAF9vV56fVudfAFfLdNcNK0jyyx2-"></div>
                </div>
            </div>
            <div class="form-col form-col-right">
                <div class="container">
                    <label for="location"> Location </label>   
                    <select name="location" id="location">
                        <option value="Bangalore">Bangalore</option>
                        <option value="Mumbai">Mumbai</option>
                        <option value="Chennai">Chennai</option>
                        <option value="Hyderabad">Hyderabad</option>
                        <option value="Delhi">Delhi</option>
                        <option value="Kolkata">Kolkata</option>
                    </select> 
                </div>
                <div class="container">
                    <label>Enter your Password : </label>   
                    <input type="password" placeholder="Password" name="password1" required>
                 </div> 
                 <div class="container">
                    <label>Confirm Password : </label>   
                    <input type="password" placeholder="Password" name="password2" required>
                 </div>
                 <div class="container">   
                    <!-- <label> Security Question </label>   
                    <input type="text" placeholder="Enter your security question" name="securityQuestion" required>     -->
                    <label for="securityQuestion"> Security Question </label>   
                    <select name="securityQuestion" id="securityQuestion">
                        <option value="Your favourite colour ?">Your favourite colour ?</option>
                        <option value="Your favourite place to visit ?">Your favourite place to visit ?</option>
                        <option value="Your Birth month ?">Your Birth month ?</option>
                        <option value="Your nickname ?">Your nickname?</option>
                    </select>
                
                </div>
                <div class="container">   
                    <label> Answer</label>   
                    <input type="text" placeholder="Enter your security answer" name="securityAnswer" required>    
                </div>
            </div>
        </div>
      
        

        <div class="submit-btn">
           <button type="submit" name="submit" value="submit">Register</button> 
        </div>  
        <p class="login-link">Already have an account? <a href="./login.php">Login here</a></p>
       </div>   
   </form>     


    <script src="./scripts/script.js"></script>
    <script src="./scripts/registervalidate.js"></script>
</body>
</html>