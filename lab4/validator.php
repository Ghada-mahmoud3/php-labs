<?php
// Validate and trim input (remove leading and trailing spaces)
function validateTrim($data) {
    return trim($data);
}

// Validate email format
function validateEmail($email) {
    // Sanitize email to prevent XSS attacks
    return filter_var($email, FILTER_SANITIZE_EMAIL);
}

// Validate password (minimum length of 6 characters)
function validatePassword($password) {
    return strlen($password) >= 6 ? $password : null; // Optionally return null or error message if validation fails
}
?>