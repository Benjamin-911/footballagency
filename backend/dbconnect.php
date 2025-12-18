<?php
/**
 * Database Connection for Football Agency
 */

$host = "localhost";
$user = "root";
$password = "";
$database = "football_agency_sl";

// Create connection
$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset
mysqli_set_charset($conn, "utf8mb4");

// You can also create a function to get the connection
function getConnection() {
    global $conn;
    return $conn;
}
?>