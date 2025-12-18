<?php
require_once __DIR__ . '/session.php';

require_admin_api();

$conn = getDBConnection();

// Get platform-wide statistics
$stats = [];

// Total users by role
$stmt = mysqli_prepare($conn, 'SELECT role, COUNT(*) as count FROM users WHERE status = "active" GROUP BY role');
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$stats['users_by_role'] = [];
while ($row = mysqli_fetch_assoc($result)) {
    $stats['users_by_role'][$row['role']] = (int)$row['count'];
}
mysqli_stmt_close($stmt);

// Total opportunities
$stmt = mysqli_prepare($conn, 'SELECT COUNT(*) as count FROM opportunities');
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$stats['total_opportunities'] = (int)$row['count'];
mysqli_stmt_close($stmt);

// Open opportunities
$stmt = mysqli_prepare($conn, 'SELECT COUNT(*) as count FROM opportunities WHERE status = "open"');
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$stats['open_opportunities'] = (int)$row['count'];
mysqli_stmt_close($stmt);

// Total applications
$stmt = mysqli_prepare($conn, 'SELECT COUNT(*) as count FROM applications');
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$stats['total_applications'] = (int)$row['count'];
mysqli_stmt_close($stmt);

// Total messages
$stmt = mysqli_prepare($conn, 'SELECT COUNT(*) as count FROM messages');
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$stats['total_messages'] = (int)$row['count'];
mysqli_stmt_close($stmt);

// Agent-Player relationships
$stmt = mysqli_prepare($conn, 'SELECT COUNT(*) as count FROM agent_players WHERE status = "active"');
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$stats['agent_player_relationships'] = (int)$row['count'];
mysqli_stmt_close($stmt);

jsonResponse($stats);

