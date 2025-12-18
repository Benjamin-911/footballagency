<?php
require_once __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function get_avatar_url($userId) {
    $baseDir = dirname(__DIR__) . '/uploads/avatars/';
    $baseUrl = '/uploads/avatars/';

    $extensions = ['jpg', 'jpeg', 'png'];
    foreach ($extensions as $ext) {
        $filePath = $baseDir . $userId . '.' . $ext;
        if (file_exists($filePath)) {
            return $baseUrl . $userId . '.' . $ext;
        }
    }
    return null;
}

function current_user() {
    if (!empty($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];

        // Fetch phone from database so profile updates are reflected
        $conn = getDBConnection();
        $phone = null;
        $stmt = mysqli_prepare($conn, 'SELECT phone FROM users WHERE id = ? LIMIT 1');
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $phone);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
        }

        return [
            'id' => $id,
            'name' => $_SESSION['user_name'] ?? '',
            'email' => $_SESSION['user_email'] ?? '',
            'role' => $_SESSION['user_role'] ?? '',
            'phone' => $phone,
            'avatarUrl' => get_avatar_url($id),
        ];
    }
    return null;
}

function is_logged_in() {
    return !empty($_SESSION['user_id']);
}

function is_admin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin';
}

/**
 * Redirect-style guard for legacy PHP pages.
 */
function require_login() {
    if (!is_logged_in()) {
        header('Location: /football-agency/login.php');
        exit;
    }
}

function require_admin() {
    require_login();
    if (!is_admin()) {
        http_response_code(403);
        echo '<!DOCTYPE html><html><body><h2>Access denied</h2><p>You do not have permission to view this page.</p><p><a href="/football-agency/index.php">Return home</a></p></body></html>';
        exit;
    }
}

/**
 * JSON API-friendly guards for use by backend/api_*.php endpoints.
 */
function require_login_api() {
    if (!is_logged_in()) {
        jsonResponse(['error' => 'Not authenticated'], 401);
    }
}

function require_admin_api() {
    require_login_api();
    if (!is_admin()) {
        jsonResponse(['error' => 'Forbidden'], 403);
    }
}

