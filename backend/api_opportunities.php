<?php
require_once __DIR__ . '/session.php';

// List open opportunities relevant to the current user.

require_login_api();

$user = current_user();
$role = $user['role'] ?? 'Player';
$userId = $user['id'];

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

$conn = getDBConnection();

// For Players: show ALL open opportunities (no role_target filter)
// For other roles: show opportunities matching their role or 'All'
if ($role === 'Player') {
    $sql = "SELECT 
        o.id,
        o.title,
        o.description,
        o.location,
        o.role_target,
        o.status,
        o.closes_at,
        COALESCE(a.status, NULL) AS application_status
    FROM opportunities o
    LEFT JOIN applications a 
      ON a.opportunity_id = o.id 
     AND a.user_id = ?
    WHERE o.status = 'open'
    ORDER BY o.created_at DESC
    LIMIT 50";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        jsonResponse(['error' => 'Database error'], 500);
    }
    mysqli_stmt_bind_param($stmt, 'i', $userId);
} else {
    $sql = "SELECT 
        o.id,
        o.title,
        o.description,
        o.location,
        o.role_target,
        o.status,
        o.closes_at,
        COALESCE(a.status, NULL) AS application_status
    FROM opportunities o
    LEFT JOIN applications a 
      ON a.opportunity_id = o.id 
     AND a.user_id = ?
    WHERE o.status = 'open'
      AND (o.role_target = 'All' OR o.role_target = ?)
    ORDER BY o.created_at DESC
    LIMIT 50";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        jsonResponse(['error' => 'Database error'], 500);
    }
    mysqli_stmt_bind_param($stmt, 'is', $userId, $role);
}
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

mysqli_stmt_bind_result(
    $stmt,
    $id,
    $title,
    $description,
    $location,
    $roleTarget,
    $status,
    $closesAt,
    $applicationStatus
);

$items = [];
while (mysqli_stmt_fetch($stmt)) {
    $items[] = [
        'id' => $id,
        'title' => $title,
        'description' => $description,
        'location' => $location,
        'role_target' => $roleTarget,
        'status' => $status,
        'closes_at' => $closesAt,
        'applied' => $applicationStatus !== null,
        'application_status' => $applicationStatus,
    ];
}

mysqli_stmt_close($stmt);

$openCount = count($items);

jsonResponse([
    'open_count' => $openCount,
    'items' => $items,
]);



