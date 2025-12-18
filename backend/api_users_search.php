<?php
require_once __DIR__ . '/session.php';

require_login_api();

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

$query = trim($_GET['q'] ?? '');

$conn = getDBConnection();

if ($query === '') {
    // Return empty if no query
    jsonResponse(['users' => []]);
}

// Search users by name or email (excluding self)
$currentUserId = $_SESSION['user_id'];
$searchTerm = '%' . $query . '%';

$stmt = mysqli_prepare(
    $conn,
    'SELECT id, name, email, role FROM users 
     WHERE (name LIKE ? OR email LIKE ?) 
     AND id != ? 
     AND status = "active"
     ORDER BY name 
     LIMIT 20'
);

mysqli_stmt_bind_param($stmt, 'ssi', $searchTerm, $searchTerm, $currentUserId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

mysqli_stmt_close($stmt);

jsonResponse(['users' => $users]);

