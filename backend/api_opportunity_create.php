<?php
require_once __DIR__ . '/session.php';

require_login_api();

$user = current_user();
$role = $user['role'] ?? '';
$userId = $user['id'];

// Only Agents and Club Managers can create opportunities
if ($role !== 'Agent' && $role !== 'Club Manager' && $role !== 'Admin') {
    jsonResponse(['error' => 'Only agents, club managers, and admins can create opportunities'], 403);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!is_array($data)) {
    jsonResponse(['error' => 'Invalid JSON body'], 400);
}

$title = trim($data['title'] ?? '');
$description = trim($data['description'] ?? '');
$location = trim($data['location'] ?? '');
$roleTarget = $data['role_target'] ?? 'Player';
$closesAt = $data['closes_at'] ?? null;

if ($title === '') {
    jsonResponse(['error' => 'Title is required'], 422);
}

$allowedRoles = ['Player', 'Agent', 'Club Manager', 'All'];
if (!in_array($roleTarget, $allowedRoles, true)) {
    $roleTarget = 'Player';
}

$conn = getDBConnection();

$sql = "INSERT INTO opportunities (title, description, location, role_target, closes_at, created_by, status) 
        VALUES (?, ?, ?, ?, ?, ?, 'open')";

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    jsonResponse(['error' => 'Database error'], 500);
}

$closesAtParam = $closesAt && $closesAt !== '' ? $closesAt : null;
mysqli_stmt_bind_param($stmt, 'sssssi', $title, $description, $location, $roleTarget, $closesAtParam, $userId);

if (!mysqli_stmt_execute($stmt)) {
    $msg = mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);
    jsonResponse(['error' => 'Failed to create opportunity: ' . $msg], 500);
}

$opportunityId = mysqli_insert_id($conn);
mysqli_stmt_close($stmt);

jsonResponse([
    'success' => true,
    'opportunity_id' => $opportunityId
]);

