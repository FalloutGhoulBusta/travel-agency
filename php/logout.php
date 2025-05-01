<?php
require_once '../includes/functions.php';

// Destroy the session
session_destroy();

// Redirect to home page
redirectWith('../index.php', 'You have been logged out successfully');
?> 