<?php
// dashboard.php
// ————————————————————————————————————————————

require_once 'auth.php';          // starts session and checks isAdmin
require_once '../config/database.php';
require_once '../includes/functions.php';

// Fetch dashboard statistics
$stats = [
    'users' => $conn->query("SELECT COUNT(*) FROM users WHERE role='user'")->fetchColumn(),
    'total_bookings' => $conn->query("SELECT COUNT(*) FROM bookings")->fetchColumn(),
    'pending_bookings' => $conn->query("SELECT COUNT(*) FROM bookings WHERE status='pending'")->fetchColumn(),
    'total_revenue' => $conn->query("SELECT COALESCE(SUM(total_price), 0) FROM bookings WHERE status='confirmed'")->fetchColumn(),
    'destinations' => $conn->query("SELECT COUNT(*) FROM destinations")->fetchColumn(),
    'packages' => $conn->query("SELECT COUNT(*) FROM packages")->fetchColumn(),
    'reviews' => $conn->query("SELECT COUNT(*) FROM reviews")->fetchColumn(),
    'avg_rating' => $conn->query("SELECT COALESCE(AVG(rating), 0) FROM reviews")->fetchColumn(),
    'messages' => $conn->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn(),
    'subscribers' => $conn->query("SELECT COUNT(*) FROM newsletter_subscribers")->fetchColumn()
];

// Get recent bookings
$recent_bookings = $conn->query("
    SELECT b.*, u.username, p.name as package_name 
    FROM bookings b 
    JOIN users u ON b.user_id = u.id 
    JOIN packages p ON b.package_id = p.id 
    ORDER BY b.created_at DESC 
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

// Get popular destinations
$popular_destinations = $conn->query("
    SELECT d.name, COUNT(b.id) as booking_count 
    FROM destinations d 
    LEFT JOIN packages p ON p.destination_id = d.id 
    LEFT JOIN bookings b ON b.package_id = p.id 
    GROUP BY d.id 
    ORDER BY booking_count DESC 
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .stat-card {
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .icon-lg {
            font-size: 2rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="bi bi-speedometer2"></i> Admin Dashboard</a>
            <div class="navbar-nav ms-auto">
                <a href="../index.php" class="nav-link"><i class="bi bi-house"></i> View Site</a>
                <a href="logout.php" class="nav-link"><i class="bi bi-box-arrow-right"></i> Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <?= displayMessage() ?>

        <!-- Quick Stats Row -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card stat-card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6>Total Revenue</h6>
                                <h3><?= formatPrice($stats['total_revenue']); ?></h3>
                            </div>
                            <i class="bi bi-currency-rupee icon-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card stat-card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6>Total Bookings</h6>
                                <h3><?= $stats['total_bookings'] ?></h3>
                            </div>
                            <i class="bi bi-calendar-check icon-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card stat-card bg-warning text-dark">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6>Pending Bookings</h6>
                                <h3><?= $stats['pending_bookings'] ?></h3>
                            </div>
                            <i class="bi bi-clock-history icon-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card stat-card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6>Average Rating</h6>
                                <h3><?= number_format($stats['avg_rating'], 1) ?> ⭐</h3>
                            </div>
                            <i class="bi bi-star icon-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary Stats Row -->
        <div class="row mb-4">
            <div class="col-md-2 mb-3">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <i class="bi bi-people mb-2 text-primary icon-lg"></i>
                        <h6>Users</h6>
                        <h4><?= $stats['users'] ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <i class="bi bi-map mb-2 text-success icon-lg"></i>
                        <h6>Destinations</h6>
                        <h4><?= $stats['destinations'] ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <i class="bi bi-box-seam mb-2 text-warning icon-lg"></i>
                        <h6>Packages</h6>
                        <h4><?= $stats['packages'] ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <i class="bi bi-chat-dots mb-2 text-info icon-lg"></i>
                        <h6>Reviews</h6>
                        <h4><?= $stats['reviews'] ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <i class="bi bi-envelope mb-2 text-danger icon-lg"></i>
                        <h6>Messages</h6>
                        <h4><?= $stats['messages'] ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <i class="bi bi-newspaper mb-2 text-secondary icon-lg"></i>
                        <h6>Subscribers</h6>
                        <h4><?= $stats['subscribers'] ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Bookings and Popular Destinations -->
        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Bookings</h5>
                        <a href="bookings.php" class="btn btn-sm btn-primary">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Package</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_bookings as $booking): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($booking['username']) ?></td>
                                        <td><?= htmlspecialchars($booking['package_name']) ?></td>
                                        <td><?= htmlspecialchars($booking['travel_date']) ?></td>
                                        <td>
                                            <span class="badge bg-<?= $booking['status'] === 'confirmed' ? 'success' : ($booking['status'] === 'pending' ? 'warning' : 'danger') ?>">
                                                <?= ucfirst(htmlspecialchars($booking['status'])) ?>
                                            </span>
                                        </td>
                                        <td><?= formatPrice($booking['total_price']); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Popular Destinations</h5>
                        <a href="destinations.php" class="btn btn-sm btn-primary">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <?php foreach ($popular_destinations as $destination): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <?= htmlspecialchars($destination['name']) ?>
                                <span class="badge bg-primary rounded-pill">
                                    <?= $destination['booking_count'] ?> bookings
                                </span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <a href="add_package.php" class="btn btn-outline-primary w-100">
                                    <i class="bi bi-plus-circle"></i> Add Package
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="add_destination.php" class="btn btn-outline-success w-100">
                                    <i class="bi bi-geo-alt"></i> Add Destination
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="messages.php" class="btn btn-outline-info w-100">
                                    <i class="bi bi-envelope"></i> View Messages
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="reviews.php" class="btn btn-outline-warning w-100">
                                    <i class="bi bi-star"></i> Manage Reviews
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
