<?php
// add_to_cart.php

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once '../includes/functions.php';
require_once '../config/database.php';

// Make sure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Only logged-in users can add to cart
if (!isLoggedIn()) {
    http_response_code(401); // Unauthorized
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

// Handle add to cart
if (isset($_GET['add'])) {
    $addId = (int)$_GET['add'];
    if (!isset($_SESSION['cart'][$addId])) {
        $_SESSION['cart'][$addId] = 1;
    }
    echo json_encode(['success' => true, 'message' => 'Item added to cart.']);
    exit;
}

// Invalid request
http_response_code(400); // Bad Request
echo json_encode(['success' => false, 'message' => 'Invalid request.']);


