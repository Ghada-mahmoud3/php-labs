<?php
session_start();

// Admin check
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.php'); // Redirect to login if the user is not admin
    exit();
}
?>

<!DOCTYPE html>
<html>
<?php
include_once('templates/head.php');?>
<body>

    <!-- Header -->
    <header>
        <div class="header-container">
            <h1>cafeterea</h1>
            <nav>
                <ul class="nav-links">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="users.php">Users</a></li>
                    <li><a href="manual.php">Manual</a></li>
                    <li><a href="order.php">Order</a></li>
                    <li><a href="checks.php">Checks</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <div class="main-w3layouts wrapper">
        
        
        <div class="table-container">
            <!-- Table of users -->
            <table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Room No</th>
                    <th>Ext</th>
                    <th>Profile Picture</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>

                <?php
                $lines = file("data.txt");
                foreach ($lines as $line) {
                    if (trim($line) !== "") {
                        echo "<tr>";
                        $arr = explode("|", $line);
                        if (count($arr) == 6) {
                            foreach ($arr as $index => $data) {
                                // Display profile picture as an image
                                if ($index == 5) { // Profile picture is the 6th data (index 5)
                                    echo "<td><img src='uploads/" . htmlspecialchars(trim($data)) . "' alt='Profile Picture'></td>";
                                } else {
                                    echo "<td>" . htmlspecialchars(trim($data)) . "</td>";
                                }
                            }
                            // Add Edit and Delete columns
                            echo "<td><a href='edit.php?id=" . urlencode(trim($arr[1])) . "'>Edit</a></td>"; // Pass email as an identifier for editing
                            echo "<td><a href='delete.php?id=" . urlencode(trim($arr[1])) . "'>Delete</a></td>"; // XD same Pass email an identifier for deleting
                        } else {
                            echo "<td colspan='8'>Error in data format</td>";
                        }
                        echo "</tr>";
                    }
                }
                ?>
            </table>
        </div>

    </div>

</body>
</html>
