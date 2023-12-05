<?php
// reset-password.php
include('includes/db_connect.php');
include('includes/forgotfunctions.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Get email and security question from the URL
    $email = sanitize($_GET['email']);
    $securityQuestion = sanitize($_GET['question']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have a 'users' table with columns 'email', 'security_question', and 'security_answer'
    $email = sanitize($_POST['email']);
    $securityAnswer = sanitize($_POST['security_answer']);
    $newPassword = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

    // Check if the provided security answer is correct
    $checkSecurityAnswerQuery = "SELECT * FROM users WHERE email = '$email' AND security_question = '$securityQuestion' AND security_answer = '$securityAnswer'";
    $result = $conn->query($checkSecurityAnswerQuery);

    if ($result->num_rows > 0) {
        // Update the user's password
        $updatePasswordQuery = "UPDATE users SET password = '$newPassword' WHERE email = '$email'";
        $conn->query($updatePasswordQuery);

        echo "Password reset successful!";        
    } else {
        // Incorrect security answer
        echo "Incorrect security answer.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form method="post" action="">
        <input type="hidden" name="email" value="<?php echo $email; ?>">
        <p>Security Question: <?php echo $securityQuestion; ?></p>
        <label for="security_answer">Security Answer:</label>
        <input type="text" id="security_answer" name="security_answer" required>
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
