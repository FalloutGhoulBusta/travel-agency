<?php
// CORS Headers - allow requests from the chatbot iframe (localhost:5173)
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");

// cart.php - Cart page for Travelminds
require_once '../includes/functions.php';
require_once '../config/database.php';
// Ensure user is logged in (session started in functions.php)
if (!isLoggedIn()) {
    redirectWith('login.php', 'Please login to view your cart.', 'danger');
}

// Handle add to cart
if (isset($_GET['add'])) {
    $addId = (int)$_GET['add'];
    if (!isset($_SESSION['cart'][$addId])) {
        $_SESSION['cart'][$addId] = 1;
    }
    header('Location: cart.php');
    exit;
}
// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle remove from cart
if (isset($_GET['remove'])) {
    $removeId = (int)$_GET['remove'];
    unset($_SESSION['cart'][$removeId]);
    header('Location: cart.php');
    exit;
}

// Handle checkout POST (booking)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    $user_id = $_SESSION['user_id'];
    $bookings = $_SESSION['cart'];
    $errors = [];
    foreach ($bookings as $package_id => $cartItem) {
        $travel_date = $_POST['travel_date'][$package_id] ?? '';
        $number_of_people = (int)($_POST['number_of_people'][$package_id] ?? 1);
        if (!$travel_date || $number_of_people < 1) {
            $errors[] = "Please provide travel details for all packages.";
            continue;
        }
        $stmt = $conn->prepare('SELECT price FROM packages WHERE id = ?');
        $stmt->execute([$package_id]);
        $package = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($package) {
            $total_price = $package['price'] * $number_of_people;
            try {
                $stmt = $conn->prepare('INSERT INTO bookings (user_id, package_id, booking_date, travel_date, number_of_people, total_price) VALUES (?, ?, CURDATE(), ?, ?, ?)');
                $stmt->execute([$user_id, $package_id, $travel_date, $number_of_people, $total_price]);
            } catch (PDOException $e) {
                $errors[] = "Failed to book package ID $package_id.";
            }
        }
    }
    if (empty($errors)) {
        // Send booking data to webhook
        $stmtUser = $conn->prepare('SELECT first_name, last_name, email FROM users WHERE id = ?');
        $stmtUser->execute([$user_id]);
        $userData = $stmtUser->fetch(PDO::FETCH_ASSOC) ?: [];
        $payload = [
            'user_name' => trim(($userData['first_name'] ?? '') . ' ' . ($userData['last_name'] ?? '')),
            'user_email' => $userData['email'] ?? '',
            'bookings' => []
        ];
        foreach ($bookings as $pkgId => $qty) {
            $stmtPkg = $conn->prepare('SELECT name, price FROM packages WHERE id = ?');
            $stmtPkg->execute([$pkgId]);
            $pkgData = $stmtPkg->fetch(PDO::FETCH_ASSOC);
            $numberOfPeople = $_POST['number_of_people'][$pkgId] ?? $qty;
            $payload['bookings'][] = [
                'package_name' => $pkgData['name'],
                'travel_date' => $_POST['travel_date'][$pkgId] ?? '',
                'number_of_people' => $numberOfPeople,
                'total_price' => $pkgData['price'] * $numberOfPeople
            ];
        }
        // POST to Make.com webhook
        $ch = curl_init('https://hook.eu2.make.com/0ixqrcqjyepyvl3ktypi8qntmlyp7qye');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_exec($ch);
        curl_close($ch);
        // Clear cart and redirect
        $_SESSION['cart'] = [];
        header('Location: cart.php?success=1');
        exit;
    }
}

// Get cart items details
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
    <title>Your Cart - Travelminds Travel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container mt-5 pt-5">
    <h2 class="text-center mb-4">Your Cart</h2>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Booking successful! Check your email for confirmation.</div>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger"><?php echo implode('<br>', $errors); ?></div>
    <?php endif; ?>
    <?php if (empty($cartItems)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <!-- Display cart items with images -->
        <?php foreach ($cartItems as $id => $item): ?>
          <div class="row mb-3 align-items-center">
            <div class="col-md-2">
              <img src="../images/packages/<?php echo htmlspecialchars(getPackageImageFilename($item['name'])); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($item['name']); ?>">
            </div>
            <div class="col-md-6">
              <h5><?php echo htmlspecialchars($item['name']); ?></h5>
              <p><?php echo formatPrice($item['price']); ?></p>
            </div>
            <div class="col-md-4 text-end">
              <a href="?remove=<?php echo $id; ?>" class="btn btn-danger btn-sm">Remove</a>
            </div>
          </div>
        <?php endforeach; ?>
        <div class="text-end mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookingModal">Checkout & Book</button>
        </div>
        <!-- Booking Modal -->
        <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">Confirm Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <form method="POST">
                  <?php foreach ($cartItems as $id => $item): ?>
                    <div class="mb-3">
                      <label class="form-label"><?php echo htmlspecialchars($item['name']); ?></label>
                      <input type="date" name="travel_date[<?php echo $id; ?>]" class="form-control" required>
                      <input type="number" name="number_of_people[<?php echo $id; ?>]" class="form-control mt-1" min="1" value="1" required>
                    </div>
                  <?php endforeach; ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="checkout" class="btn btn-primary">Confirm Booking</button>
                </form>
              </div>
            </div>
          </div>
        </div>
    <?php endif; ?>
</div>
<?php include '../includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


