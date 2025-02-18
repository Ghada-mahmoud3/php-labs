<?php
// Start session
session_start();

$values = ['admin', '12345678_Admin']; // the values it check against

if (isset($_POST['Login'])) {
    // Check username and password if it ok then redirect to registration page
    if ($_POST['UserName'] == $values[0] && $_POST['Password'] == $values[1]) {
        // Set username in session so i can check it later and redirect to registration page
        $_SESSION['username'] = $_POST['UserName'];
        // Redirect to the registration page
        header('location: registration.php'); 
        exit(); // call exit to stop the script execution (php session 1) it is important to prevent the rest of the code from running 
    } else {
        echo '<div><h1>Invalid username or password</h1></div>';
    }
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
        <!-- copyright -->
        <div class="colorlibcopy-agile">
            <p>© 2025 All rights reserved</a></p>
        </div>
    </div>
    <!-- //main -->
</body>
</html>
