<?php
session_start();

// Check if the user is logged in, if not, redirect to login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include_once('businesslogic.php');

// Fetch all customers from the database
$customers = getAllCustomers();  // This function should be defined in businesslogic.php
?>

<!DOCTYPE html>
<html>
<?php include_once('templates/head.php'); ?>
<body>

    <!-- Main content -->
    <div class="main-w3layouts wrapper">
        <h1>Customer List</h1>
        
        <!-- Table to display customers -->
        <div class="table-container">
            <table border="1">
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

                <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($customer['name']); ?></td>
                        <td><?php echo htmlspecialchars($customer['email']); ?></td>
                        <td><?php echo htmlspecialchars($customer['password']); ?></td>
                        <td><?php echo htmlspecialchars($customer['room_no']); ?></td>
                        <td><?php echo htmlspecialchars($customer['ext']); ?></td>
                        <td><img src="uploads/<?php echo htmlspecialchars($customer['profile_picture']); ?>" width="50" height="50"></td>
                        <td><a href="edit.php?id=<?php echo urlencode($customer['id']); ?>">Edit</a></td>
                        <td><a href="delete.php?id=<?php echo urlencode($customer['id']); ?>">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

    </div>
    <?php include_once('templates/footer.php'); ?>
</body>
</html>
