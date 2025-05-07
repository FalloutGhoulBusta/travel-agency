<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

// Function to get image filename based on package name
function getPackageImageFilename($packageName) {
    $name = strtolower($packageName);
    $name = str_replace(' & ', '-', $name);
    $name = str_replace(['&', ' '], '-', $name);
    
    // Map specific package names to image filenames
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

// Fetch all packages with destination information
$stmt = $conn->query("
    SELECT p.*, d.name as destination_name, d.country
    FROM packages p 
    JOIN destinations d ON p.destination_id = d.id 
    ORDER BY p.created_at DESC
");
$packages = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Packages - Travelminds Travel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <div class="container mt-5 pt-5">
        <h2 class="text-center mb-4">Travel Packages</h2>
        <?php echo displayMessage(); ?>
        
        <div class="row">
            <?php foreach ($packages as $package): ?>
                <div class="col-md-4 mb-4">
                    <div class="card package-card">
                        <img src="../images/packages/<?php echo htmlspecialchars(getPackageImageFilename($package['name'])); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($package['name']); ?>" style="height: 250px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($package['name']); ?></h5>
                            <p class="card-text"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($package['destination_name']); ?>, <?php echo htmlspecialchars($package['country']); ?></p>
                            <p class="card-text"><i class="fas fa-clock"></i> Duration: <?php echo $package['duration']; ?> days</p>
                            <p class="card-text"><i class="fas fa-tag"></i> Price: <?php echo formatPrice($package['price']); ?> per person</p>
                            <p class="card-text"><?php echo htmlspecialchars($package['description']); ?></p>
                            
                            <?php if (isLoggedIn()): ?>
                                <?php if (isset($_SESSION['cart'][$package['id']])): ?>
                                    <a href="../php/cart.php" class="btn btn-success">Checkout</a>
                                <?php else: ?>
                                    <a href="cart.php?add=<?php echo $package['id']; ?>" class="btn btn-primary">Add to Cart</a>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="login.php" class="btn btn-primary">Login to Add to Cart</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <?php include '../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>