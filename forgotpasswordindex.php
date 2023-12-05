<?php
// index.php
include('includes/db_connect.php');
include('includes/forgotfunctions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have a 'users' table with columns 'email' and 'security_question'
    $email = sanitize($_POST['email']);

    // Check if the email exists in the database
    $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($checkEmailQuery);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $securityQuestion = $user['security_question'];
        
        // Redirect to the reset password page with the email and security question
        header("Location: reset-password.php?email=$email&question=$securityQuestion");
        exit();
    } else {
        // Email not found
        echo "Email not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>
    <form method="post" action="">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
