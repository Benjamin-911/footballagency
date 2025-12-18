<?php
require_once __DIR__ . '/session.php';

// Return the currently authenticated user (if any).

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

if (!is_logged_in()) {
    jsonResponse(['user' => null]);
}

$user = current_user();

jsonResponse(['user' => $user]);


