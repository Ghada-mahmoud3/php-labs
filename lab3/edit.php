<?php
session_start();

// Admin check
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Fetch user data
$userData = [];
$userFound = false;

if (isset($_GET['id'])) {
    $email = urldecode($_GET['id']);
    $lines = file('data.txt');
    
    foreach ($lines as $line) {
        $arr = explode("|", $line);
        if (trim($arr[1]) == $email) {  // Compare email to find the user
            $userData = $arr;
            $userFound = true;
            break;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the updated form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $room_no = htmlspecialchars(trim($_POST['room_no']));
    $Ext = htmlspecialchars(trim($_POST['Ext']));

    // Handle file upload (if any)
    $unique_image_name = $userData[5]; // Keep the old image name unless a new one is uploaded
    if ($_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $image_name = $_FILES['profile_picture']['name'];
        $image_tmp = $_FILES['profile_picture']['tmp_name'];
        $upload_dir = "uploads/";
        
        // Generate unique image name to prevent overwriting
        $unique_image_name = uniqid() . "_" . basename($image_name);
        move_uploaded_file($image_tmp, $upload_dir . $unique_image_name);
    }

    // Prepare the new user data
    $updatedData = implode("|", [$name, $email, $password, $room_no, $Ext, $unique_image_name]) . "\n";
    
    // Read the file and update the user's data
    $updatedLines = [];
    foreach ($lines as $line) {
        $arr = explode("|", $line);
        if (trim($arr[1]) == $email) {
            $updatedLines[] = $updatedData; // Update the user data
        } else {
            $updatedLines[] = $line; // Leave the rest unchanged
        }
    }
    
    // Save the updated data back to the file
    file_put_contents('data.txt', implode("", $updatedLines));
    
    // Redirect back to the home page to see updated list
    header('Location: home.php');
    exit();
}

if (!$userFound) {
    echo "User not found.";
    exit();
}
?>
<?php include_once('templates/head.php'); ?>
<body>
    
    <div class="main-w3layouts wrapper">
        <h1>Edit User</h1>
        <div class="main-agileinfo">
            <div class="agileits-top">
                <form action="edit.php?id=<?php echo urlencode($userData[1]); ?>" method="post" enctype="multipart/form-data">
                    <input class="text" type="text" name="name" value="<?php echo htmlspecialchars($userData[0]); ?>" placeholder="Full Name" required><br>
                    <input class="text email" type="email" name="email" value="<?php echo htmlspecialchars($userData[1]); ?>" placeholder="Email" required readonly><br>
                    <input class="text" type="password" name="password" value="<?php echo htmlspecialchars($userData[2]); ?>" placeholder="Password" required><br>
                    <input class="text" type="text" name="room_no" value="<?php echo htmlspecialchars($userData[3]); ?>" placeholder="Room Number" required><br>
                    <input class="text" type="text" name="Ext" value="<?php echo htmlspecialchars($userData[4]); ?>" placeholder="Ext" required><br>
                    
                    <div class="file-upload">
                        <label for="profile_picture">Upload Profile Picture:</label>
                        <label for="profile_picture" class="custom-file-upload">Choose File</label>
                        <span id="file-name"></span>
                        <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
                    </div>

                    <img src="uploads/<?php echo htmlspecialchars($userData[5]); ?>" alt="Profile Picture" width="100"><br><br>

                    <input type="submit" value="Save Changes">
                </form>
            </div>
        </div>
        <!-- copyright -->
        <div class="colorlibcopy-agile">
            <p>© 2025 All rights reserved to Dodo</p>
        </div>
    </div>
</body>
</html>
