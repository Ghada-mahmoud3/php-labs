<?php
session_start();

// Admin check
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Check if ID (email ) is passed
if (isset($_GET['id'])) {
    $email = urldecode($_GET['id']);
    $lines = file('data.txt');
    $updatedLines = [];

    // Loop through all the lines and remove the one that matches the email
    foreach ($lines as $line) {
        $arr = explode("|", $line);
        if (trim($arr[1]) != $email) { // Keep only the users who don't match the email
            $updatedLines[] = $line;
        }
    }

    // Save the updated data back to the file
    file_put_contents('data.txt', implode("", $updatedLines));

    // Redirect back to the home page after deleting
    header('Location: home.php');
    exit();
} else {
    echo "No user ID provided.";
    exit();
}
?>
