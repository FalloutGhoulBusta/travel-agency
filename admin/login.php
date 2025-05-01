<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

// Redirect if already logged in as admin
if (isAdmin()) {
    redirectWith('/dashboard.php', 'You are already logged in.');
    exit;
}

$error    = '';
$username = '';

// Handle form submission
if (isPost()) {
    // sanitize user input
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Please fill in both fields.';
    } else {
        // look up user record by username
        $stmt = $conn->prepare(
            'SELECT id, username, password, role
             FROM users
             WHERE username = ?
             LIMIT 1'
        );
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // verify password and role
        if (
            $user
            && verifyPassword($password, $user['password'])
            && $user['role'] === 'admin'
        ) {
            // regenerate session ID to prevent fixation
            regenerateSession();

            // set session vars
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_role'] = 'admin';

            redirectWith('/dashboard.php', 'Login successful!');
        } else {
            $error = 'Invalid credentials or not an admin.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <style>
    /* full-screen flex container to center content */
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
    }
    .login-container {
      display: flex;
      align-items: center;      /* vertical centering */
      justify-content: center;  /* horizontal centering */
      height: 100%;
      background: #f4f4f4;
    }
    .login-box {
      background: white;
      padding: 2rem;
      border-radius: 6px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
      width: 320px;
      text-align: center;
    }
    .login-box h2 {
      margin: 0 0 1rem;
    }
    .login-box input,
    .login-box button {
      width: 100%;
      padding: 0.5rem;
      margin-bottom: 1rem;
      box-sizing: border-box;
    }
    .login-box button {
      cursor: pointer;
    }
    .login-box .back-link {
      display: block;
      margin-top: 0.5rem;
      text-decoration: none;
      font-size: 0.9rem;
      color: #555;
    }
    .login-box .back-link:hover {
      text-decoration: underline;
    }
    .error {
      color: #b00;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-box">
      <h2>Admin Login</h2>

      <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" action="">
        <input
          type="text"
          name="username"
          placeholder="Username"
          value="<?= htmlspecialchars($username) ?>"
          required
        >
        <input
          type="password"
          name="password"
          placeholder="Password"
          required
        >
        <button type="submit">Login</button>
      </form>

      <!-- Go back to public site -->
      <a
        href="http://localhost:5173/travel-agency/"
        class="back-link"
      >
        ← Go back to website
      </a>
    </div>
  </div>
</body>
</html>


