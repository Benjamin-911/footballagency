<?php
require_once __DIR__ . '/session.php';

require_login_api();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!is_array($data)) {
    jsonResponse(['error' => 'Invalid JSON body'], 400);
}

$senderId = $_SESSION['user_id'];
$receiverId = isset($data['receiver_id']) ? (int)$data['receiver_id'] : 0;
$subject = trim($data['subject'] ?? '');
$body = trim($data['body'] ?? '');

if ($receiverId <= 0) {
    jsonResponse(['error' => 'Valid receiver_id is required'], 422);
}

if ($body === '') {
    jsonResponse(['error' => 'Message body is required'], 422);
}

if ($senderId === $receiverId) {
    jsonResponse(['error' => 'Cannot send message to yourself'], 422);
}

$conn = getDBConnection();

// Verify receiver exists
$check = mysqli_prepare($conn, 'SELECT id FROM users WHERE id = ? LIMIT 1');
mysqli_stmt_bind_param($check, 'i', $receiverId);
mysqli_stmt_execute($check);
mysqli_stmt_store_result($check);

if (mysqli_stmt_num_rows($check) === 0) {
    mysqli_stmt_close($check);
    jsonResponse(['error' => 'Receiver not found'], 404);
}
mysqli_stmt_close($check);

// Insert message
$insert = mysqli_prepare(
    $conn,
    'INSERT INTO messages (sender_id, receiver_id, subject, body) VALUES (?, ?, ?, ?)'
);
mysqli_stmt_bind_param($insert, 'iiss', $senderId, $receiverId, $subject, $body);

if (!mysqli_stmt_execute($insert)) {
    $msg = mysqli_stmt_error($insert);
    mysqli_stmt_close($insert);
    jsonResponse(['error' => 'Failed to send message: ' . $msg], 500);
}

$messageId = mysqli_insert_id($conn);
mysqli_stmt_close($insert);

jsonResponse([
    'success' => true,
    'message_id' => $messageId
]);

