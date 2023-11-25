<?php 
session_start();
include_once("../db_connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="shortcut icon" href="../images/png/logo.png" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100&display=swap" rel="stylesheet">
    
    <title>Urban Services - Home</title>
</head>
<body>

    <header>
        <div class="toggleBtn">
            <img class="menu" src="../images/svg/burger-menu-left.svg" width="40px" height="40px">
        </div>
        <div class="logo-wrapper">
            <img src="../images/png/logo.png" class="logo">
            <div class="title">Urban Services</div>
        </div>
        <ul class="nav-items">
            <li><a href="./index.php">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Register a service</a></li>
        </ul>
        <div class="nav-buttons">
        <?php if (isset($_SESSION['user_id'])) { ?>
                
				<a style="margin:8px 12px;text-align:center;display:block;font-weight:600;font-size:1.25rem;color:#D80032;"><?php echo $_SESSION['user_name']; ?></a>
				<a style="margin:8px 6px;font-weight:500;font-size:1.2rem;color:gold;">Profile</a>
                <a style="margin:8px 6px;font-weight:500;font-size:1.2rem;color:gold;">Settings</a>
                <a href="../logout.php"class="loginBtn">Log Out</a>
				<?php } else { ?>
                    <a href="../login.php" class="loginBtn">Login</a>
                    <a href="../signup.php" class="signupBtn">Register</a>				
		        <?php } ?>

        </div>
    </header>


    <!-- <?php //if (isset($_SESSION['user_id'])) { ?> -->
                
    <div class="search-container">
            <div class="search-header">
                <h2>Search for services</h2>
            </div>
            <div class="search-field">
                <input type="text" name="search" placeholder="Search a service provider">
                <select name="city" id="searchCity">
                    <option value="Bangalore">Bangalore</option>
                        <option value="Mumbai">Mumbai</option>
                        <option value="Chennai">Chennai</option>
                        <option value="Hyderabad">Hyderabad</option>
                        <option value="Delhi">Delhi</option>
                    <option value="Kolkata">Kolkata</option>
                </select>
            </div>
            <div class="checklist">
                    <div class="checkbox">
                        <label for="plumbing">Plumbing</label>
                        <input type="checkbox" name="Plumbing" id="plumbing">
                    </div>
                    <div class="checkbox">
                        <label for="electrician">Electrician</label>
                        <input type="checkbox" name="Electrician" id="electrician">
                    </div>
                    <div class="checkbox">
                        <label for="carpentry">Carpentry</label>
                        <input type="checkbox" name="Carpentry" id="carpentry">
                    </div>
                    <div class="checkbox">
                        <label for="cleaning">Cleaning</label>
                        <input type="checkbox" name="Cleaning" id="cleaning">
                    </div>
            </div>


            <div class="search-button">
                <button type="submit">
                    Search<img src="../images/svg/search-icon.svg" class="search-icon">
                </button> 
 
            </div>

            <div class="search-results">
                <div class="search-result">
                    <div class="service-image">
                        <img src="../images/wallpaper-7415571_1280.jpg" alt="">
                    </div>
                    <div class="service-info">
                        <h3 class="title">ABC Plumbers</h3>
                        <div class="description">
                            <p class="text">We specialize in plumbing services. Taps, showers etc.</p>
                            <p class="timings">Mon-Fri 8:00 to 18:00</p>
                            <p class="localities">JP Nagar, Whitefield</p>
                        </div> 
                        <button class="booknow">Book now</button>
                    </div>
                </div>
                <div class="search-result">
                    <div class="service-image">
                        <img src="../images/wallpaper-7415571_1280.jpg" alt="">
                    </div>
                    <div class="service-info">
                        <h3 class="title">ABC Plumbers</h3>
                        <div class="description">
                            <p class="text">We specialize in plumbing services. Taps, showers etc.</p>
                            <p class="timings">Mon-Fri 8:00 to 18:00</p>
                            <p class="localities">JP Nagar, Whitefield</p>
                        </div> 
                        <button class="booknow">Book now</button>
                    </div>
                </div>
                <div class="search-result">
                    <div class="service-image">
                        <img src="../images/wallpaper-7415571_1280.jpg" alt="">
                    </div>
                    <div class="service-info">
                        <h3 class="title">ABC Plumbers</h3>
                        <div class="description">
                            <p class="text">We specialize in plumbing services.</p>
                            <p class="timings">Mon-Fri 8:00 to 18:00</p>
                            <p class="localities">JP Nagar, Whitefield</p>
                        </div> 
                        <button class="booknow">Book now</button>
                    </div>
                </div>
            </div>
    </div>   

    <!-- <?php //} else {?>
    <div class="hero-container">
        <div class="hero-text">
            <h1 class="hero-title">Urban Services</h1>
            <p class="hero-info">
                Your one stop destination for Home Services.
                We provide services like: Plumbing, Carpentry, Cleaning and Electrical works.
            </p>
        </div>
        <div class="hero-image">
            <img src="../images/png/mechanic.png" alt="hero image">
        </div>
    </div>
    <?php //}?> -->

    <script src="../scripts/script.js"></script>
</body>
</html>