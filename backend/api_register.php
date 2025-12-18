<?php
require_once __DIR__ . '/session.php';

// Registration endpoint used by React.
// - If called by an authenticated Admin, they can choose the role.
// - If called by a guest or non-admin, it always creates a Player account.

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!is_array($data)) {
    jsonResponse(['error' => 'Invalid JSON body'], 400);
}

$name = trim($data['name'] ?? '');
$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';
$requestedRole = $data['role'] ?? 'Player';

if ($name === '' || $email === '' || $password === '') {
    jsonResponse(['error' => 'Name, email and password are required'], 422);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(['error' => 'Invalid email address'], 422);
}

$allowedRoles = ['Player', 'Agent', 'Club Manager', 'Admin'];
$isAdmin = is_admin();

if ($isAdmin && in_array($requestedRole, $allowedRoles, true)) {
    $role = $requestedRole;
} else {
    // Guests or non-admins can only create Player accounts
    $role = 'Player';
}

$conn = getDBConnection();

// Check for existing email
$check = mysqli_prepare($conn, 'SELECT id FROM users WHERE email = ? LIMIT 1');
if ($check === false) {
    jsonResponse(['error' => 'Database error'], 500);
}

mysqli_stmt_bind_param($check, 's', $email);
mysqli_stmt_execute($check);
mysqli_stmt_store_result($check);

if (mysqli_stmt_num_rows($check) > 0) {
    mysqli_stmt_close($check);
    jsonResponse(['error' => 'An account with that email already exists'], 409);
}

mysqli_stmt_close($check);

$hashed = password_hash($password, PASSWORD_DEFAULT);

$insert = mysqli_prepare(
    $conn,
    'INSERT INTO users (name, email, role, password, status, created_at) VALUES (?, ?, ?, ?, "active", NOW())'
);

if ($insert === false) {
    jsonResponse(['error' => 'Database error'], 500);
}

mysqli_stmt_bind_param($insert, 'ssss', $name, $email, $role, $hashed);

if (!mysqli_stmt_execute($insert)) {
    $msg = mysqli_stmt_error($insert);
    mysqli_stmt_close($insert);
    jsonResponse(['error' => 'Registration failed: ' . $msg], 500);
}

$userId = mysqli_insert_id($conn);
mysqli_stmt_close($insert);

// Insert role specific record if applicable
if ($role === 'Agent') {
    $agentInsert = mysqli_prepare($conn, 'INSERT INTO agents (user_id) VALUES (?)');
    if ($agentInsert) {
        mysqli_stmt_bind_param($agentInsert, 'i', $userId);
        mysqli_stmt_execute($agentInsert);
        mysqli_stmt_close($agentInsert);
    }
} elseif ($role === 'Club Manager') {
    $managerInsert = mysqli_prepare($conn, 'INSERT INTO club_managers (user_id) VALUES (?)');
    if ($managerInsert) {
        mysqli_stmt_bind_param($managerInsert, 'i', $userId);
        mysqli_stmt_execute($managerInsert);
        mysqli_stmt_close($managerInsert);
    }
} elseif ($role === 'Player') {
    $playerInsert = mysqli_prepare($conn, 'INSERT INTO players (user_id) VALUES (?)');
    if ($playerInsert) {
        mysqli_stmt_bind_param($playerInsert, 'i', $userId);
        mysqli_stmt_execute($playerInsert);
        mysqli_stmt_close($playerInsert);
    }
}

jsonResponse([
    'success' => true,
    'user' => [
        'id' => $userId,
        'name' => $name,
        'email' => $email,
        'role' => $role
    ]
]);

