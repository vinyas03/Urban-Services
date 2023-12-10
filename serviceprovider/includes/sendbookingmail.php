<?php
require "../vendor/autoload.php";
include "./includes/mail-credentials.php";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


//for development, set this to true.
$developmentMode = true;
$mailer = new PHPMailer($developmentMode);
try {

    $mailer->SMTPDebug = 2;
    $mailer->isSMTP();
    if ($developmentMode) {
        $mailer->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];
    }
    $mailer->Host = $smtpServer; //smtp server (for example: smtp.gmail.com)
    $mailer->SMTPAuth = true;
    $mailer->Username = $senderEmail;
    $mailer->Password = $password;
    $mailer->SMTPSecure = 'tls';
    $mailer->Port = 587;
    $mailer->setFrom($senderEmail, 'Urban Services');
    $mailer->addAddress($customerEmail, $customerName);
    $mailer->isHTML(true);
    $mailer->Subject = 'Urban Services - Booking confirmation';
    $mailer->addStringAttachment(base64_decode($profileIMGData), 'profile.jpg', 'base64', 'image/jpeg');
    $mailer->Body = "
    <html>
    <body>
    <h2>Dear $customerName, </h2>

    <p>We are pleased to inform you that our service provider will be arriving at your house to provide the requested service. Below are the details of the assigned employee:</p>

    <ul>
        <li><strong>Employee Name:</strong> $employeeName</li>
        <li><strong>Employee Contact:</strong> $employeePhone </li>
        <li><strong>Service Type:</strong> $serviceType</li>
        <!-- Add more details as needed -->
    </ul>

    <p>Please ensure that someone is available at the specified location during the scheduled service time.
     If you have any specific instructions or questions, feel free to reply to this email, $companyEmail or contact us at,
     $companyPhone .</p>

    <p>Thank you for choosing our services. We look forward to serving you!</p>

    <p>Best regards,<br> $companyName</p>

    </html>
";
    $mailer->send();
    $mailer->ClearAllRecipients();
    echo "MAIL HAS BEEN SENT SUCCESSFULLY";
} catch (Exception $e) {
    echo "EMAIL SENDING FAILED. INFO: " . $mailer->ErrorInfo;
}
