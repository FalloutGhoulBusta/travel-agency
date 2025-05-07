<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travelminds Travel Agency</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .carousel {
            margin-top: 56px; /* Adjust based on navbar height */
        }
        .carousel-item {
            height: 80vh;
        }
        .carousel-item img {
            object-fit: cover;
            height: 100%;
            width: 100%;
        }
        .carousel-caption {
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            max-width: 600px;
            margin: 0 auto;
            bottom: 20%;
        }
        .carousel-caption h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .carousel-caption p {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
        }
        .carousel-caption .btn {
            font-size: 1.1rem;
            padding: 10px 30px;
            transition: all 0.3s ease;
        }
        .carousel-caption .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        .hero {
            position: relative;
            height: 100vh;
            background: url('images/manuel-moreno-DGa0LQ0yDPc-unsplash.jpeg') no-repeat center center;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            margin-top: -56px; /* Compensate for fixed navbar */
        }
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent overlay */
        }
        .hero-content {
            position: relative;
            z-index: 2;
            padding: 20px;
            max-width: 800px;
        }
        .hero h1 {
            font-size: 4rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .hero p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }
        .hero .btn {
            font-size: 1.2rem;
            padding: 15px 40px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .hero .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>
    <?php require_once 'includes/functions.php'; include 'includes/header.php'; ?>
    <!-- Carousel Section -->
    <div id="destinationCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#destinationCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#destinationCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#destinationCarousel" data-bs-slide-to="2"></button>
            <button type="button" data-bs-target="#destinationCarousel" data-bs-slide-to="3"></button>
            <button type="button" data-bs-target="#destinationCarousel" data-bs-slide-to="4"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="5000">
                <img src="images/destinations/dubai.jpg" class="d-block w-100" alt="Dubai">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Dubai, UAE</h2>
                    <p>Experience luxury and modern marvels in the heart of the desert</p>
                    <a href="php/destinations.php" class="btn btn-light">Explore Dubai</a>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="5000">
                <img src="images/destinations/rome.jpg" class="d-block w-100" alt="Rome">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Rome, Italy</h2>
                    <p>Walk through centuries of history in the Eternal City</p>
                    <a href="php/destinations.php" class="btn btn-light">Visit Rome</a>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="5000">
                <img src="images/destinations/sydney.jpg" class="d-block w-100" alt="Sydney">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Sydney, Australia</h2>
                    <p>Where iconic architecture meets stunning harbors</p>
                    <a href="php/destinations.php" class="btn btn-light">Explore Sydney</a>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="5000">
                <img src="images/destinations/newyork.jpg" class="d-block w-100" alt="New York">
                <div class="carousel-caption d-none d-md-block">
                    <h2>New York City, USA</h2>
                    <p>The city that never sleeps awaits your adventure</p>
                    <a href="php/destinations.php" class="btn btn-light">Discover NYC</a>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="5000">
                <img src="images/destinations/maldives.jpg" class="d-block w-100" alt="Maldives">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Maldives</h2>
                    <p>Paradise found in crystal clear waters and white sandy beaches</p>
                    <a href="php/destinations.php" class="btn btn-light">Explore Maldives</a>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#destinationCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#destinationCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Hero Section -->
    <header id="home" class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Discover Your Next Adventure</h1>
            <p>Explore the world with our curated travel experiences</p>
            <a href="php/packages.php" class="btn btn-primary btn-lg">View Packages</a>
        </div>
    </header>

    <!-- Featured Destinations -->
    <section id="destinations" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Popular Destinations</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card destination-card">
                        <img src="images/destinations/paris.jpg" class="card-img-top" alt="Paris">
                        <div class="card-body">
                            <h5 class="card-title">Paris, France</h5>
                            <p class="card-text">Experience the city of love and its iconic landmarks.</p>
                            <a href="php/destinations.php" class="btn btn-outline-primary">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card destination-card">
                        <img src="images/destinations/tokyo.jpg" class="card-img-top" alt="Tokyo">
                        <div class="card-body">
                            <h5 class="card-title">Tokyo, Japan</h5>
                            <p class="card-text">Discover the perfect blend of tradition and technology.</p>
                            <a href="php/destinations.php" class="btn btn-outline-primary">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card destination-card">
                        <img src="images/destinations/bali.jpg" class="card-img-top" alt="Bali">
                        <div class="card-body">
                            <h5 class="card-title">Bali, Indonesia</h5>
                            <p class="card-text">Relax on pristine beaches and explore ancient temples.</p>
                            <a href="php/destinations.php" class="btn btn-outline-primary">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="php/destinations.php" class="btn btn-primary">View All Destinations</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Travelminds Travel</h5>
                    <p>Your trusted partner in creating unforgettable travel experiences.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#home">Home</a></li>
                        <li><a href="php/destinations.php">Destinations</a></li>
                        <li><a href="php/packages.php">Packages</a></li>
                        <li><a href="#contact">Contact</a></li>
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
    <script src="js/main.js"></script>
</body>
</html>