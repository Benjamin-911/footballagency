<?php
require_once __DIR__ . '/backend/session.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Email and password are required.';
    } else {
        $conn = getDBConnection();
        $stmt = mysqli_prepare($conn, "SELECT id, name, email, role, password FROM users WHERE email = ? AND status = 'active'");

        if ($stmt === false) {
            $error = 'Database error. Please try again later.';
        } else {
            mysqli_stmt_bind_param($stmt, 's', $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) === 1) {
                mysqli_stmt_bind_result($stmt, $id, $name, $dbEmail, $role, $hashedPassword);
                mysqli_stmt_fetch($stmt);

                if (password_verify($password, $hashedPassword)) {
                    // Successful login - set session and redirect
                    $_SESSION['user_id'] = $id;
                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_email'] = $dbEmail;
                    $_SESSION['user_role'] = $role;

                    // Redirect to home page (role-specific dashboards not implemented yet)
                    header('Location: index.php');
                    exit;
                } else {
                    $error = 'Invalid email or password.';
                }
            } else {
                $error = 'Invalid email or password.';
            }

            mysqli_stmt_close($stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Football Agency SL</title>
    <link rel="stylesheet" href="globals.css">
    <style>
        body { display:flex; align-items:center; justify-content:center; min-height:100vh; font-family:system-ui, -apple-system, sans-serif; background:#f3f4f6; }
        .login-container { background:white; padding:36px; border-radius:10px; box-shadow:0 10px 30px rgba(0,0,0,0.08); width:100%; max-width:420px; }
        .form-group { margin-bottom:14px; }
        label { display:block; margin-bottom:6px; font-weight:600; }
        input[type="email"], input[type="password"] { width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; }
        .btn { display:inline-block; background:#667eea; color:#fff; border:none; padding:12px 16px; border-radius:8px; cursor:pointer; width:100%; }
        .alert { padding:10px; border-radius:8px; margin-bottom:12px; }
        .alert.error { background:#fee2e2; color:#991b1b; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 style="text-align:center; margin-bottom:18px;">Football Agency SL — Login</h2>

        <?php if (!empty($error)): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>

        <p style="text-align:center; margin-top:14px;">Don't have an account? <a href="register.php">Register</a></p>
    </div>
</body>
</html>