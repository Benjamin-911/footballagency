<?php
require_once __DIR__ . '/session.php';

require_admin_api();

$conn = getDBConnection();

// Get list of all users with basic info
$stmt = mysqli_prepare(
    $conn,
    'SELECT id, name, email, role, status, phone, created_at 
     FROM users 
     ORDER BY created_at DESC 
     LIMIT 100'
);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}
mysqli_stmt_close($stmt);

jsonResponse(['users' => $users]);

