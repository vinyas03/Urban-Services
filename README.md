# Urban Services

Urban Services is a web-based platform that facilitates seamless interactions between customers and service providers, offering a comprehensive solution for service discovery, booking, and management.

## Table of Contents

- [Introduction](#introduction)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Setup Guide](#setup-guide)
- [Contributing](#contributing)
- [License](#license)

## Introduction

Urban Services aims to simplify the process of finding and booking services by connecting customers with service providers. The platform provides a user-friendly interface, efficient workflows for service providers, and transparent communication channels.

## Features

- User-friendly registration and login processes.
- Seamless service discovery and booking for customers.
- Efficient workforce management for service providers.
- Real-time notifications for service updates.
- Robust feedback system for customers.
- Responsive and intuitive design.

## Technology stack

- HTML
- CSS
- PHP
- JavaScript
- jQuery
- MySQL

## Setup guide

1. Clone the repository into any folder inside xampp/htdocs

   ```bash
   git clone https://github.com/vinyas03/Urban-Services.git
   ```

2. In the project folder, install the PHPMailer library via Composer

   ```bash
   composer require phpmailer/phpmailer
   ```

3. Start the Apache HTTP Server and MySQL server via XAMPP

4. Open phpMyAdmin and create `urban services` database

5. Import the given .sql dump into the database

6. In the browser, go to `localhost/Urban` assuming you have cloned into `Urban` folder in htdocs

7. The project should run as expected in the local dev server

#### PHPMailer usage
Email features are used in the application to send confirmation emails to the customer by the service provider.

1. In the `serviceprovider/includes` folder, create a new file called `mail-credentials.php`

2. In that, enter your secret email credentials like email, password through which you are going to send emails to the customers

```bash
<?php
$smtpServer = ''; //SMTPserver (for example: smtp.gmail.com)
$senderEmail = ''; //Sender (your) email
$password = ''; //Sender password
$senderName ='Urban Services'; //Sender name
?>
```

3. This file is included by default in the `sendbookingmail.php` so you don't have to

4. You can always edit other email configurations like SMTP Port, reciever informations etc. in the `sendbookingmail.php`

5. For testing out the confirmation mails recieved, you can use free temporary email providers online and use them instead of customer email.
