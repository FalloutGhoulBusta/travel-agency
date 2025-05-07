<?php
// api_get_packages.php

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once '../includes/functions.php';
require_once '../config/database.php';

// Fetch all packages with destination information
$stmt = $conn->query("
    SELECT p.*, d.name as destination_name, d.country
    FROM packages p
    JOIN destinations d ON p.destination_id = d.id
    ORDER BY p.created_at DESC
");
$packages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Format the packages data
$formattedPackages = [];
foreach ($packages as $package) {
    $formattedPackages[$package['destination_name']][] = [
        'id' => $package['id'],
        'title' => $package['name'],
        'description' => $package['description'],
        'price' => $package['price'],
        'destination' => $package['destination_name']
    ];
}

echo json_encode($formattedPackages);
?>


