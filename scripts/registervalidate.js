function validateForm() {
    var email = document.forms["regForm"]["email"].value;
    var password1 = document.forms["regForm"]["password1"].value;
    var password2 = document.forms["regForm"]["password2"].value;
    var phone = document.forms["regForm"]["phone"].value;
    var gender = document.forms["regForm"]["gender"].value;
    var location = document.forms["regForm"]["location"].value;
    var securityQuestion = document.forms["regForm"]["securityQuestion"].value;
    var securityAnswer = document.forms["regForm"]["securityAnswer"].value;

    if (password.length <= 8) {
        alert("Password must be more than 8 characters");
        return false;
    }
        var emailPattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (!email.match(emailPattern)) {
        alert("Please enter a valid email address");
        return false;
    }
    if (phone.length != 10) {
        alert("Please enter a valid 10 digit Phone number");
        return false;
    }
    if (password1 != password2) {
        alert("Passwords don't match");
        return false;
    }
}
    

