<?php 
session_start();
include_once("../db_connect.php");

if(!isset($_SESSION['customerID'])) {
    header('Location: ../index.php');
}
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
            <!-- <li><a href="#">Register a service</a></li> -->
        </ul>
        <div class="nav-buttons">
        <?php if (isset($_SESSION['customerID'])) { ?>
                
			<a style="margin:8px 12px;text-align:center;display:block;font-weight:600;font-size:1.25rem;color:#D80032;"><?php echo $_SESSION['customerName']; ?></a>
			<div class="profileImg"  style="margin:0 14px 0 0;">
                <img src="../images/png/user.png" alt="profile image">
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
                <p><a href="./myprofile.php">My Profile</a></p>
                <p><a href="./mybookings.php">My Bookings</a></p>
            </div>
            </div>
        </div>
    </header>
    
    <div class="search-container">
            <div class="search-header">
                <h2>Search for services</h2>
            </div>
            <div class="search-field">
                <!-- <input type="text" name="searchText" id="searchText" placeholder="Search for services"> -->
                <select name="searchCity" id="searchCity">
                    <option value="none">-- Select City --</option>
                    <option value="Bangalore">Bangalore</option>
                    <option value="Mumbai">Mumbai</option>
                    <option value="Chennai">Chennai</option>
                    <option value="Hyderabad">Hyderabad</option>
                    <option value="Delhi">Delhi</option>
                    <option value="Kolkata">Kolkata</option>
                </select>

                <select name="serviceType" id="serviceType">
                    <option value="none">-- Select Service --</option>
                    <option value="Plumbing">Plumbing</option>
                    <option value="Electricals">Electricals</option>
                    <option value="Carpentry">Carpentry</option>
                    <option value="Cleaning">Cleaning</option>
                    <option value="Pest Control">Pest Control</option>
                </select>
            </div>
            <!-- <div class="checklist">
                    <div class="checkbox">
                        <label for="plumbing">Plumbing</label>
                        <input type="checkbox" name="serviceType" class="serviceType" value="Plumbing" id="plumbing">
                    </div>
                    <div class="checkbox">
                        <label for="electricals">Electrician</label>
                        <input type="checkbox" name="serviceType" class="serviceType" value="Electricals" id="electricals">
                    </div>
                    <div class="checkbox">
                        <label for="carpentry">Carpentry</label>
                        <input type="checkbox" name="serviceType" class="serviceType" value="Carpentry" id="carpentry">
                    </div>
                    <div class="checkbox">
                        <label for="cleaning">Cleaning</label>
                        <input type="checkbox" name="serviceType" class="serviceType" value="Cleaning" id="cleaning">
                    </div>
                    <div class="checkbox">
                        <label for="pestcontrol">Pest Control</label>
                        <input type="checkbox" name="serviceType" class="serviceType" value="Pest Control" id="pestcontrol">
                    </div>
            </div> -->


            <div class="search-button">
                <button type="submit" id="searchBtn">
                    Search<img src="../images/svg/search-icon.svg" class="search-icon">
                </button> 
 
            </div>

            <div class="search-results" id="search-results">
                <!-- <div class="search-result">
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
                  -->
            </div>
     </div>

    <script src="../scripts/script.js"></script>
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

    <script>
        //profile drop-down list
        $(".profileImg").click(function() {
            $(".profile-dropdown").toggle("fast");
        })


        //search services
        $(function() {
        $(".profile-dropdown").hide();
        $("#searchBtn").click(function() {

            var searchCity = $("#searchCity").val();
            var serviceType = $("#serviceType").val();

            if (searchCity == "none" || serviceType == "none") {
                alert("Don't leave search fields empty!");
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
                            <p class="timings">Work hours: ${provider.startTime} to ${provider.endTime}</p>
                            <p class="city">${provider.cityName}</p>
                        </div> 
                       <!-- <button class="booknow"><a href='bookservice.php?provider=${provider.serviceProviderID}'>Book now</a></button>-->
                        <button class="booknow"><a href="#modal-${provider.serviceProviderID}" rel="modal:open">Book Now</a></button>
                    </div>
                    </div>
                    <div id="modal-${provider.serviceProviderID}" class="modal booking-box">
                        <form action="./bookservice.php" method="POST">
                        <input type="text" name="serviceProviderID" id="sid" value="${provider.serviceProviderID}" hidden> <br>
                        <input type="number" name="serviceTypeID" id="typeid" value="${provider.serviceTypeID}" hidden> <br>
                        <label for="date">Date</label>
                        <input type="date" name='preferredDate' id="date"> <br>
                        <label>Select time range: </label> <br>
                        <label for="timestart" id="timestart">Start: </label>
                        <input type="time" name='preferredTimeSlotStart' id="timestart"> <br>
                        <label for="timeend">End: </label>
                        <input type="time" name='preferredTimeSlotEnd' id="timeend"> <br>
                        <label for="requestinfo" >More info:</label>
                        <br>
                        <textarea name="customerRequestInfo" id="requestInfo" maxlength="200" placeholder="Describe your needs (in about 200 characters)"></textarea> <br>
                         <input type="submit" name="submit" value="submit">
                        </form>
                        <!--<a href="#" rel="modal:close">Close</a>-->
                    </div>                    
                    
                    `;                      
                        });
                    }
                    $("#search-results").html(searchResult);
                });
            }
        });
    });


    </script>
</body>
</html>