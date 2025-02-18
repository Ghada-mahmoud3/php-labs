<?php
include_once('database.php');

// Insert customer into the database
 
function insertCustomer($name, $email, $password, $room_no, $ext, $profile_image) {
    $db = getDB();  // Get database connection
    $sql = "INSERT INTO customers (name, email, password, room_no, ext, profile_picture) 
            VALUES (:name, :email, :password, :room_no, :ext, :profile_image)";
    
    $stmt = $db->prepare($sql);
    
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':room_no', $room_no);
    $stmt->bindParam(':ext', $ext);
    $stmt->bindParam(':profile_image', $profile_image);
    
    return $stmt->execute();  // Returns true if insertion is successful
}



// Get all customers 

function getAllCustomers() {
    $db = getDB();  // Database connection
    $sql = "SELECT * FROM customers";  // Query to select all customers
    $stmt = $db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Fetch all results as an associative array
}


// Get a single customer by ID
function getCustomerById($id) {
    return selectData('customers', '*', ['id' => $id])[0];
}

// Update customer details
function updateCustomer($id, $username, $password, $email, $room_no, $ext, $profile_image) {
    $data = [
        'username' => $username,
        'password' => $password,
        'email' => $email,
        'room_no' => $room_no,
        'ext' => $ext,
        'profile_picture' => $profile_image
    ];
    $where = ['id' => $id];
    return updateData('customers', $data, $where);
}

// Delete customer
function deleteCustomer($id) {
    $where = ['id' => $id];
    return deleteData('customers', $where);
}

// Function to fetch user data by username from the database
function getUserByUsername($username) {
    // Use prepared statements for security
    $db = getDB();  // Assuming you have a getDB() function in config.php for database connection
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch the user data
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
}


?>
