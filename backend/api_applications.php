<?php
require_once __DIR__ . '/session.php';

// Handle player applications to opportunities.

require_login_api();

$user = current_user();
$role = $user['role'] ?? 'Player';
$userId = $user['id'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

if ($role !== 'Player') {
    jsonResponse(['error' => 'Only players can apply for opportunities'], 403);
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!is_array($data)) {
    jsonResponse(['error' => 'Invalid JSON body'], 400);
}

$opportunityId = isset($data['opportunity_id']) ? (int) $data['opportunity_id'] : 0;

if ($opportunityId <= 0) {
    jsonResponse(['error' => 'Invalid opportunity ID'], 422);
}

$conn = getDBConnection();

// Ensure opportunity exists and is open
$check = mysqli_prepare($conn, "SELECT id FROM opportunities WHERE id = ? AND status = 'open' LIMIT 1");
if (!$check) {
    jsonResponse(['error' => 'Database error'], 500);
}
mysqli_stmt_bind_param($check, 'i', $opportunityId);
mysqli_stmt_execute($check);
mysqli_stmt_store_result($check);

if (mysqli_stmt_num_rows($check) === 0) {
    mysqli_stmt_close($check);
    jsonResponse(['error' => 'Opportunity not found or closed'], 404);
}
mysqli_stmt_close($check);

// Insert or update application
$sql = "INSERT INTO applications (user_id, opportunity_id, status)
        VALUES (?, ?, 'applied')
        ON DUPLICATE KEY UPDATE status = 'applied'";

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    jsonResponse(['error' => 'Database error'], 500);
}

mysqli_stmt_bind_param($stmt, 'ii', $userId, $opportunityId);

if (!mysqli_stmt_execute($stmt)) {
    $msg = mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);
    jsonResponse(['error' => 'Failed to apply: ' . $msg], 500);
}

mysqli_stmt_close($stmt);

jsonResponse(['success' => true]);



