<?php
require_once __DIR__ . '/session.php';

require_login_api();

if (!is_logged_in() || $_SESSION['user_role'] !== 'Agent') {
    jsonResponse(['error' => 'Only agents can access this endpoint'], 403);
}

$conn = getDBConnection();
$agentId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get all players represented by this agent
    $stmt = mysqli_prepare(
        $conn,
        'SELECT 
            ap.id, ap.status, ap.signed_date, ap.notes,
            u.id as player_user_id, u.name as player_name, u.email as player_email,
            p.position, p.current_club, p.nationality
        FROM agent_players ap
        JOIN users u ON ap.player_id = u.id
        LEFT JOIN players p ON u.id = p.user_id
        WHERE ap.agent_id = ?
        ORDER BY ap.created_at DESC'
    );
    mysqli_stmt_bind_param($stmt, 'i', $agentId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $players = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $players[] = $row;
    }
    mysqli_stmt_close($stmt);
    
    jsonResponse(['players' => $players]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add a player to agent's roster
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    
    if (!is_array($data)) {
        jsonResponse(['error' => 'Invalid JSON'], 400);
    }
    
    $playerId = isset($data['player_id']) ? (int)$data['player_id'] : 0;
    
    if ($playerId <= 0) {
        jsonResponse(['error' => 'Valid player_id is required'], 422);
    }
    
    // Verify player exists and is actually a Player
    $check = mysqli_prepare($conn, 'SELECT id FROM users WHERE id = ? AND role = "Player" LIMIT 1');
    mysqli_stmt_bind_param($check, 'i', $playerId);
    mysqli_stmt_execute($check);
    $result = mysqli_stmt_get_result($check);
    if (mysqli_num_rows($result) === 0) {
        mysqli_stmt_close($check);
        jsonResponse(['error' => 'Player not found'], 404);
    }
    mysqli_stmt_close($check);
    
    // Check if relationship already exists
    $check = mysqli_prepare($conn, 'SELECT id FROM agent_players WHERE agent_id = ? AND player_id = ? LIMIT 1');
    mysqli_stmt_bind_param($check, 'ii', $agentId, $playerId);
    mysqli_stmt_execute($check);
    $result = mysqli_stmt_get_result($check);
    if (mysqli_num_rows($result) > 0) {
        mysqli_stmt_close($check);
        jsonResponse(['error' => 'Player is already in your roster'], 409);
    }
    mysqli_stmt_close($check);
    
    $signedDate = isset($data['signed_date']) ? $data['signed_date'] : date('Y-m-d');
    $notes = trim($data['notes'] ?? '');
    
    $insert = mysqli_prepare(
        $conn,
        'INSERT INTO agent_players (agent_id, player_id, signed_date, notes) VALUES (?, ?, ?, ?)'
    );
    mysqli_stmt_bind_param($insert, 'iiss', $agentId, $playerId, $signedDate, $notes);
    
    if (!mysqli_stmt_execute($insert)) {
        mysqli_stmt_close($insert);
        jsonResponse(['error' => 'Failed to add player'], 500);
    }
    
    mysqli_stmt_close($insert);
    
    // Return updated list
    $stmt = mysqli_prepare(
        $conn,
        'SELECT 
            ap.id, ap.status, ap.signed_date, ap.notes,
            u.id as player_user_id, u.name as player_name, u.email as player_email,
            p.position, p.current_club, p.nationality
        FROM agent_players ap
        JOIN users u ON ap.player_id = u.id
        LEFT JOIN players p ON u.id = p.user_id
        WHERE ap.agent_id = ?
        ORDER BY ap.created_at DESC'
    );
    mysqli_stmt_bind_param($stmt, 'i', $agentId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $players = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $players[] = $row;
    }
    mysqli_stmt_close($stmt);
    
    jsonResponse(['players' => $players]);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    
    $playerId = isset($data['player_id']) ? (int)$data['player_id'] : 0;
    
    if ($playerId <= 0) {
        jsonResponse(['error' => 'Valid player_id is required'], 422);
    }
    
    $delete = mysqli_prepare($conn, 'DELETE FROM agent_players WHERE agent_id = ? AND player_id = ?');
    mysqli_stmt_bind_param($delete, 'ii', $agentId, $playerId);
    mysqli_stmt_execute($delete);
    mysqli_stmt_close($delete);
    
    jsonResponse(['success' => true]);
}

jsonResponse(['error' => 'Method not allowed'], 405);

