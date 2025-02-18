<?php
session_start();

// Ensure the user is logged in as admin
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include_once('businesslogic.php');
include_once('validator.php');

// Get the customer ID from the URL
$customerId = $_GET['id'];

// Fetch the customer data from the database
$customer = getCustomerById($customerId);  // This function retrieves a customer's details by ID

// If customer not found, redirect to the list page
if (!$customer) {
    header('Location: list.php');
    exit();
}

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
        // If no new image uploaded, use the existing one
        $unique_image_name = $customer['profile_picture'];
    }

    // If there are no errors, update the customer data in the database
    if (empty($errors)) {
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Update customer details in the database
        $result = updateCustomer($customerId, $name, $email, $hashed_password, $room_no, $ext, $unique_image_name);

        if ($result) {
            header('Location: list.php');  // Redirect to the list page after success
            exit();
        } else {
            $errors[] = "There was an issue updating the customer. Please try again.";
        }
    }
}

// Function to fetch customer details by ID
function getCustomerById($id) {
    return selectData('customers', '*', ['id' => $id])[0];  // Assuming you have selectData function in businesslogic.php
}
?>

<?php include_once('templates/head.php'); ?>
<body>

    <!-- Main content -->
    <div class="main-w3layouts wrapper">
        <h1>Edit Customer</h1>
        
        <div class="main-agileinfo">
            <div class="agileits-top">
                <form action="" method="post" enctype="multipart/form-data">
                    <!-- Full Name -->
                    <input class="text" type="text" name="name" value="<?php echo htmlspecialchars($customer['name']); ?>" placeholder="Full Name" required><br>

                    <!-- Email -->
                    <input class="text email" type="email" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>" placeholder="Email" required><br>

                    <!-- Password -->
                    <input class="text" type="password" name="password" placeholder="Password" required><br>

                    <!-- Confirm Password -->
                    <input class="text w3lpass" type="password" name="confirm_password" placeholder="Confirm Password" required><br>

                    <!-- Room Number -->
                    <input class="text" type="text" name="room_no" value="<?php echo htmlspecialchars($customer['room_no']); ?>" placeholder="Room Number" required><br>

                    <!-- Ext -->
                    <input class="text" type="text" name="ext" value="<?php echo htmlspecialchars($customer['ext']); ?>" placeholder="Ext" required><br>

                    <!-- Profile Picture -->
                    <div class="file-upload">
                        <label for="profile_picture">Upload Profile Picture:</label>
                        <label for="profile_picture" class="custom-file-upload">Choose File</label>
                        <span id="file-name"></span>
                        <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
                    </div>
                    
                    <!-- Display the current profile picture -->
                    <img src="uploads/<?php echo htmlspecialchars($customer['profile_picture']); ?>" width="100" alt="Profile Picture"><br><br>

                    <!-- Submit Button -->
                    <input type="submit" value="Save Changes">

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
