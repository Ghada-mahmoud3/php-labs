<?php

$adminName = $_SESSION['username']; // Assuming the admin name is stored in the session
$adminPhoto = './uploads/67b3e6c56b40e_98 Freckled People Who’ll Hypnotize You With Their Unique Beauty.jpeg'; // Path to admin photo (update with actual photo path)
?>


<div class="header">
    <div class="header-container">
        <div class="logo">
            <h1>Cafeteria</h1>
        </div>

        <nav>
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a href="manual.php">Manual order</a></li>
                <li><a href="checks.php">Checks</a></li>
            </ul>
        </nav>

        <!-- Admin Profile Section -->
        <div class="admin-profile-container">
            <img src="<?php echo $adminPhoto; ?>" alt="Admin Photo" class="admin-photo">
            <p class="admin-name"><?php echo htmlspecialchars($adminName); ?></p>
            <a href="logout.php" class="logout-button">Logout</a>
        </div>
    </div>
</div>


