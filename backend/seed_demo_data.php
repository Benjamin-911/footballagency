<?php
require_once __DIR__ . '/config.php';

// Simple script to insert demo opportunities and messages so the dashboard cards
// have something to display. Run once in the browser:
// http://localhost/footballagency/backend/seed_demo_data.php

$conn = getDBConnection();

echo '<h1>Seeding demo data</h1>';

// Find an admin and a player to use as sample users
$adminId = null;
$playerId = null;

$res = mysqli_query($conn, "SELECT id FROM users WHERE role = 'Admin' LIMIT 1");
if ($res && mysqli_num_rows($res) === 1) {
    $row = mysqli_fetch_assoc($res);
    $adminId = (int) $row['id'];
}

$res = mysqli_query($conn, "SELECT id FROM users WHERE role = 'Player' LIMIT 1");
if ($res && mysqli_num_rows($res) === 1) {
    $row = mysqli_fetch_assoc($res);
    $playerId = (int) $row['id'];
}

if (!$adminId || !$playerId) {
    echo '<p style="color:red;">Could not find both an Admin and a Player user. Please ensure sample users exist.</p>';
} else {
    echo '<p>Using Admin ID ' . $adminId . ' and Player ID ' . $playerId . ' for demo data.</p>';
}

// Seed opportunities if none exist
$res = mysqli_query($conn, 'SELECT COUNT(*) AS cnt FROM opportunities');
$row = $res ? mysqli_fetch_assoc($res) : ['cnt' => 0];
if ((int) $row['cnt'] === 0) {
    $sql = "INSERT INTO opportunities (title, description, location, role_target, status, closes_at) VALUES
        ('Trial with Premier League Club', 'Open trial for talented forwards and wingers.', 'Freetown, Sierra Leone', 'Player', 'open', DATE_ADD(CURDATE(), INTERVAL 14 DAY)),
        ('Scouting Partnership Call', 'We are seeking agents to collaborate on youth scouting.', 'Online', 'Agent', 'open', DATE_ADD(CURDATE(), INTERVAL 21 DAY)),
        ('Academy Friendly Matches', 'Club managers invited to schedule friendly fixtures with our academy.', 'Bo, Sierra Leone', 'Club Manager', 'open', DATE_ADD(CURDATE(), INTERVAL 30 DAY)),
        ('Showcase Tournament', 'Tournament to showcase top talent to scouts and clubs.', 'Makeni, Sierra Leone', 'All', 'open', DATE_ADD(CURDATE(), INTERVAL 10 DAY))";

    if (mysqli_query($conn, $sql)) {
        echo '<p style="color:green;">✅ Demo opportunities inserted.</p>';
    } else {
        echo '<p style="color:red;">❌ Failed to insert demo opportunities: ' . mysqli_error($conn) . '</p>';
    }
} else {
    echo '<p>Opportunities table already has data, skipping seeding.</p>';
}

// Seed a sample message if none exist and we have admin/player
$res = mysqli_query($conn, 'SELECT COUNT(*) AS cnt FROM messages');
$row = $res ? mysqli_fetch_assoc($res) : ['cnt' => 0];

if ((int) $row['cnt'] === 0 && $adminId && $playerId) {
    $subject = 'Welcome to Football Agency Sierra Leone';
    $body = "Thank you for joining our platform.\n\nComplete your profile so we can better support your football journey.";
    $stmt = mysqli_prepare(
        $conn,
        'INSERT INTO messages (sender_id, receiver_id, subject, body) VALUES (?, ?, ?, ?)'
    );
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'iiss', $adminId, $playerId, $subject, $body);
        if (mysqli_stmt_execute($stmt)) {
            echo '<p style="color:green;">✅ Demo welcome message inserted.</p>';
        } else {
            echo '<p style="color:red;">❌ Failed to insert demo message: ' . mysqli_stmt_error($stmt) . '</p>';
        }
        mysqli_stmt_close($stmt);
    } else {
        echo '<p style="color:red;">❌ Failed to prepare message insert: ' . mysqli_error($conn) . '</p>';
    }
} else {
    echo '<p>Messages table already has data or users missing, skipping message seeding.</p>';
}

echo '<p>Done.</p>';



