<?php
require_once '../includes/functions.php';
require_once '../config/database.php';

// Only logged-in users
if (!isLoggedIn()) {
    redirectWith('login.php', 'Please login to view your profile.', 'warning');
}
$user_id = $_SESSION['user_id'];

// Fetch user info
$stmt = $conn->prepare('SELECT first_name, last_name, email FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch past bookings
$stmt = $conn->prepare(
    'SELECT b.travel_date, b.number_of_people, b.total_price, b.status, p.name AS package_name
     FROM bookings b
     JOIN packages p ON b.package_id = p.id
     WHERE b.user_id = ?
     ORDER BY b.travel_date DESC'
);
$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Current cart items
$cartItems = [];
if (!empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $inQuery = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $conn->prepare("SELECT * FROM packages WHERE id IN ($inQuery)");
    $stmt->execute($ids);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $cartItems[$row['id']] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Travelminds</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container mt-5 pt-5">
    <h2>Welcome, <?php echo htmlspecialchars($user['first_name']); ?>!</h2>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h5>
            <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        </div>
    </div>

    <h3>Past Bookings</h3>
    <?php if ($bookings): ?>
        <div class="table-responsive mb-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Package</th>
                        <th>People</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($bookings as $b): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($b['travel_date']); ?></td>
                        <td><?php echo htmlspecialchars($b['package_name']); ?></td>
                        <td><?php echo intval($b['number_of_people']); ?></td>
                        <td><?php echo formatPrice($b['total_price']); ?></td>
                        <td><?php echo ucfirst(htmlspecialchars($b['status'])); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>No past bookings found.</p>
    <?php endif; ?>

    <h3>Current Cart</h3>
    <?php if ($cartItems): ?>
        <ul class="list-group">
            <?php foreach ($cartItems as $item): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo htmlspecialchars($item['name']); ?>
                    <span class="badge bg-primary rounded-pill"><?php echo formatPrice($item['price']); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</div>
<?php include '../includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
