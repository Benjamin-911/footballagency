<?php
// Add this at the top of your add_user.php
require_once 'dbconnect.php'; // Use the simple db.php connection
require_once 'session.php';
require_admin();

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Validation
    if (empty($name)) $errors[] = 'Name is required';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email required';
    if (!in_array($role, ['Admin', 'Player', 'Agent', 'Club Manager'])) $errors[] = 'Valid role required';
    if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters';
    
    if (empty($errors)) {
        // Check if email already exists
        $check_sql = "SELECT id FROM users WHERE email = ?";
        $check_stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "s", $email);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);
        
        if (mysqli_stmt_num_rows($check_stmt) > 0) {
            $errors[] = 'Email already exists';
            mysqli_stmt_close($check_stmt);
        } else {
            mysqli_stmt_close($check_stmt);
            
            // Start transaction
            mysqli_begin_transaction($conn);
            
            try {
                // 1. Insert into users table
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $user_sql = "INSERT INTO users (name, email, role, password, phone) VALUES (?, ?, ?, ?, ?)";
                $user_stmt = mysqli_prepare($conn, $user_sql);
                mysqli_stmt_bind_param($user_stmt, "sssss", $name, $email, $role, $hashed_password, $phone);
                
                if (!mysqli_stmt_execute($user_stmt)) {
                    throw new Exception("Failed to insert user: " . mysqli_stmt_error($user_stmt));
                }
                
                $user_id = mysqli_insert_id($conn);
                mysqli_stmt_close($user_stmt);
                
                // 2. Insert into role-specific table
                if ($role === 'Player') {
                    $player_sql = "INSERT INTO players (user_id, nationality) VALUES (?, 'Sierra Leonean')";
                    $player_stmt = mysqli_prepare($conn, $player_sql);
                    mysqli_stmt_bind_param($player_stmt, "i", $user_id);
                    
                    if (!mysqli_stmt_execute($player_stmt)) {
                        throw new Exception("Failed to insert player: " . mysqli_stmt_error($player_stmt));
                    }
                    
                    mysqli_stmt_close($player_stmt);
                    $success = "✅ User '$name' added as Player. User ID: $user_id";
                    
                } elseif ($role === 'Agent') {
                    $agent_sql = "INSERT INTO agents (user_id) VALUES (?)";
                    $agent_stmt = mysqli_prepare($conn, $agent_sql);
                    mysqli_stmt_bind_param($agent_stmt, "i", $user_id);
                    mysqli_stmt_execute($agent_stmt);
                    mysqli_stmt_close($agent_stmt);
                    $success = "✅ User '$name' added as Agent. User ID: $user_id";
                    
                } elseif ($role === 'Club Manager') {
                    $club_sql = "INSERT INTO club_managers (user_id, club_name) VALUES (?, 'New Club')";
                    $club_stmt = mysqli_prepare($conn, $club_sql);
                    mysqli_stmt_bind_param($club_stmt, "i", $user_id);
                    mysqli_stmt_execute($club_stmt);
                    mysqli_stmt_close($club_stmt);
                    $success = "✅ User '$name' added as Club Manager. User ID: $user_id";
                    
                } else {
                    $success = "✅ User '$name' added as Admin. User ID: $user_id";
                }
                
                // Commit transaction
                mysqli_commit($conn);
                
            } catch (Exception $e) {
                // Rollback on error
                mysqli_rollback($conn);
                $errors[] = $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
    <style>
        .success { color: green; background: #d4edda; padding: 10px; }
        .error { color: red; background: #f8d7da; padding: 10px; }
    </style>
</head>
<body>
    <h1>Add New User</h1>
    
    <?php if ($success): ?>
        <div class="success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST">
        <p><input type="text" name="name" placeholder="Full Name" required></p>
        <p><input type="email" name="email" placeholder="Email" required></p>
        <p>
            <select name="role" required>
                <option value="">Select Role</option>
                <option value="Admin">Admin</option>
                <option value="Player">Player</option>
                <option value="Agent">Agent</option>
                <option value="Club Manager">Club Manager</option>
            </select>
        </p>
        <p><input type="text" name="phone" placeholder="Phone"></p>
        <p><input type="password" name="password" placeholder="Password (min 6 chars)" required minlength="6"></p>
        <button type="submit">Add User</button>
    </form>
    
    <p><a href="create_tables.php">Setup Database</a></p>
</body>
</html>