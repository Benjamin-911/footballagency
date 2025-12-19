<?php
// Database Configuration
// Automatically detects Heroku environment variables or falls back to local defaults

$url = getenv('JAWSDB_URL') ?: getenv('CLEARDB_DATABASE_URL');

if ($url) {
    // Heroku Environment
    $dbparts = parse_url($url);
    $hostname = $dbparts['host'];
    $username = $dbparts['user'];
    $password = $dbparts['pass'];
    $database = ltrim($dbparts['path'], '/');
} else {
    // Local Environment (XAMPP Defaults)
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'football_agency_sl';
}

defined('DB_HOST') || define('DB_HOST', $hostname);
defined('DB_USER') || define('DB_USER', $username);
defined('DB_PASS') || define('DB_PASS', $password);
defined('DB_NAME') || define('DB_NAME', $database);