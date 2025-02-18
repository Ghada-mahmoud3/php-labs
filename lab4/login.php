<?php
session_start();

include_once('businesslogic.php');
include_once('validator.php');

if (empty($username) || empty($password)) {
    $error_message = "Username and password cannot be empty.";
}


if (isset($_SESSION['username'])) {
    header('Location: addUser.php');
    exit();
}

$error_message = "";

if (isset($_POST['Login'])) {
    
    $username = $_POST['UserName'];
    $password = $_POST['Password'];

    // Check if the username and password match in the database
    if (checkUserCredentials($username, $password)) {
        // Set username in session so it can be checked later and redirect to the add user page
        $_SESSION['username'] = $username;
        header('location: addUser.php'); 
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
}

// Function to check user credentials in the database
function checkUserCredentials($username, $password) {
    // Query the database to get the user details based on the provided username
    $user = getUserByUsername($username);  // Function defined in businesslogic.php

    // Check if the user exists and the password matches
    if ($user && password_verify($password, $user['password'])) {
        return true;  // Valid user and pass
    }
    return false;  
}

?>

<?php include_once('templates/head.php'); ?>
<body>
    <!-- main -->
    <div class="main-w3layouts wrapper">
        <h1> LOG IN </h1>
        <div class="main-agileinfo">
            <div class="agileits-top">
                <form action="" method="post" enctype="multipart/form-data">
                    <input class="text" type="text" name="UserName" placeholder="Username" required=""><br>
                    <input class="text" type="password" name="Password" placeholder="Password" required=""><br>
                    <input type="submit" value="LOG IN" name="Login">
                </form>

                <?php if (isset($error_message)) echo "<p>$error_message</p>"; ?>
            </div>
        </div>
    </div>
    <?php include_once('templates/footer.php'); ?>
</body>
</html>
