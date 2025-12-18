<?php
require_once __DIR__ . '/session.php';

require_login_api();

if (!is_logged_in() || $_SESSION['user_role'] !== 'Agent') {
    jsonResponse(['error' => 'Only agents can access this endpoint'], 403);
}

$conn = getDBConnection();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userId = $_SESSION['user_id'];
    
    $stmt = mysqli_prepare($conn, 'SELECT * FROM agents WHERE user_id = ? LIMIT 1');
    if ($stmt === false) {
        jsonResponse(['error' => 'Database error'], 500);
    }
    
    mysqli_stmt_bind_param($stmt, 'i', $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $agent = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    
    if (!$agent) {
        // Auto-create agent record if missing
        $insert = mysqli_prepare($conn, 'INSERT INTO agents (user_id) VALUES (?)');
        mysqli_stmt_bind_param($insert, 'i', $userId);
        mysqli_stmt_execute($insert);
        $agentId = mysqli_insert_id($conn);
        mysqli_stmt_close($insert);
        
        $stmt = mysqli_prepare($conn, 'SELECT * FROM agents WHERE id = ? LIMIT 1');
        mysqli_stmt_bind_param($stmt, 'i', $agentId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $agent = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    }
    
    jsonResponse(['agent' => $agent]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    
    if (!is_array($data)) {
        jsonResponse(['error' => 'Invalid JSON'], 400);
    }
    
    $userId = $_SESSION['user_id'];
    
    // Check if agent record exists
    $check = mysqli_prepare($conn, 'SELECT id FROM agents WHERE user_id = ? LIMIT 1');
    mysqli_stmt_bind_param($check, 'i', $userId);
    mysqli_stmt_execute($check);
    $result = mysqli_stmt_get_result($check);
    $existing = mysqli_fetch_assoc($result);
    mysqli_stmt_close($check);
    
    $licenseNumber = trim($data['license_number'] ?? '');
    $fifaCertified = isset($data['fifa_certified']) ? (bool)$data['fifa_certified'] : false;
    $yearsExperience = isset($data['years_experience']) ? (int)$data['years_experience'] : 0;
    $companyName = trim($data['company_name'] ?? '');
    
    if ($existing) {
        $update = mysqli_prepare(
            $conn,
            'UPDATE agents SET license_number = ?, fifa_certified = ?, years_experience = ?, company_name = ? WHERE user_id = ?'
        );
        mysqli_stmt_bind_param($update, 'siisi', $licenseNumber, $fifaCertified, $yearsExperience, $companyName, $userId);
        mysqli_stmt_execute($update);
        mysqli_stmt_close($update);
    } else {
        $insert = mysqli_prepare(
            $conn,
            'INSERT INTO agents (user_id, license_number, fifa_certified, years_experience, company_name) VALUES (?, ?, ?, ?, ?)'
        );
        mysqli_stmt_bind_param($insert, 'isiis', $userId, $licenseNumber, $fifaCertified, $yearsExperience, $companyName);
        mysqli_stmt_execute($insert);
        mysqli_stmt_close($insert);
    }
    
    // Fetch updated record
    $stmt = mysqli_prepare($conn, 'SELECT * FROM agents WHERE user_id = ? LIMIT 1');
    mysqli_stmt_bind_param($stmt, 'i', $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $agent = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    
    jsonResponse(['agent' => $agent]);
}

jsonResponse(['error' => 'Method not allowed'], 405);

