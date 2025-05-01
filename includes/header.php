<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/travel-agency/">Travelminds</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page === 'index.php' ? 'active' : ''; ?>" href="/travel-agency/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page === 'destinations.php' ? 'active' : ''; ?>" href="/travel-agency/php/destinations.php">Destinations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page === 'packages.php' ? 'active' : ''; ?>" href="/travel-agency/php/packages.php">Packages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/travel-agency/">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/travel-agency/">Contact</a>
                </li>
                <?php 
                    $cart_count = (isset($_SESSION['cart']) && isLoggedIn()) ? count($_SESSION['cart']) : 0;
                    $cart_active = $current_page === 'cart.php' ? 'active' : '';
                ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo $cart_active; ?>" href="/travel-agency/php/cart.php">
                        Cart <span class="badge bg-warning text-dark"><?php echo $cart_count; ?></span>
                    </a>
                </li>
                <?php if (isLoggedIn()): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page === 'profile.php' ? 'active' : ''; ?>" href="/travel-agency/php/profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/travel-agency/php/logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page === 'login.php' ? 'active' : ''; ?>" href="/travel-agency/php/login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Chatbot bubble & window -->
<div id="chatbot-bubble" style="position:fixed;bottom:20px;right:20px;width:60px;height:60px;border-radius:50%;background:#007bff;display:flex;align-items:center;justify-content:center;cursor:pointer;z-index:2000;">
  <i class="fas fa-comments fa-2x text-white"></i>
</div>
<div id="chatbot-container" style="display:none;position:fixed;bottom:90px;right:20px;width:400px;height:625.6px;box-shadow:0 4px 12px rgba(0,0,0,0.15);border-radius:8px;overflow:hidden;z-index:2000;">
  <!-- Load React/Vite dev server (localhost:5173) during development -->
  <iframe src="http://localhost:5173" style="border:none;width:100%;height:100%;"></iframe>
</div>

<!-- Chatbot scripts -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const bubble = document.getElementById('chatbot-bubble');
    const container = document.getElementById('chatbot-container');

    bubble.addEventListener('click', () => {
      container.style.display = container.style.display === 'none' ? 'block' : 'none';
    });

    // Listen for messages from the chatbot iframe
    window.addEventListener('message', function(event) {
      // SECURITY TIP: Check event.origin if you move to production!
      // if (event.origin !== 'http://localhost:5173') return;

      if (event.data.type === 'login') {
        // Redirect user to login page
        window.location.href = '/travel-agency/php/login.php';
      }
    });
  });
</script>


