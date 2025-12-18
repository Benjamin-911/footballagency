<?php
require_once __DIR__ . '/backend/session.php';

// Only allow admin users to access this page
if (!is_admin()) {
    http_response_code(403);
    echo '<!DOCTYPE html><html><body><h2>Access denied</h2><p>Only admin users can register new users.</p><p><a href="index.php">Return home</a></p></body></html>';
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $role = $_POST['role'] ?? 'Player';

  if (empty($name) || empty($email) || empty($password)) {
    $error = 'Name, email and password are required.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = 'Invalid email address.';
  } else {
    $conn = getDBConnection();

    // Check for existing email
    $check = mysqli_prepare($conn, 'SELECT id FROM users WHERE email = ? LIMIT 1');
    mysqli_stmt_bind_param($check, 's', $email);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);

    if (mysqli_stmt_num_rows($check) > 0) {
      $error = 'An account with that email already exists.';
      mysqli_stmt_close($check);
    } else {
      mysqli_stmt_close($check);

      $hashed = password_hash($password, PASSWORD_DEFAULT);
      $insert = mysqli_prepare($conn, 'INSERT INTO users (name, email, role, password, created_at) VALUES (?, ?, ?, ?, NOW())');
      mysqli_stmt_bind_param($insert, 'ssss', $name, $email, $role, $hashed);

      if (mysqli_stmt_execute($insert)) {
        // Get the inserted user ID
        $user_id = mysqli_insert_id($conn);

        // Insert role-specific record if needed
        if ($role === 'Agent') {
          $agent_insert = mysqli_prepare($conn, 'INSERT INTO agents (user_id) VALUES (?)');
          mysqli_stmt_bind_param($agent_insert, 'i', $user_id);
          mysqli_stmt_execute($agent_insert);
          mysqli_stmt_close($agent_insert);
        } elseif ($role === 'Club Manager') {
          $manager_insert = mysqli_prepare($conn, 'INSERT INTO club_managers (user_id) VALUES (?)');
          mysqli_stmt_bind_param($manager_insert, 'i', $user_id);
          mysqli_stmt_execute($manager_insert);
          mysqli_stmt_close($manager_insert);
        } elseif ($role === 'Player') {
          $player_insert = mysqli_prepare($conn, 'INSERT INTO players (user_id) VALUES (?)');
          mysqli_stmt_bind_param($player_insert, 'i', $user_id);
          mysqli_stmt_execute($player_insert);
          mysqli_stmt_close($player_insert);
        } elseif ($role === 'Admin') {
          // No extra table for admin
        }

        $success = 'Registration successful.';
      } else {
        $error = 'Registration failed. Please try again later.';
      }

      mysqli_stmt_close($insert);
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register - Football Agency SL</title>
  <link rel="stylesheet" href="globals.css" />
  <style>
    body { font-family:system-ui, -apple-system, sans-serif; background:#f3f4f6; display:flex; align-items:center; justify-content:center; min-height:100vh; }
    .card { background:#fff; padding:28px; border-radius:10px; box-shadow:0 8px 24px rgba(0,0,0,0.06); width:100%; max-width:520px; }
    .form-group { margin-bottom:12px; }
    label { display:block; margin-bottom:6px; font-weight:600; }
    input[type="text"], input[type="email"], input[type="password"], select { width:100%; padding:10px; border:1px solid #e5e7eb; border-radius:8px; }
    .btn { background:#10b981; color:#fff; padding:10px 14px; border-radius:8px; border:none; width:100%; }
    .btn-secondary { background:#e5e7eb; color:#111; padding:10px 14px; border-radius:8px; border:none; width:100%; margin-top:8px; }
    .alert { padding:10px; border-radius:8px; margin-bottom:12px; }
    .alert.error { background:#fee2e2; color:#991b1b; }
    .alert.success { background:#ecfdf5; color:#065f46; }
  </style>
</head>
<body>
  <div class="card">
  <h2 style="margin-top:0;">Create an Account</h2>

  <?php if (!empty($error)): ?>
    <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <?php if (!empty($success)): ?>
    <div class="alert success"><?php echo htmlspecialchars($success); ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <div class="form-group">
      <label for="name">Full name</label>
      <input id="name" name="name" type="text" required value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input id="email" name="email" type="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input id="password" name="password" type="password" required>
    </div>

    <div class="form-group">
      <label for="role">Account type</label>
      <select id="role" name="role">
        <option value="Player">Player</option>
        <option value="Agent">Agent</option>
        <option value="Club Manager">Club Manager</option>
        <option value="Admin">Admin</option>
      </select>
    </div>

    <button class="btn" type="submit">Register</button>
  </form>

  <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Back to Home</button>

  <p style="margin-top:12px;">Already have an account? <a href="login.php">Login</a></p>
  </div>
</body>
</html>