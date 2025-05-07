<?php
session_start();

// Set CORS headers
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);

// Return JSON response
echo json_encode([
    'isLoggedIn' => $isLoggedIn,
    'userId' => $isLoggedIn ? $_SESSION['user_id'] : null
]);

