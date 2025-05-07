<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

try {
    // Check for admin users
    $stmt = $conn->query("SELECT id, username, email, role FROM users WHERE role = 'admin'");
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h2>Admin Users in Database</h2>";
    if (empty($admins)) {
        echo "<p>No admin users found in the database.</p>";
    } else {
        echo "<table class='table'>";
        echo "<thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th></tr></thead>";
        echo "<tbody>";
        foreach ($admins as $admin) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($admin['id']) . "</td>";
            echo "<td>" . htmlspecialchars($admin['username']) . "</td>";
            echo "<td>" . htmlspecialchars($admin['email']) . "</td>";
            echo "<td>" . htmlspecialchars($admin['role']) . "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    }
    
    // Check if users table exists
    $result = $conn->query("SHOW TABLES LIKE 'users'");
    if ($result->rowCount() == 0) {
        echo "<p class='text-danger'>Users table does not exist!</p>";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?> 