<?php
require_once __DIR__ . '/session.php';

// Simple JSON login endpoint for React.

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!is_array($data)) {
    jsonResponse(['error' => 'Invalid JSON body'], 400);
}

$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';

if ($email === '' || $password === '') {
    jsonResponse(['error' => 'Email and password are required'], 422);
}

$conn = getDBConnection();
$stmt = mysqli_prepare(
    $conn,
    "SELECT id, name, email, role, password FROM users WHERE email = ? AND status = 'active'"
);

if ($stmt === false) {
    jsonResponse(['error' => 'Database error'], 500);
}

mysqli_stmt_bind_param($stmt, 's', $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) !== 1) {
    mysqli_stmt_close($stmt);
    jsonResponse(['error' => 'Invalid email or password'], 401);
}

mysqli_stmt_bind_result($stmt, $id, $name, $dbEmail, $role, $hashedPassword);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if (!password_verify($password, $hashedPassword)) {
    jsonResponse(['error' => 'Invalid email or password'], 401);
}

// Successful login - set session
$_SESSION['user_id'] = $id;
$_SESSION['user_name'] = $name;
$_SESSION['user_email'] = $dbEmail;
$_SESSION['user_role'] = $role;

// Reuse current_user() so the shape matches api_me (including avatarUrl)
$user = current_user();

jsonResponse([
    'user' => $user,
]);


