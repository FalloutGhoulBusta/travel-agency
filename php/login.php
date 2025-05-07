<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

if (isLoggedIn()) {
    redirectWith('../index.php', 'You are already logged in');
}

if (isPost()) {
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        redirectWith('login.php', 'Please fill in all fields', 'danger');
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && verifyPassword($password, $user['password'])) {
        if ($user['role'] === 'admin') {
            // Set admin session variables
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_role'] = $user['role'];
            redirectWith('../admin/dashboard.php', 'Welcome back, ' . $user['username'] . '!');
        } else {
            // Set regular user session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_role'] = $user['role'];
            redirectWith('../index.php', 'Welcome back, ' . $user['username'] . '!');
        }
    } else {
        redirectWith('login.php', 'Invalid username or password', 'danger');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Travel Agency</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Login</h2>
                        <?php echo displayMessage(); ?>
                        <form action="login.php" method="POST" id="loginForm">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username or Email</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <p>Don't have an account? <a href="register.php">Register here</a></p>
                            <p><a href="forgot-password.php">Forgot Password?</a></p>
                            <p>Are you an admin? <a href="../admin/login.php">Login here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    window.addEventListener('message', function(event) {
      // Check the origin to ensure it's from a trusted source
      if (event.data.type === 'redirectToLogin') {
        // Store the redirect URL in a session variable or local storage
        sessionStorage.setItem('redirectUrl', event.data.url);
      }
    });

    // After successful login, redirect to the stored URL
    document.addEventListener('DOMContentLoaded', function() {
      const loginForm = document.getElementById('loginForm'); // Replace 'loginForm' with the actual ID of your login form

      loginForm.addEventListener('submit', function() {
        // After successful login, retrieve the redirect URL
        const redirectUrl = sessionStorage.getItem('redirectUrl');

        if (redirectUrl) {
          window.location.href = redirectUrl;
          sessionStorage.removeItem('redirectUrl'); // Clean up
        }
      });
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
