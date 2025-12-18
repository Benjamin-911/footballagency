<?php
/**
 * Create Tables for Football Agency
 * Run this once to create all tables in phpMyAdmin
 */

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "football_agency_sl";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "<h1>Creating Tables for Football Agency</h1>";

// 1. Create users table
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    role ENUM('Admin', 'Player', 'Agent', 'Club Manager') NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if (mysqli_query($conn, $sql_users)) {
    echo "<p style='color: green;'>✅ Users table created successfully</p>";
} else {
    echo "<p style='color: red;'>❌ Error creating users table: " . mysqli_error($conn) . "</p>";
}

// 2. Create players table
$sql_players = "CREATE TABLE IF NOT EXISTS players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    date_of_birth DATE,
    position VARCHAR(50),
    nationality VARCHAR(50) DEFAULT 'Sierra Leonean',
    current_club VARCHAR(100),
    jersey_number INT,
    height_cm INT,
    weight_kg INT,
    preferred_foot ENUM('Left', 'Right', 'Both'),
    contract_expiry DATE,
    market_value DECIMAL(12, 2),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if (mysqli_query($conn, $sql_players)) {
    echo "<p style='color: green;'>✅ Players table created successfully</p>";
} else {
    echo "<p style='color: red;'>❌ Error creating players table: " . mysqli_error($conn) . "</p>";
}

// 3. Create agents table
$sql_agents = "CREATE TABLE IF NOT EXISTS agents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    license_number VARCHAR(50),
    fifa_certified BOOLEAN DEFAULT FALSE,
    years_experience INT DEFAULT 0,
    client_count INT DEFAULT 0,
    company_name VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if (mysqli_query($conn, $sql_agents)) {
    echo "<p style='color: green;'>✅ Agents table created successfully</p>";
} else {
    echo "<p style='color: red;'>❌ Error creating agents table: " . mysqli_error($conn) . "</p>";
}

// 4. Create club_managers table
$sql_club_managers = "CREATE TABLE IF NOT EXISTS club_managers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    club_name VARCHAR(100) NOT NULL,
    club_location VARCHAR(100),
    club_country VARCHAR(50),
    budget DECIMAL(15, 2),
    club_type ENUM('Professional', 'Semi-Professional', 'Academy'),
    established_year YEAR,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if (mysqli_query($conn, $sql_club_managers)) {
    echo "<p style='color: green;'>✅ Club Managers table created successfully</p>";
} else {
    echo "<p style='color: red;'>❌ Error creating club_managers table: " . mysqli_error($conn) . "</p>";
}

// 5. Create opportunities table
$sql_opportunities = "CREATE TABLE IF NOT EXISTS opportunities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    location VARCHAR(100),
    role_target ENUM('Player', 'Agent', 'Club Manager', 'All') DEFAULT 'Player',
    status ENUM('open', 'closed') DEFAULT 'open',
    closes_at DATE NULL,
    created_by INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if (mysqli_query($conn, $sql_opportunities)) {
    echo "<p style='color: green;'>✅ Opportunities table created successfully</p>";
} else {
    echo "<p style='color: red;'>❌ Error creating opportunities table: " . mysqli_error($conn) . "</p>";
}

// 6. Create applications table (player applications to opportunities)
$sql_applications = "CREATE TABLE IF NOT EXISTS applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    opportunity_id INT NOT NULL,
    status ENUM('applied', 'shortlisted', 'rejected', 'accepted') DEFAULT 'applied',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_application (user_id, opportunity_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (opportunity_id) REFERENCES opportunities(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if (mysqli_query($conn, $sql_applications)) {
    echo "<p style='color: green;'>✅ Applications table created successfully</p>";
} else {
    echo "<p style='color: red;'>❌ Error creating applications table: " . mysqli_error($conn) . "</p>";
}

// 7. Create messages table
$sql_messages = "CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    subject VARCHAR(150),
    body TEXT NOT NULL,
    read_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if (mysqli_query($conn, $sql_messages)) {
    echo "<p style='color: green;'>✅ Messages table created successfully</p>";
} else {
    echo "<p style='color: red;'>❌ Error creating messages table: " . mysqli_error($conn) . "</p>";
}

// 8. Create agent_players table (relationship: agents represent players)
$sql_agent_players = "CREATE TABLE IF NOT EXISTS agent_players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    agent_id INT NOT NULL,
    player_id INT NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    signed_date DATE,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_agent_player (agent_id, player_id),
    FOREIGN KEY (agent_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (player_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if (mysqli_query($conn, $sql_agent_players)) {
    echo "<p style='color: green;'>✅ Agent Players table created successfully</p>";
} else {
    echo "<p style='color: red;'>❌ Error creating agent_players table: " . mysqli_error($conn) . "</p>";
}

// Insert some sample data
echo "<h2>Adding Sample Data</h2>";

// Check if users table is empty
$check = mysqli_query($conn, "SELECT COUNT(*) as count FROM users");
$row = mysqli_fetch_assoc($check);

if ($row['count'] == 0) {
    // Insert sample users
    $sample_users = [
        "('Admin User', 'admin@example.com', 'Admin', '" . password_hash('admin123', PASSWORD_DEFAULT) . "', '+232 76 111 111')",
        "('John Doe', 'player1@example.com', 'Player', '" . password_hash('player123', PASSWORD_DEFAULT) . "', '+232 76 222 222')",
        "('Jane Smith', 'player2@example.com', 'Player', '" . password_hash('player123', PASSWORD_DEFAULT) . "', '+232 76 333 333')",
        "('Agent One', 'agent1@example.com', 'Agent', '" . password_hash('agent123', PASSWORD_DEFAULT) . "', '+232 76 444 444')",
        "('Club Manager', 'manager1@example.com', 'Club Manager', '" . password_hash('manager123', PASSWORD_DEFAULT) . "', '+232 76 555 555')"
    ];
    
    $sql_insert_users = "INSERT INTO users (name, email, role, password, phone) VALUES " . implode(',', $sample_users);
    
    if (mysqli_query($conn, $sql_insert_users)) {
        echo "<p style='color: green;'>✅ Sample users added</p>";
        
        // Insert sample players
        $sql_insert_players = "INSERT INTO players (user_id, nationality, current_club, position) VALUES 
            (2, 'Sierra Leonean', 'FC Kallon', 'Striker'),
            (3, 'Sierra Leonean', 'Bo Rangers', 'Midfielder')";
        
        if (mysqli_query($conn, $sql_insert_players)) {
            echo "<p style='color: green;'>✅ Sample players added</p>";
        }
    }
} else {
    echo "<p>Users table already has data. Skipping sample data insertion.</p>";
}

// Show current data
echo "<h2>Current Database Status</h2>";

$tables = ['users', 'players', 'agents', 'club_managers', 'opportunities', 'applications', 'messages', 'agent_players'];
foreach ($tables as $table) {
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM $table");
    $row = mysqli_fetch_assoc($result);
    echo "<p><strong>$table:</strong> {$row['count']} records</p>";
}

// Show players with their user info
echo "<h3>Players in Database:</h3>";
$players_query = "SELECT u.id as user_id, u.name, u.email, p.id as player_id, p.current_club 
                 FROM users u 
                 LEFT JOIN players p ON u.id = p.user_id 
                 WHERE u.role = 'Player'";
$players_result = mysqli_query($conn, $players_query);

echo "<table border='1' cellpadding='8'>";
echo "<tr><th>User ID</th><th>Name</th><th>Email</th><th>Player ID</th><th>Club</th><th>Status</th></tr>";

while ($player = mysqli_fetch_assoc($players_result)) {
    $status = $player['player_id'] ? "✅ Has player record" : "❌ No player record";
    echo "<tr>";
    echo "<td>{$player['user_id']}</td>";
    echo "<td>{$player['name']}</td>";
    echo "<td>{$player['email']}</td>";
    echo "<td>{$player['player_id']}</td>";
    echo "<td>{$player['current_club']}</td>";
    echo "<td>$status</td>";
    echo "</tr>";
}
echo "</table>";

mysqli_close($conn);

echo "<h2>Setup Complete!</h2>";
echo "<p><a href='add_user.php'>Go to Add User Page</a></p>";
?>