<?php
// logout.php
// ————————————————————————————————————————————

session_start();
require_once '../includes/functions.php';

// wipe all session data, cookie, and destroy session
clearSession();

// redirect to login with a flash message
redirectWith('login.php', 'You have been logged out.', 'info');
