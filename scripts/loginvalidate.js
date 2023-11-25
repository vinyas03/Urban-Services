function validateForm() {
    var username = document.forms["loginForm"]["username"].value;
    var password = document.forms["loginForm"]["password"].value;
    

    if (username == "" || password == "") {
        alert("All fields must be filled out");
        return false;
    }
    if (password.length <= 8) {
        alert("Password must be more than 8 characters");
        return false;
    }
    // Email format validation
    var emailPattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (!username.match(emailPattern)) {
        alert("Please enter a valid email address");
        return false;
    }
}
