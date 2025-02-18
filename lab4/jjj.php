<?php
session_start();

// Ensure the admin is logged in
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$adminName = $_SESSION['username']; // Assuming the admin name is stored in the session
$adminPhoto = './uploads/67b3e6c56b40e_98 Freckled People Who’ll Hypnotize You With Their Unique Beauty.jpeg'; // Path to admin photo (update with actual photo path)
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once('templates/head.php'); ?>

<body>
    <style>
        /* Admin Profile Section Styles */
.admin-profile-container {
    text-align: center;
    margin: 20px;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    background-color: #f4f4f4;
}

.admin-photo {
    width: 120px; /* Set the size of the photo */
    height: 120px; /* Set the size of the photo */
    border-radius: 50%; /* Make the photo circular */
    object-fit: cover;
    margin-bottom: 10px;
}

.admin-name {
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

.logout-button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #f44336; /* Red color */
    color: white;
    font-weight: bold;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.logout-button:hover {
    background-color: #d32f2f; /* Darker red when hovering */
}

    </style>
    <!-- Admin Profile Section -->
    <div class="admin-profile-container">
        <img src="<?php echo $adminPhoto; ?>" alt="Admin Photo" class="admin-photo">
        <p class="admin-name"><?php echo htmlspecialchars($adminName); ?></p>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-w3layouts wrapper">
        <h1>Welcome, Admin</h1>
        <div class="main-agileinfo">
            <p>Admin Dashboard or Other Content</p>
        </div>
    </div>

    <!-- copyright -->
    <div class="colorlibcopy-agile">
        <p>© 2025 All rights reserved to Dodo</p>
    </div>
</body>
</html>
