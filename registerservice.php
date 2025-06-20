<?php
    session_start();
    include_once("db_connect.php"); //database connection
  
    $error = false;

    if (isset($_POST['submit'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password1 = mysqli_real_escape_string($conn, $_POST['password1']);
        $password2 = mysqli_real_escape_string($conn, $_POST['password2']);
        $phone = mysqli_real_escape_string($conn,$_POST['phone']);
        $location = mysqli_real_escape_string($conn,$_POST['location']);
        $securityQuestion = mysqli_real_escape_string($conn,$_POST['securityQuestion']);
        $securityAnswer = mysqli_real_escape_string($conn,$_POST['securityAnswer']);
        $serviceList = $_POST['servicelist'];	

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

        /*Service provider names can contain numbers also */

        // if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
        //     $error = true;
        //     $registrationerror = "Name must contain only alphabets and space";
        // }

        if(strlen($phone) !== 10) {
            $error = true;
            $registrationerror = "Please enter 10-digit valid phone number";
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

        $validServiceTypes = array(
            "Electricals",
            "Plumbing",
            "Carpentry",
            "Cleaning",
            "Pest Control"
        );

        //loop through service list
        foreach ($serviceList as $index => $serviceType) {
            if(!in_array($serviceType, $validServiceTypes)) {
                $error = true;
                $registrationerror = "All the service types selected must be valid";
                break;
            }
            
            //sanitize
            $serviceList[$index] = mysqli_real_escape_string($conn, $serviceType);
        }


        $validLocations = array(
            "Bangalore",
            "Delhi",
            "Mumbai",
            "Hyderabad",
            "Kolkata",
            "Chennai"
        );

        if(!in_array($location, $validLocations)) {
            $error = true;
            $registrationerror = "Please select a valid city";
        }

        $validSecurityQuestions = array(
            "Your favourite colour ?",
            "Your favourite place to visit ?",
            "Your birth month ?",
            "Your nickname ?"
        );

        if(!in_array($securityQuestion, $validSecurityQuestions)) {
            $error = true;
            $registrationerror = "Please select a valid security question";
        }
        
        
        if (!$error) {
            $hashed_password = password_hash($password1, PASSWORD_DEFAULT);

            //find total accounts in the database
            $result = $conn->query(
                "SELECT SUM(total_users) AS total_users, SUM(total_serviceProviders) AS total_serviceProviders 
                FROM totalaccounts"
            );
            $row = $result->fetch_assoc();
            $total_users = $row['total_users'];
            $total_serviceProviders = $row['total_serviceProviders'];

            // Generate 20 character userID
            $userID = sprintf("user%016d", $total_users + 1);

            // Generate 20 character serviceProviderID
            $serviceProviderID = sprintf("sprv%016d", $total_serviceProviders + 1);

            $role = "ServiceProvider"; //role is enum and can be one of "Customer" or "ServiceProvider"


            $insertquery1 = "INSERT INTO accounts (userID, email, password, role, securityQuestion, securityAnswer) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt1 = $conn->prepare($insertquery1);
            $stmt1->bind_param("ssssss", $userID, $email, $hashed_password, $role, $securityQuestion, $securityAnswer);
            
            //fetch the cityID 
            $result = $conn->query(
                "SELECT cityID FROM cities
                WHERE cityName='$location'
                "
            );
            $row = $result->fetch_assoc();
            $cityID = $row['cityID'];            

            $insertquery2 = "INSERT INTO serviceproviders (serviceProviderID, userID, companyName, phone, cityID) VALUES (?, ?, ?, ?, ?)";
            $stmt2 = $conn->prepare($insertquery2);
            $stmt2->bind_param("ssssi",$serviceProviderID, $userID, $name, $phone, $cityID);


            try {
                if($stmt1->execute() && $stmt2->execute()) {

                    //insert the service types
                    foreach ($serviceList as $index => $serviceType) {

                        //fetch the serviceTypeID correcponding to the input serviceType
                        //fetch the cityID 
                        $result = $conn->query(
                            "SELECT serviceTypeID FROM servicetypes
                            WHERE serviceTypeName ='$serviceType'
                            "
                        );
                        $row = $result->fetch_assoc();
                        $serviceTypeID = $row['serviceTypeID'];                


                        $insertquery3 = "INSERT INTO serviceproviderservices (serviceProviderID, serviceTypeID) VALUES (?, ?)";
                        $stmt3 = $conn->prepare($insertquery3);
                        $stmt3->bind_param("si",$serviceProviderID, $serviceTypeID);
                        $stmt3->execute();
                    }

                    //Insert the single city into serviceprovidercities                    
                    $insertquery4 = "INSERT INTO serviceprovidercities (serviceProviderID, cityID) VALUES (?, ?)";
                    $stmt4 = $conn->prepare($insertquery4);
                    $stmt4->bind_param("si",$serviceProviderID, $cityID);
                    $stmt4->execute();


                    //Feature: Multiple service cities ($serviceCities received via POST)
                    //insert the serviceprovider cities
                    // foreach ($serviceCities as $index => $serviceCity) {
                    //     //fetch the cityID 
                    //     $result = $conn->query(
                    //     "SELECT cityID FROM cities
                    //     WHERE cityName='$serviceCities'
                    //     "
                    //     );
                    //     $row = $result->fetch_assoc();
                    //     $cityID = $row['cityID'];

                    //     $insertquery4 = "INSERT INTO serviceprovidercities (serviceProviderID, serviceTypeName) VALUES (?, ?)";
                    //     $stmt4 = $conn->prepare($insertquery4);
                    //     $stmt4->bind_param("ss",$serviceProviderID, $cityID);
                    //     $stmt4->execute();
                    // }

                    
                    //increase user count
                    $conn->query(
                        "UPDATE totalaccounts SET
                        total_users = total_users + 1,
                        total_serviceProviders = total_serviceProviders + 1
                        "
                    );

                    //redirect to service provider home page or login page
                    echo "<script>alert('Registered successfully !</script>";

                    //destroy older session
                    //session_destroy();
                    session_unset();

                    $_SESSION['userID'] = $userID;
                    $_SESSION['serviceProviderID'] = $serviceProviderID;
                    $_SESSION['companyName'] = $name;
                    //$stm1->close();
                    //$stm2->close();
                    //$stm3->close();
                    //$stm4->close();

                    
                    header('Location: serviceprovider/index.php');
                }
            } catch (mysqli_sql_exception $e) {
                $error = true;
                $registrationerror = "Error in registration : ".$e->getMessage(); // Duplicate entry 'spiderman@gmail.com' for key 'Email'
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
    <link rel="stylesheet" href="./styles/registerservice.css">
    <link rel="shortcut icon" href="../images/png/logo.png" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100&display=swap" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css" integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Urban Services - Register a Service</title>

    <style>
        .selectize-dropdown, .selectize-input { 
        padding: 12px 8px; 
     }
     .selectize-input {
        font-size: 1.05rem; /*  line-height: 1rem; */
        }
        .selectize-dropdown {
            font-size: 1.05rem; /*  line-height: 1rem; */
         }
        .selectize-input input {
            font-size: 1.05rem;
        }
    </style>
</head>
<body>
    <header>
        <div class="toggleBtn">
            <img class="menu" src="./images/svg/burger-menu-left.svg" width="40px" height="40px">
        </div>
        <div class="logo-wrapper">
            <img src="./images/png/logo.png" class="logo" />
            <!-- <div class="title">Urban Services</div> -->
        </div>
        <ul class="nav-items">
            <li><a href="./index.php">Home</a></li>
            <li><a href="#">About</a></li>
        </ul>
        <div class="nav-buttons">
            <a href="./login.php" class="loginBtn">Login</a>
            <!-- <a href="./signup.html" class="signupBtn">Sign Up</a> -->
        </div>
    </header>

    <form name="regForm" onsubmit="return validateForm()" action="./registerservice.php" method="POST"> 
        <div class="header">
            <?php if (isset($registrationerror)) { ?>
                <p style="color:crimson;"><?php echo $registrationerror; ?></p>
            <?php }?>
            <h1> Register a service</h1>   
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
                    <label for="servicelist"> Service List </label>   
                    <select name="servicelist[]" id="servicelist" multiple>
                        <option value="Plumbing">Plumbing</option>
                        <option value="Electricals">Electricals</option>
                        <option value="Carpentry">Carpentry</option>
                        <option value="Cleaning">Cleaning</option>
                        <option value="Pest Control">Pest Control</option>
                    </select> 
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
                        <option value="Your birth month ?">Your birth month ?</option>
                        <option value="Your nickname ?">Your nickname ?</option>
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
        <p class="login-link">Already have a provider account? <a href="./login.php">Login here</a></p>
       </div>   
   </form>     


    <script src="./scripts/script.js"></script>
    <script src="./scripts/registervalidate.js"></script>

    <script>

    //Selectize library configuration
  $(function () {
    $("#servicelist").selectize({
        plugins:['remove_button',"clear_button"],
        placeholder: 'Select your services   '
    });
    $("#location").selectize({
        plugins:['remove_button'],
    });
    $("#securityQuestion").selectize({
        plugins:['remove_button'],
    });
  });
</script>
</body>
</html>