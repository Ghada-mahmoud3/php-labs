<?php
// Database connection details
$host = 'localhost'; // Your database host
$username = 'admin'; // Your database username
$password = 'admin1234'; // Your database password
$database = 'cafeteria'; // Your database name

// PDO Connection
function getDB() {
    global $host, $username, $password, $database;
    
    try {
        $dbConnection = new PDO('mysql:host=' . $host . ';dbname=' . $database, $username, $password);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
}
?>
