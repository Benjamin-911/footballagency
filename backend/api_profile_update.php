<?php
require_once __DIR__ . '/session.php';

// Update basic profile fields for the current user (name, phone).

require_login_api();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!is_array($data)) {
    jsonResponse(['error' => 'Invalid JSON body'], 400);
}

$name = isset($data['name']) ? trim($data['name']) : null;
$phone = isset($data['phone']) ? trim($data['phone']) : null;

if ($name === null && $phone === null) {
    jsonResponse(['error' => 'Nothing to update'], 422);
}

if ($name !== null && $name === '') {
    jsonResponse(['error' => 'Name cannot be empty'], 422);
}

if ($phone !== null && $phone !== '' && !preg_match('/^[\+]?[0-9\s\-()]{7,}$/', $phone)) {
    jsonResponse(['error' => 'Invalid phone number'], 422);
}

$userId = $_SESSION['user_id'];
$fields = [];
$params = [];
$types = '';

if ($name !== null) {
    $fields[] = 'name = ?';
    $params[] = $name;
    $types .= 's';
}

if ($phone !== null) {
    $fields[] = 'phone = ?';
    $params[] = $phone;
    $types .= 's';
}

if (empty($fields)) {
    jsonResponse(['error' => 'Nothing to update'], 422);
}

$params[] = $userId;
$types .= 'i';

$sql = 'UPDATE users SET ' . implode(', ', $fields) . ' WHERE id = ?';

$stmt = dbQuery($sql, $params, $types);
mysqli_stmt_close($stmt);

// Keep session in sync for name
if ($name !== null) {
    $_SESSION['user_name'] = $name;
}

// Return updated user object
$user = current_user();

jsonResponse([
    'success' => true,
    'user' => $user,
]);



