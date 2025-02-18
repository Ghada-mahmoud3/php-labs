<?php
session_start();

// Ensure the user is logged in as admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.php'); // Redirect to login if not an admin
    exit();
}

include_once('businesslogic.php');

// Check if the customer ID is provided in the URL
if (isset($_GET['id'])) {
    $customerId = $_GET['id'];

    // Delete the customer by ID
    $result = deleteCustomer($customerId);  // deleteCustomer function in businesslogic.php

    if ($result) {
        header('Location: list.php');  // Redirect back to the customer list after deletion
        exit();
    } else {
        echo "Error: Unable to delete the customer. Please try again.";
    }
} else {
    echo "Error: No customer ID provided.";
}

// Function to delete the customer from the database by their ID
function deleteCustomer($id) {
    return deleteData('customers', ['id' => $id]);  // deleteData function in businesslogic.php
}

?>

<?php include_once('templates/head.php'); ?>
<body>
    <!-- Confirmation page to confirm deletion -->
    <div class="main-w3layouts wrapper">
        <h1>Are you sure you want to delete this customer?</h1>
        <div class="main-agileinfo">
            <div class="agileits-top">
                <?php
                // Fetch the customer data to display their details before confirming deletion
                $customer = getCustomerById($customerId);  // Assuming you have getCustomerById() in businesslogic.php
                if ($customer) {
                    echo "<p><strong>Name:</strong> " . htmlspecialchars($customer['name']) . "</p>";
                    echo "<p><strong>Email:</strong> " . htmlspecialchars($customer['email']) . "</p>";
                    echo "<p><strong>Room Number:</strong> " . htmlspecialchars($customer['room_no']) . "</p>";
                    echo "<p><strong>Ext:</strong> " . htmlspecialchars($customer['ext']) . "</p>";
                    echo "<p><strong>Profile Picture:</strong></p>";
                    echo "<img src='uploads/" . htmlspecialchars($customer['profile_picture']) . "' width='100' alt='Profile Picture'><br><br>";
                }
                ?>

                <!-- Confirmation form -->
                <form action="delete.php?id=<?php echo urlencode($customerId); ?>" method="POST">
                    <button type="submit" name="confirm_delete" value="Yes" style="padding: 10px; background-color: #f44336; color: white;">Yes, Delete</button>
                    <a href="list.php" style="padding: 10px; background-color: #76b852; color: white;">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
