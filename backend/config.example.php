<?php
/**
 * Database Configuration for Football Agency Sierra Leone
 * 
 * COPY THIS FILE TO config.php AND UPDATE WITH YOUR DATABASE CREDENTIALS
 * DO NOT COMMIT config.php TO VERSION CONTROL
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'your_db_user');
define('DB_PASS', 'your_db_password');
define('DB_NAME', 'your_database_name');

// Helper function to get a database connection
function getDBConnection() {
    static $conn = null;
    if ($conn === null) {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8mb4");
    }
    return $conn;
}

// Helper function to return JSON response
function jsonResponse($data, $status = 200) {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data, JSON_PRETTY_PRINT);
    exit;
}

// Helper function for prepared statements
function dbQuery($sql, $params = [], $types = '') {
    $conn = getDBConnection();
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt === false) { 
        die("Prepare failed: " . mysqli_error($conn));
    }
    
    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    
    if (!mysqli_stmt_execute($stmt)) {
        die("Execute failed: " . mysqli_stmt_error($stmt));
    }
    
    return $stmt;
}
?>

