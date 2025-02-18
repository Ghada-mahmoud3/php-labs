<?php
session_start();

// Ensure the user is logged in as an admin
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include_once('businesslogic.php');
include_once('validator.php');

// Initialize an empty array to hold errors
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate form input
    $name = validateTrim($_POST['name']);
    $email = validateEmail($_POST['email']);
    $password = validatePassword($_POST['password']);
    $confirm_password = $_POST['confirm_password'];
    $room_no = $_POST['room_no'];
    $ext = $_POST['ext'];
    $profile_picture = $_FILES['profile_picture'];

    // Validate passwords match
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Handle profile picture upload
    if ($profile_picture['error'] === UPLOAD_ERR_OK) {
        $image_name = $profile_picture['name'];
        $image_tmp = $profile_picture['tmp_name'];
        $upload_dir = "uploads/";

        // Create a unique name for the image to prevent overwriting
        $unique_image_name = uniqid() . "_" . basename($image_name);

        // Check if the file is a valid image
        if (getimagesize($image_tmp)) {
            // Move the uploaded image to the uploads folder
            move_uploaded_file($image_tmp, $upload_dir . $unique_image_name);
        } else {
            $errors[] = "The uploaded file is not a valid image.";
        }
    } else {
        $errors[] = "No image file uploaded.";
    }

    // If there are no errors, insert the new user into the database
    if (empty($errors)) {
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert customer into the database
        $result = insertCustomer($name, $email, $hashed_password, $room_no, $ext, $unique_image_name);

        if ($result) {
            header('Location: list.php');  // Redirect to the list page after success
            exit();
        } else {
            $errors[] = "There was an issue adding the customer. Please try again.";
        }
    }
}
?>

<?php include_once('templates/head.php'); ?>
<body>
    <!-- Main content -->
    <div class="main-w3layouts wrapper">
        <h1>ADD CUSTOMER</h1>
        <div class="main-agileinfo">
            <div class="agileits-top">
                <form action="" method="post" enctype="multipart/form-data">
                    <!-- Full Name -->
                    <input class="text" type="text" name="name" placeholder="Full Name" required=""><br>

                    <!-- Email -->
                    <input class="text email" type="email" name="email" placeholder="Email" required=""><br>

                    <!-- Password -->
                    <input class="text" type="password" name="password" placeholder="Password" required=""><br>

                    <!-- Confirm Password -->
                    <input class="text w3lpass" type="password" name="confirm_password" placeholder="Confirm Password" required=""><br>

                    <!-- Room Number (Dropdown) -->
                    <select name="room_no" required>
                        <option value="101">Room 101</option>
                        <option value="102">Room 102</option>
                        <option value="103">Room 103</option>
                        <option value="104">Room 104</option>
                        <option value="105">Room 105</option>
                    </select><br>

                    <!-- Ext -->
                    <input class="text" type="text" name="ext" placeholder="Ext" required=""><br>

                    <!-- Profile Picture -->
                    <div class="file-upload">
                        <label for="profile_picture">Upload Profile Picture:</label>
                        <label for="profile_picture" class="custom-file-upload">Choose File</label>
                        <span id="file-name"></span>
                        <input type="file" id="profile_picture" name="profile_picture" accept="image/*" required>
                    </div>

                    <!-- Submit Button -->
                    <input type="submit" value="ADD CUSTOMER">
                    
                    <!-- Display errors if there are any -->
                    <?php if (!empty($errors)): ?>
                        <div class="error-messages">
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li style="color:red;"><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
    <?php include_once('templates/footer.php'); ?>
</body>
</html>
