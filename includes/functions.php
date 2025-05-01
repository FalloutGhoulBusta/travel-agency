<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function isAdmin() {
    return isLoggedIn() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function isPost() {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function redirectWith($location, $message = '', $type = 'success') {
    if (!empty($message)) {
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = $type;
    }
    
    // Ensure the location is absolute
    if (!preg_match('/^https?:\/\//', $location)) {
        $base_url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        $base_url .= $_SERVER['HTTP_HOST'];
        $base_url .= dirname($_SERVER['SCRIPT_NAME']);
        $location = $base_url . '/' . ltrim($location, '/');
    }
    
    header("Location: $location");
    exit();
}

function displayMessage() {
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        $type = $_SESSION['message_type'] ?? 'success';
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
        return "<div class='alert alert-{$type}'>{$message}</div>";
    }
    return '';
}

function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function formatPrice($price) {
    return '₹ ' . number_format($price, 2);
}

function clearSession() {
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-42000, '/');
    }
    session_destroy();
}

function regenerateSession() {
    // Store session data
    $old_session_data = $_SESSION;
    
    // Clear session
    session_destroy();
    
    // Start new session
    session_start();
    session_regenerate_id(true);
    
    // Restore session data
    $_SESSION = $old_session_data;
}

// Map package names to image filenames for cart display
if (!function_exists('getPackageImageFilename')) {
    function getPackageImageFilename($packageName) {
        $name = strtolower($packageName);
        $name = str_replace(' & ', '-', $name);
        $name = str_replace(['&', ' '], '-', $name);
        $imageMap = [
            'paris-romance-escape' => 'paris-romance.jpg',
            'paris-art-culture' => 'paris-art.jpg',
            'paris-gastronomy-tour' => 'paris-gastronomy.jpg',
            'tokyo-tech-tradition' => 'tokyo-tech.jpg',
            'tokyo-foodie-adventure' => 'tokyo-food.jpg',
            'tokyo-cherry-blossom-special' => 'tokyo-cherry.jpg',
            'nyc-classic-experience' => 'nyc-classic.jpg',
            'nyc-arts-theater' => 'nyc-arts.jpg',
            'nyc-shopping-style' => 'nyc-shopping.jpg',
            'rome-imperial-tour' => 'rome-imperial.jpg',
            'rome-food-wine' => 'rome-food.jpg',
            'vatican-art-tour' => 'rome-vatican.jpg',
            'bali-beach-paradise' => 'bali-beach.jpg',
            'bali-cultural-journey' => 'bali-culture.jpg',
            'bali-adventure-wellness' => 'bali-wellness.jpg',
            'dubai-luxury-shopping' => 'dubai-luxury.jpg',
            'dubai-desert-adventure' => 'dubai-desert.jpg',
            'dubai-modern-marvels' => 'dubai-modern.jpg',
            'sydney-harbour-experience' => 'sydney-harbour.jpg',
            'sydney-beach-wildlife' => 'sydney-wildlife.jpg',
            'sydney-blue-mountains' => 'sydney-mountains.jpg',
            'barcelona-art-architecture' => 'barcelona-art.jpg',
            'barcelona-food-wine' => 'barcelona-food.jpg',
            'barcelona-beach-culture' => 'barcelona-beach.jpg',
            'cape-town-complete' => 'capetown-complete.jpg',
            'maldives-luxury-escape' => 'maldives-luxury.jpg',
            'maldives-honeymoon-package' => 'maldives-honeymoon.jpg',
            'maldives-adventure-wellness' => 'maldives-adventure.jpg'
        ];
        return $imageMap[$name] ?? 'default.jpg';
    }
}