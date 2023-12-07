<?php 
session_start();
include_once("../db_connect.php");

if(!isset($_SESSION['customerID'])) {
    header('Location: ../index.php');
}

include_once("./includes/fetchProfileIMG.php");

$customerID = $_SESSION['customerID'];
$result = $conn->query("
    SELECT * FROM accounts, customers, cities
    WHERE accounts.userID = customers.userID AND customers.cityID = cities.cityID 
    AND customers.customerID = '$customerID' 
");
$row = $result->fetch_assoc();
$userID = $row['userID'];
$customerID = $row['customerID'];                
$customerName = $row['customerName'];
$gender = $row['gender'];
$email = $row['email'];
$phone = $row['phone'];
$city = $row['cityName'];

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css" integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- jQuery Modal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <title>Urban Services - Home</title>
</head>
<style>



/*Profile box*/
.profile-box {
    display: grid;
    grid-template-columns: 2fr 1fr;
}
.profile-box .profile-image {
    align-self: stretch; 
    /* place-self: center; */
    display: grid;
    place-items: center;
}
.profile-box .profile-image img {
    max-width: 100%;

}


.edit-btn {
    padding: 5px 10px;
    margin: 2px;
    cursor: pointer;   
    text-decoration: none;
    background: #4681f4;
    color:#f4f4f4;
}

/*editProfile form*/
/* Forms*/

.form-container {
    max-width: 400px;
    margin: 20px auto;
    padding: 20px;
    background-color: #f4f4f4;
    border: 1px solid #ddd;
}

h2 {
    text-align: center;
    color: #333;
}

form {
    display: grid;
    gap: 10px;
}

label {
    display: block;
    margin-bottom: 5px;
    color: #555;
}

input, textarea {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
}

button {
    background-color: #3498db;
    color: #fff;
    padding: 10px;
    border: none;
    cursor: pointer;
}

</style>

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
            <!-- <li><a href="#">Register a service</a></li> -->
        </ul>
        <div class="nav-buttons">
        <?php if (isset($_SESSION['customerID'])) { ?>
                
			<a style="margin:8px 12px;text-align:center;display:block;font-weight:600;font-size:1.25rem;color:#D80032;"><?php echo $_SESSION['customerName']; ?></a>
			<div class="profileImg"  style="margin:0 14px 0 0;">
            <img src="<?php echo (isset($profileIMGData)) ? "data:image/jpg;base64,$profileIMGData" : "../images/png/user.png"; ?>" alt="profile image">
            </div>
            <!-- <a style="margin:8px 6px;font-weight:500;font-size:1.2rem;color:gold;">Profile</a> -->
                
            <!-- <a style="margin:8px 6px;font-weight:500;font-size:1.2rem;color:gold;">Settings</a> -->
            <a href="../logout.php"class="loginBtn">Log Out</a>
			<?php } else { ?>
                    <a href="../login.php" class="loginBtn">Login</a>
                    <a href="../signup.php" class="signupBtn">Register</a>				
		    <?php } ?>
            <div class="profile-dropdown">
            <div class="profile-options">
                <!-- <p><a href="./myprofile.php">My Profile</a></p> -->
                <p><a href="./mybookings.php">My Bookings</a></p>
            </div>
            </div>
        </div>
    </header>
    


    <div class="profile-container">
        <div class="profile-header">
            <h2>My Profile</h2>
        </div>
        <div class="profile-box">
            <div class="profile-info">
                <div class="user-id">
                    <p>userID: <span><?php echo $userID; ?> </span></p>
                </div>
                <div class="customer-id">
                    <p>customerID: <span><?php echo $customerID; ?> </span></p>
                </div>
                <div class="customer-name">
                    <p>Customer Name: <span><?php echo $customerName; ?> </span></p>
                </div>
                <div class="customer-email">
                    <p>Email: <span><?php echo $email; ?> </span></p>
                </div>
                <div class="customer-phone">
                    <p>Phone: <span><?php echo $phone;?> </span></p>
                </div>
                <div class="customer-gender">
                    <p>Gender: <span><?php echo $gender;?> </span></p>
                </div>
                <div class="customer-city">
                    <p>City: <span><?php echo $city;?> </span></p>
                </div>
                <a class="edit-btn" href="#editProfile-box" rel="modal:open">Edit Profile</a>
            </div>

            <div class="profile-image">
            <img src="<?php echo (isset($profileIMGData)) ? "data:image/jpg;base64,$profileIMGData" : "../images/png/user.png"; ?>" alt="profile image">
            </div>
        </div>
    </div>   

    <div id="editProfile-box" class="modal">
    <form action="./editprofile.php" method="post" enctype="multipart/form-data">
            <label for="phone">Phone:</label>
            <input type="tel" placeholder="Enter 10-digit Phone no." name="phone" minlength="10" maxlength="10" required>    
            <label for="photo" class="choose-photo">Profile Photo: </label>
            <input type="file" id="photo" name="profileIMG" accept="image/*">
            <button type="submit" name="submit">Submit</button>
        </form>       
    </div>



    <script src="../scripts/script.js"></script>

    <script>
        //profile drop-down list
        $(".profileImg").click(function() {
            $(".profile-dropdown").toggle("fast");
        })
        
        $(function() {
        $(".profile-dropdown").hide();
        });
    </script>
    <!-- <script>
        const searchText = document.querySelector('#searchText');
        const searchCity = document.querySelector('#searchCity');
        //const checkboxes= document.querySelector('.serviceType');
        const searchBtn = document.querySelector('#searchBtn');


        let searchQuery = '?';
        let searchTextQuery = '';
        let searchCityQuery = '';

        searchText.addEventListener('keyup', () => {
            if(searchText.value !== '') {
                searchTextQuery = 'searchText='+searchText.value;
            }
            console.log(searchTextQuery)
        });

        let searchCitySelect = document.querySelector('#searchCity');
        //default selected city
        searchCityQuery = 'searchCity=' + searchCitySelect.options[searchCitySelect.selectedIndex].value;
        console.log(searchCityQuery);
        //listen for change in select element
        searchCitySelect.addEventListener('change', () => {
        let selectedOption = searchCitySelect.options[searchCitySelect.selectedIndex];
        if (selectedOption.value !== '') {
            searchCityQuery = 'searchCity=' + selectedOption.value;
        }
        console.log(searchCityQuery);
        });


        let params = new URLSearchParams();
        let checkboxes = document.querySelectorAll('input[name="serviceType"]');
        checkboxes = Array.from(checkboxes);
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('click', () => {
                checkboxes.forEach(function(checkbox){
                    if(checkbox.checked  && !params.has('serviceType[]', checkbox.value)) { 
                        params.append('serviceType[]', checkbox.value); 
                    }
                    if (!checkbox.checked){ 
                        params.delete('serviceType[]', checkbox.value)
                    }
                });
                console.log(searchQuery)

                //console.log(params.getAll('serviceType[]'));
                //console.log(params.toString())
            });
        });
            

        searchBtn.addEventListener('click', () => {
            searchQuery = searchQuery + searchTextQuery + '&' + searchCityQuery + '&' + params.toString();
 
            function search() {
        const baseURL = url + "?p=" + val.page; //page no.
        page.message.textContent = "loading....";
        fetch(baseURL)
        .then((response) => response.json())
        .then((json) => {
        if (json.data.pages.next != null) {
        //next page is available
        page.loaderMore = true;
        page.message.textContent =
          "Page " + val.page + " -Scroll to load more...";
        } else {
        page.message.style.display = "none";
       }
       console.log(json);
       renderPost(json.data.posts);
       });
}           
        });


    </script> -->

    <!-- <script>
        //profile drop-down list
        $(".profileImg").click(function() {
            $(".profile-dropdown").toggle("fast");
        })

        $(function() {
            $(".profile-dropdown").hide();

            $("#searchBtn").click(function() {

            var searchCity = $("#searchCity").val();
            var serviceType = $("#serviceType").val();

            if (searchCity == "none" || serviceType == "none") {
                alert("Don't leave fields empty!");
            } else {
                $.post('search.php', {
                    searchCity: searchCity,
                    serviceType: serviceType
                }, function(res) {
                    var providers = JSON.parse(res);
                    var searchResult = "";

                    if (providers.failed == true) {
                        searchResult = `<p style="color:red">No Service Providers found...<p>`;
                    } else {
                        providers.forEach(function(provider, i) {
                            searchResult += `
                            <div class="search-result">
                    <div class="service-image">
                        <img src="../images/3-316-16-9-aspect-ratio-s-sfw-wallpaper-preview (2).jpg" alt="">
                    </div>
                    <div class="service-info">
                        <h3 class="title">${provider.companyName}</h3>
                        <h5 class="sid">${ provider.serviceProviderID}</h5>
                        <div class="description">
                            <p class="text">${provider.serviceTypeName}</p>
                            <p class="timings">Available: Mon/Tue/Wed/Thu/Fri</p>
                            <p class="city">${provider.cityName}</p>
                        </div> 
                        <button class="booknow"><a href='bookservice.php?provider=${provider.serviceProviderID}'>Book now</a></button>
                    </div>
                    </div>`;                      
                        });
                    }
                    $("#search-results").html(searchResult);
                });
            }
        });
    });
    </script> -->
</body>
</html>