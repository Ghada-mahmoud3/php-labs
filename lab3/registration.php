<?php
session_start(); 

// Admin check
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.php'); // Redirect to login if the user is not admin
    exit();
}

$errors = [];

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Validate passwords match
    if ($_POST['password'] !== $_POST['confirm_password']) {
        $errors[] = "Passwords do not match.";
    }

    // Sanitize and validate input fields
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);
    $room_no = htmlspecialchars(trim($_POST['room_no']));
    $Ext = htmlspecialchars(trim($_POST['Ext']));

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Handle file upload
    if ($_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $image_name = $_FILES['profile_picture']['name'];
        $image_tmp = $_FILES['profile_picture']['tmp_name'];
        $upload_dir = "uploads/";

        // Create a unique name for the file to prevent overwriting
        $unique_image_name = uniqid() . "_" . basename($image_name);
        
        // Check if the file is a valid image
        if (getimagesize($image_tmp)) {
            // Move the uploaded image to the "uploads" directory
            move_uploaded_file($image_tmp, $upload_dir . $unique_image_name);
        } else {
            $errors[] = "The uploaded file is not a valid image.";
        }
    } else {
        $errors[] = "No image file uploaded.";
    }

    // If there are no errors, save the user data to file
    if (empty($errors)) {
        $data = $name . "|" . $email . "|" . $password . "|" . $room_no . "|" . $Ext . "|" . $unique_image_name;
        file_put_contents("data.txt", $data . "\n", FILE_APPEND);
        $_SESSION['form_data'] = $data;
        
        // Redirect to the home page to show all users
        header('Location: home.php');
        exit();
    }
}
?>
<?php include_once('templates/head.php'); ?>
<body>
	<!-- main -->
	<div class="main-w3layouts wrapper">
		<h1> add customer </h1>
		<div class="main-agileinfo">
			<div class="agileits-top">
				
                <form action="" method="post" enctype="multipart/form-data">
					<input class="text" type="text" name="name" placeholder="Full Name" required="">
					<input class="text email" type="email" name="email" placeholder="Email" required="">
					<input class="text" type="password" name="password" placeholder="Password" required="">
					<input class="text w3lpass" type="password" name="confirm_password" placeholder="Confirm Password" required="">
                    <input class="text" type="text" name="room_no" placeholder="Room Number" required=""><br>
                    <input class="text" type="text" name="Ext" placeholder="Ext" required=""><br>
                    <!-- <label for="profile_picture">Upload Profile Picture:</label><br>
                    <input type="file" id="profile_picture" name="profile_picture" accept="image/*" required><br><br> -->

					<div class="file-upload">
    				<label for="profile_picture">Upload Profile Picture:</label>
    				<label for="profile_picture" class="custom-file-upload">Choose File</label>
    				<span id="file-name"></span>
    				<input type="file" id="profile_picture" name="profile_picture" accept="image/*" required>
					</div>
					<input type="submit" value="SIGNUP">
				</form>
			</div>
		</div>
		<!-- copyright -->
		<div class="colorlibcopy-agile">
			<p>© 2025 All rights reserved to Dodo</a></p>
		</div>
	
	</div>
	<!-- //main -->
</body>
</html>
