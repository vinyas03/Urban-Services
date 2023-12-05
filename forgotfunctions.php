<?php
// functions.php

// Function to sanitize input data
function sanitize($data) {
    return htmlspecialchars(strip_tags($data));
}

// Function to generate a random string for token
function generateRandomString($length = 32) {
    return bin2hex(random_bytes($length));
}
?>
