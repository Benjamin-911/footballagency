<?php
require_once __DIR__ . '/session.php';

// Upload or replace the current user's profile picture.

require_login_api();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

if (empty($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
    jsonResponse(['error' => 'No image uploaded or upload error'], 400);
}

$file = $_FILES['avatar'];

// Basic validation
$maxSize = 2 * 1024 * 1024; // 2MB
if ($file['size'] > $maxSize) {
    jsonResponse(['error' => 'Image too large (max 2MB)'], 422);
}

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

$allowedMimes = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
];

if (!isset($allowedMimes[$mime])) {
    jsonResponse(['error' => 'Only JPG and PNG images are allowed'], 422);
}

$ext = $allowedMimes[$mime];

$userId = $_SESSION['user_id'];
$uploadDir = dirname(__DIR__) . '/uploads/avatars/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$targetPath = $uploadDir . $userId . '.' . $ext;

// Remove previous files with other extensions
foreach (['jpg', 'jpeg', 'png'] as $oldExt) {
    $old = $uploadDir . $userId . '.' . $oldExt;
    if (file_exists($old)) {
        @unlink($old);
    }
}

if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
    jsonResponse(['error' => 'Failed to save uploaded image'], 500);
}

$avatarUrl = get_avatar_url($userId);

jsonResponse([
    'success' => true,
    'avatarUrl' => $avatarUrl,
]);



