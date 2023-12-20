<?php
session_start();
include_once("../db_connect.php");

if (!isset($_SESSION['customerID'])) {
  header('Location: ../index.php');
}

include_once("./includes/fetchProfileIMG.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../styles/index.css" />
  <link rel="shortcut icon" href="../images/png/logo.png" type="image/x-icon" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100&display=swap" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css" integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- jQuery Modal -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
  <title>Customer - Home</title>
</head>

<style>
  /*booking form */
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

  input,
  textarea {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
  }

  .submitBtn {
    background-color: #3498db;
    color: #fff;
    padding: 10px;
    border: none;
    cursor: pointer;
  }





  /* Select city and service*/
  @import url("https://fonts.googleapis.com/css?family=Montserrat&display=swap");

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    outline: none;
    list-style: none;
    font-family: "Montserrat", sans-serif;
  }

  .wrapper {
    /* position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%); */
    display: flex;
    align-items: center;
    justify-content: center;
    max-width: 1200px;
  }

  .wrapper .search_box {
    /* width: 500px; */
    background: #fff;
    border-radius: 5px;
    height: 65px;
    display: flex;
    padding: 10px;
    box-shadow: 0 8px 6px -10px #b3c6ff;
  }

  .wrapper .search-button {
    margin: 0 10px;
  }

  .wrapper .search_box .dropdown {
    width: 200px;
    color: #22053e;
    position: relative;
    cursor: pointer;
  }

  .wrapper .search_box.searchCityBox {
    border: 1px solid #dde2f1;
  }

  .wrapper .search_box.searchServiceBox {
    border: 1px solid #dde2f1;
  }

  .wrapper .search_box .dropdown .default_option {
    text-transform: uppercase;
    padding: 13px 15px;
    font-size: 14px;
  }

  .wrapper .search_box .dropdown ul {
    position: absolute;
    top: 70px;
    left: -10px;
    background: #fff;
    width: 150px;
    border-radius: 5px;
    padding: 20px;
    display: none;
    box-shadow: 8px 8px 6px -10px #b3c6ff;
  }

  .wrapper .search_box .dropdown ul.active {
    display: block;
  }

  .wrapper .search_box .dropdown ul li {
    padding-bottom: 20px;
  }

  .wrapper .search_box .dropdown ul li:last-child {
    padding-bottom: 0;
  }

  .wrapper .search_box .dropdown ul li:hover {
    color: #6f768d;
  }

  .wrapper .search_box .dropdown:before {
    content: "";
    position: absolute;
    top: 18px;
    right: 20px;
    border: 8px solid;
    border-color: #5078ef transparent transparent transparent;
  }

  ::-webkit-input-placeholder {
    /* Chrome/Opera/Safari */
    color: #9fa3b1;
  }

  ::-moz-placeholder {
    /* Firefox 19+ */
    color: #9fa3b1;
  }

  :-ms-input-placeholder {
    /* IE 10+ */
    color: #9fa3b1;
  }
</style>

<body>
  <header>
    <div class="toggleBtn">
      <img class="menu" src="../images/svg/burger-menu-left.svg" width="40px" height="40px" />
    </div>
    <div class="logo-wrapper">
      <img src="../images/png/logo.png" class="logo" />
      <!-- <div class="title">Urban Services</div> -->
    </div>
    <ul class="nav-items">
      <li><a href="./index.php">Home</a></li>
      <li><a href="#">About</a></li>
      <!-- <li><a href="#">Register a service</a></li> -->
    </ul>
    <div class="nav-buttons">
      <?php if (isset($_SESSION['customerID'])) { ?>

        <a style="
            margin: 8px 12px;
            text-align: center;
            display: block;
            font-weight: 600;
            font-size: 1.25rem;
            color: #d80032;
          "><?php echo $_SESSION['customerName']; ?></a>
        <div class="profileImg" style="margin: 0 14px 0 0">
          <img src="<?php echo (isset($profileIMGData)) ? "data:image/jpg;base64,$profileIMGData" : "../images/png/user.png"; ?>" alt="profile image">
        </div>
        <!-- <a style="margin:8px 6px;font-weight:500;font-size:1.2rem;color:gold;">Profile</a> -->

        <!-- <a style="margin:8px 6px;font-weight:500;font-size:1.2rem;color:gold;">Settings</a> -->
        <a href="../logout.php" class="loginBtn">Log Out</a>
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
      <!-- <select name="searchCity" id="searchCity">
                    <option value="none">-- Select City --</option>
                    <option value="Bangalore">Bangalore</option>
                    <option value="Mumbai">Mumbai</option>
                    <option value="Chennai">Chennai</option>
                    <option value="Hyderabad">Hyderabad</option>
                    <option value="Delhi">Delhi</option>
                    <option value="Kolkata">Kolkata</option>
                </select> -->

      <div class="wrapper">
        <div class="search_box searchCityBox">
          <div class="dropdown" id="searchCityDropdown">
            <div class="default_option">Select City</div>
            <ul>
              <!-- <li value="none">-- Select City --</li> -->
              <li value="Bangalore">Bangalore</li>
              <li value="Mumbai">Mumbai</li>
              <li value="Chennai">Chennai</li>
              <li value="Hyderabad">Hyderabad</li>
              <li value="Delhi">Delhi</li>
              <li value="Kolkata">Kolkata</li>
            </ul>
          </div>
        </div>

        <div class="search_box searchServiceBox">
          <div class="dropdown" id="serviceTypeDropdown">
            <div class="default_option">Select Service</div>
            <ul>
              <!-- <li value="none">-- Select Service --</li> -->
              <li value="Plumbing">Plumbing</li>
              <li value="Electricals">Electricals</li>
              <li value="Carpentry">Carpentry</li>
              <li value="Cleaning">Cleaning</li>
              <li value="Pest Control">Pest Control</li>
            </ul>
          </div>
        </div>

        <div class="search-button">
          <div id="searchBtn">
            <img src="../images/png/search.png" class="search-icon" />
          </div>
        </div>
      </div>
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
    <div id="spinner">
      <img src="../images/svg/gear-spinner.svg" alt="spinner" />
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
    });

    //search services
    $(function() {
      $(".profile-dropdown").hide();
      $("#searchBtn").click(function() {
        $("#search-results").html(' ');
        $("#spinner").css("display", "flex");
        var searchCity = $("#searchCityDropdown .default_option").text();
        var serviceType = $("#serviceTypeDropdown .default_option").text();

        console.log("Search City:", searchCity);
        console.log("Service Type:", serviceType);
        //var searchCity = $("#searchCity").val();
        //var serviceType = $("#serviceType").val();

        if (searchCity == "none" || serviceType == "none") {
          alert("Don't leave search fields empty!");
        } else {
          $.post(
            "search.php", {
              searchCity: searchCity,
              serviceType: serviceType,
            },
            function(res) {
              var providers = JSON.parse(res);
              var searchResult = "";

              if (providers.failed == true) {
                $("#spinner").css("display", "none");
                searchResult = `<p style="color:red">No Service Providers found...<p>`;
              } else {
                providers.forEach(function(provider, i) {
                  searchResult += `
                            <div class="search-result">
                    <div class="service-image">
                    <img class="service-img" src="${
                      provider.profileIMG !== ""
                        ? "data:image/jpg;base64," + `${provider.profileIMG}`
                        : "./images/png/user.png"
                    }" alt="provider image">
                    
                    </div>
                    <div class="service-info">
                        <h3 class="title">${provider.companyName}</h3>
                        <div class="description">
                            <p class="text">${provider.serviceTypeName}</p>
                            <p class="timings">Work hours: ${
                              provider.startTime
                            } to ${provider.endTime}</p>
                            <p class="city">${provider.cityName}</p>
                        </div> 
                       <!-- <button class="booknow"><a href='bookservice.php?provider=${
                         provider.serviceProviderID
                       }'>Book now</a></button>-->
                        <button class="booknow"><a href="#modal-${
                          provider.serviceProviderID
                        }" rel="modal:open">Book Now</a></button>
                    </div>
                    </div>
                    <div id="modal-${
                      provider.serviceProviderID
                    }" class="modal booking-box">
                        <form action="./bookservice.php" method="POST">
                        <h2>Booking form</h2>
                        <input type="text" name="serviceProviderID" id="sid" value="${
                          provider.serviceProviderID
                        }" hidden> <br>
                        <input type="number" name="serviceTypeID" id="typeid" value="${
                          provider.serviceTypeID
                        }" hidden> <br>
                        <label for="date">Date</label>
                        <input type="date" name='preferredDate' id="date" required> 
                        <label>Select time range: </label> 
                        <label for="timestart" id="timestart">Start: </label>
                        <input type="time" name='preferredTimeSlotStart' id="timestart" required> 
                        <label for="timeend">End: </label>
                        <input type="time" name='preferredTimeSlotEnd' id="timeend" required>
                        <label for="address" name="customerAddress">Home Address: </label>
                        <textarea name="customerAddress" id="address" maxlength="200" placeholder="In about 200 characters" required></textarea> 
                        <label for="requestInfo" >Describe the problem:</label>
                        <textarea name="customerRequestInfo" id="requestInfo" maxlength="200" placeholder="In about 200 characters" required></textarea> 
                         <input type="submit" name="submit" class="submitBtn" value="submit">
                        </form>
                        <!--<a href="#" rel="modal:close">Close</a>-->
                    </div>                    
                    
                    `;
                });
                $("#spinner").css("display", "none");
              }
              $("#search-results").html(searchResult);
            }
          );
        }
      });
    });

    // $("#searchCity").selectize({
    //     plugins:['remove_button'],
    // });
    // $("#serviceType").selectize({
    //     plugins:['remove_button'],
    // });
    $(document).on(
      "click",
      "#searchCityDropdown .default_option",
      function() {
        $("#searchCityDropdown ul").addClass("active");
      }
    );

    $(document).on("click", "#searchCityDropdown ul li", function() {
      var text = $(this).text();
      $("#searchCityDropdown .default_option").text(text);
      $("#searchCityDropdown ul").removeClass("active");
    });

    $(document).on(
      "click",
      "#serviceTypeDropdown .default_option",
      function() {
        $("#serviceTypeDropdown ul").addClass("active");
      }
    );

    $(document).on("click", "#serviceTypeDropdown ul li", function() {
      var text = $(this).text();
      $("#serviceTypeDropdown .default_option").text(text);
      $("#serviceTypeDropdown ul").removeClass("active");
    });
  </script>
</body>

</html>