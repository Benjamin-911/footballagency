<?php
require_once __DIR__ . '/session.php';

// Get or update the logged-in user's extended player profile.

require_login_api();

$user = current_user();
$role = $user['role'] ?? 'Player';
$userId = $user['id'];

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Currently we focus on Players; other roles can be extended later.
    if ($role !== 'Player') {
        jsonResponse([
            'role' => $role,
            'player' => null,
        ]);
    }

    $conn = getDBConnection();
    $stmt = mysqli_prepare(
        $conn,
        'SELECT id, user_id, date_of_birth, position, nationality, current_club, jersey_number, height_cm, weight_kg, preferred_foot, contract_expiry, market_value 
         FROM players WHERE user_id = ? LIMIT 1'
    );

    if (!$stmt) {
        jsonResponse(['error' => 'Database error'], 500);
    }

    mysqli_stmt_bind_param($stmt, 'i', $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) === 0) {
        mysqli_stmt_close($stmt);
        // Create a basic player record if missing
        $insert = mysqli_prepare(
            $conn,
            "INSERT INTO players (user_id, nationality) VALUES (?, 'Sierra Leonean')"
        );
        if ($insert) {
            mysqli_stmt_bind_param($insert, 'i', $userId);
            mysqli_stmt_execute($insert);
            mysqli_stmt_close($insert);
        }

        // Re-select
        $stmt = mysqli_prepare(
            $conn,
            'SELECT id, user_id, date_of_birth, position, nationality, current_club, jersey_number, height_cm, weight_kg, preferred_foot, contract_expiry, market_value 
             FROM players WHERE user_id = ? LIMIT 1'
        );
        if (!$stmt) {
            jsonResponse(['error' => 'Database error'], 500);
        }
        mysqli_stmt_bind_param($stmt, 'i', $userId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
    }

    mysqli_stmt_bind_result(
        $stmt,
        $id,
        $playerUserId,
        $dateOfBirth,
        $position,
        $nationality,
        $currentClub,
        $jerseyNumber,
        $heightCm,
        $weightKg,
        $preferredFoot,
        $contractExpiry,
        $marketValue
    );
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    $player = [
        'id' => $id,
        'user_id' => $playerUserId,
        'date_of_birth' => $dateOfBirth,
        'position' => $position,
        'nationality' => $nationality,
        'current_club' => $currentClub,
        'jersey_number' => $jerseyNumber,
        'height_cm' => $heightCm,
        'weight_kg' => $weightKg,
        'preferred_foot' => $preferredFoot,
        'contract_expiry' => $contractExpiry,
        'market_value' => $marketValue,
    ];

    jsonResponse([
        'role' => $role,
        'player' => $player,
    ]);
}

if ($method === 'POST') {
    if ($role !== 'Player') {
        jsonResponse(['error' => 'Only players can update this profile'], 403);
    }

    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);

    if (!is_array($data)) {
        jsonResponse(['error' => 'Invalid JSON body'], 400);
    }

    $fields = [];
    $params = [];
    $types = '';

    $position = isset($data['position']) ? trim($data['position']) : null;
    $nationality = isset($data['nationality']) ? trim($data['nationality']) : null;
    $currentClub = isset($data['current_club']) ? trim($data['current_club']) : null;
    $preferredFoot = isset($data['preferred_foot']) ? trim($data['preferred_foot']) : null;
    $heightCm = isset($data['height_cm']) ? $data['height_cm'] : null;
    $weightKg = isset($data['weight_kg']) ? $data['weight_kg'] : null;
    $dateOfBirth = isset($data['date_of_birth']) ? trim($data['date_of_birth']) : null;

    if ($position !== null) {
        $fields[] = 'position = ?';
        $params[] = $position === '' ? null : $position;
        $types .= 's';
    }

    if ($nationality !== null) {
        $fields[] = 'nationality = ?';
        $params[] = $nationality === '' ? null : $nationality;
        $types .= 's';
    }

    if ($currentClub !== null) {
        $fields[] = 'current_club = ?';
        $params[] = $currentClub === '' ? null : $currentClub;
        $types .= 's';
    }

    if ($preferredFoot !== null) {
        // Basic validation against enum values
        $allowedFeet = ['Left', 'Right', 'Both'];
        if ($preferredFoot !== '' && !in_array($preferredFoot, $allowedFeet, true)) {
            jsonResponse(['error' => 'Invalid preferred foot value'], 422);
        }
        $fields[] = 'preferred_foot = ?';
        $params[] = $preferredFoot === '' ? null : $preferredFoot;
        $types .= 's';
    }

    if ($heightCm !== null) {
        $heightVal = $heightCm === '' ? null : (int) $heightCm;
        $fields[] = 'height_cm = ?';
        $params[] = $heightVal;
        $types .= 'i';
    }

    if ($weightKg !== null) {
        $weightVal = $weightKg === '' ? null : (int) $weightKg;
        $fields[] = 'weight_kg = ?';
        $params[] = $weightVal;
        $types .= 'i';
    }

    if ($dateOfBirth !== null) {
        $fields[] = 'date_of_birth = ?';
        $params[] = $dateOfBirth === '' ? null : $dateOfBirth;
        $types .= 's';
    }

    if (empty($fields)) {
        jsonResponse(['error' => 'Nothing to update'], 422);
    }

    $params[] = $userId;
    $types .= 'i';

    $sql = 'UPDATE players SET ' . implode(', ', $fields) . ' WHERE user_id = ?';
    $stmt = dbQuery($sql, $params, $types);
    mysqli_stmt_close($stmt);

    // Return updated record
    $_GET['user_id'] = $userId;
    $_SERVER['REQUEST_METHOD'] = 'GET';
    // Easiest: just re-run the GET logic by including this file is not ideal.
    // Instead, duplicate the fetch logic here:

    $conn = getDBConnection();
    $select = mysqli_prepare(
        $conn,
        'SELECT id, user_id, date_of_birth, position, nationality, current_club, jersey_number, height_cm, weight_kg, preferred_foot, contract_expiry, market_value 
         FROM players WHERE user_id = ? LIMIT 1'
    );
    if (!$select) {
        jsonResponse(['error' => 'Database error'], 500);
    }

    mysqli_stmt_bind_param($select, 'i', $userId);
    mysqli_stmt_execute($select);
    mysqli_stmt_store_result($select);
    mysqli_stmt_bind_result(
        $select,
        $id,
        $playerUserId,
        $dateOfBirth,
        $position,
        $nationality,
        $currentClub,
        $jerseyNumber,
        $heightCm,
        $weightKg,
        $preferredFoot,
        $contractExpiry,
        $marketValue
    );
    mysqli_stmt_fetch($select);
    mysqli_stmt_close($select);

    $player = [
        'id' => $id,
        'user_id' => $playerUserId,
        'date_of_birth' => $dateOfBirth,
        'position' => $position,
        'nationality' => $nationality,
        'current_club' => $currentClub,
        'jersey_number' => $jerseyNumber,
        'height_cm' => $heightCm,
        'weight_kg' => $weightKg,
        'preferred_foot' => $preferredFoot,
        'contract_expiry' => $contractExpiry,
        'market_value' => $marketValue,
    ];

    jsonResponse([
        'success' => true,
        'role' => $role,
        'player' => $player,
    ]);
}

jsonResponse(['error' => 'Method not allowed'], 405);



