<?php
// Disable error reporting
error_reporting(0);
ini_set('display_errors', 0);

require_once '../config/database.php';
require_once '../includes/functions.php';

// Check database connection
if (!isset($conn)) {
    die("Database connection failed");
}

// Fetch destinations with optional search
try {
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    if ($search) {
        $stmt = $conn->prepare("SELECT d.*, MIN(p.price) AS min_price FROM destinations d LEFT JOIN packages p ON p.destination_id = d.id WHERE d.name LIKE :search OR d.country LIKE :search OR d.description LIKE :search GROUP BY d.id ORDER BY d.name ASC");
        $searchParam = "%{$search}%";
        $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
        $stmt->execute();
    } else {
        $stmt = $conn->query("SELECT d.*, MIN(p.price) AS min_price FROM destinations d LEFT JOIN packages p ON p.destination_id = d.id GROUP BY d.id ORDER BY d.name ASC");
    }
    $destinations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching destinations: " . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinations - Travelminds Travel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section text-center text-white d-flex align-items-center justify-content-center" 
             style="background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                    url('../images/CharisEdit-0568.jpeg') no-repeat center center; 
                    background-size: cover; height: 70vh; margin-bottom: 3rem;">
        <div class="container">
            <h1 class="display-3 fw-bold mb-4">Explore Our Destinations</h1>
            <p class="lead mb-4">Discover amazing places around the world with Travelminds Travel</p>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form class="d-flex" action="" method="GET">
                        <input type="search" name="search" class="form-control form-control-lg me-2" placeholder="Search destinations..." aria-label="Search destinations">
                        <button class="btn btn-primary btn-lg" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Destinations Section -->
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="display-5 mb-3">Featured Destinations</h2>
                <p class="lead text-muted">Choose from our carefully curated selection of top travel destinations</p>
            </div>
        </div>
        <?php echo displayMessage(); ?>
        
        <div class="row">
            <?php if (empty($destinations)): ?>
                <div class="col-12 text-center">
                    <p>No destinations found. Please check the database connection and data.</p>
                </div>
            <?php else: ?>
                <?php foreach ($destinations as $destination): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card destination-card h-100">
                            <img src="<?php 
                                $url = htmlspecialchars($destination['image_url']);
                                // Handle both absolute URLs and local paths
                                echo (filter_var($url, FILTER_VALIDATE_URL)) ? $url : '../' . $url;
                                ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo htmlspecialchars($destination['name']); ?>"
                                 style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($destination['name']); ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($destination['country']); ?></h6>
                                <p class="card-text"><?php echo htmlspecialchars($destination['description']); ?></p>
                                <p class="card-text">
                                    <strong>Starting from: <?php echo formatPrice($destination['min_price']); ?></strong>
                                </p>
                                <a href="destination.php?id=<?php echo $destination['id']; ?>" 
                                   class="btn btn-primary">View Destination</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Travelminds Travel</h5>
                    <p>Your trusted partner in creating unforgettable travel experiences.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="../index.php">Home</a></li>
                        <li><a href="destinations.php">Destinations</a></li>
                        <li><a href="packages.php">Packages</a></li>
                        <li><a href="../index.php#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact Us</h5>
                    <p>
                        <i class="fas fa-phone"></i> +1 234 567 890<br>
                        <i class="fas fa-envelope"></i> info@travelminds.com<br>
                        <i class="fas fa-map-marker-alt"></i> 123 Travel Street, City
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>