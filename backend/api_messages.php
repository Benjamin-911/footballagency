<?php
require_once __DIR__ . '/session.php';

// Basic messages API: returns summary of inbox for the current user.

require_login_api();

$user = current_user();
$userId = $user['id'];

$conn = getDBConnection();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Unread count
    $countSql = 'SELECT COUNT(*) FROM messages WHERE receiver_id = ? AND read_at IS NULL';
    $countStmt = mysqli_prepare($conn, $countSql);
    if (!$countStmt) {
        jsonResponse(['error' => 'Database error'], 500);
    }
    mysqli_stmt_bind_param($countStmt, 'i', $userId);
    mysqli_stmt_execute($countStmt);
    mysqli_stmt_bind_result($countStmt, $unreadCount);
    mysqli_stmt_fetch($countStmt);
    mysqli_stmt_close($countStmt);

    // Latest messages
    $sql = "SELECT 
        m.id,
        m.sender_id,
        u.name AS sender_name,
        m.subject,
        m.body,
        m.read_at,
        m.created_at
    FROM messages m
    JOIN users u ON m.sender_id = u.id
    WHERE m.receiver_id = ?
    ORDER BY m.created_at DESC
    LIMIT 10";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        jsonResponse(['error' => 'Database error'], 500);
    }

    mysqli_stmt_bind_param($stmt, 'i', $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    mysqli_stmt_bind_result(
        $stmt,
        $id,
        $senderId,
        $senderName,
        $subject,
        $body,
        $readAt,
        $createdAt
    );

    $items = [];
    while (mysqli_stmt_fetch($stmt)) {
        $snippet = mb_substr($body, 0, 120);
        if (mb_strlen($body) > 120) {
            $snippet .= '…';
        }
        $items[] = [
            'id' => $id,
            'sender_id' => $senderId,
            'sender_name' => $senderName,
            'subject' => $subject,
            'snippet' => $snippet,
            'read' => $readAt !== null,
            'created_at' => $createdAt,
        ];
    }

    mysqli_stmt_close($stmt);

    jsonResponse([
        'unread_count' => (int) $unreadCount,
        'items' => $items,
    ]);
}

jsonResponse(['error' => 'Method not allowed'], 405);



