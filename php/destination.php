<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

// Get destination ID or name from URL
$destination_id = isset($_GET['id']) ? $_GET['id'] : null;
$destination_name = isset($_GET['name']) ? $_GET['name'] : null;

// Fetch destination details
try {
    if ($destination_id) {
        $stmt = $conn->prepare("SELECT * FROM destinations WHERE id = :id");
        $stmt->bindParam(':id', $destination_id);
    } else if ($destination_name) {
        $stmt = $conn->prepare("SELECT * FROM destinations WHERE name = :name");
        $stmt->bindParam(':name', $destination_name);
    } else {
        header("Location: destinations.php");
        exit();
    }
    
    $stmt->execute();
    $destination = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$destination) {
        header("Location: destinations.php");
        exit();
    }

    // Fetch related packages for this destination
    $stmt = $conn->prepare("
        SELECT * FROM packages 
        WHERE LOWER(name) LIKE LOWER(:dest_name) 
        OR LOWER(name) LIKE LOWER(:dest_alt_name)
        OR LOWER(description) LIKE LOWER(:dest_desc)
        ORDER BY price ASC
    ");
    
    // Handle special cases and variations
    $searchParam = '%' . strtolower($destination['name']) . '%';
    $altSearchParam = ($destination['name'] == 'New York City') ? '%NYC%' : $searchParam;
    $descSearchParam = '%' . strtolower($destination['name']) . '%';
    
    $stmt->bindParam(':dest_name', $searchParam);
    $stmt->bindParam(':dest_alt_name', $altSearchParam);
    $stmt->bindParam(':dest_desc', $descSearchParam);
    $stmt->execute();
    $packages = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($destination['name']); ?> - Travelminds Travel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .destination-hero {
            height: 60vh;
            background-size: cover;
            background-position: center;
            position: relative;
            color: white;
            display: flex;
            align-items: center;
            margin-top: 56px;
        }
        .destination-hero .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
        }
        .destination-hero .container {
            position: relative;
            z-index: 2;
        }
        .destination-hero h1 {
            font-size: 3.5rem;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        .destination-hero .lead {
            font-size: 1.8rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }
        .highlights-list {
            list-style: none;
            padding-left: 0;
        }
        .highlights-list li {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .highlights-list li:last-child {
            border-bottom: none;
        }
        .highlights-list li i {
            margin-right: 10px;
            color: #0d6efd;
        }
        .quick-info li {
            margin-bottom: 15px;
        }
        .quick-info i {
            width: 25px;
            color: #0d6efd;
        }
        .package-card {
            transition: transform 0.3s ease;
        }
        .package-card:hover {
            transform: translateY(-5px);
        }
        .weather-container {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .weather-icon {
            font-size: 2.5rem;
            color: #0d6efd;
            margin-right: 1rem;
            width: 2.5rem;
            text-align: center;
        }
        .weather-info {
            flex-grow: 1;
        }
        .weather-detail {
            background-color: white;
            border-radius: 8px;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            border: 1px solid rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
        }
        .weather-detail i {
            color: #0d6efd;
            width: 1.5rem;
            text-align: center;
            margin-right: 0.5rem;
        }
        .weather-detail span {
            font-size: 1.1rem;
        }
        .weather-description {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }
        .weather-time {
            color: #6c757d;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="../index.php">Travelminds</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="destinations.php">Destinations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="packages.php">Packages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php#contact">Contact</a>
                    </li>
                    <?php if (isLoggedIn()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="destination-hero" style="background-image: url('../<?php echo htmlspecialchars($destination['image_url']); ?>')">
        <div class="overlay"></div>
        <div class="container">
            <h1><?php echo htmlspecialchars($destination['name']); ?></h1>
            <p class="lead"><?php echo htmlspecialchars($destination['country']); ?></p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Left Column: Main Info -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h2>About <?php echo htmlspecialchars($destination['name']); ?></h2>
                            <p class="lead"><?php echo htmlspecialchars($destination['description']); ?></p>
                            
                            <h3 class="mt-4">Highlights</h3>
                            <ul class="highlights-list">
                                <li><i class="fas fa-landmark"></i> Famous landmarks and attractions</li>
                                <li><i class="fas fa-utensils"></i> Local cuisine and cultural experiences</li>
                                <li><i class="fas fa-calendar-alt"></i> Best times to visit</li>
                                <li><i class="fas fa-lightbulb"></i> Travel tips and recommendations</li>
                            </ul>

                            <h3 class="mt-4">Location</h3>
                            <p class="text-muted">Interactive map coming soon...</p>
                        </div>
                    </div>

                    <!-- Available Packages -->
                    <div class="card">
                        <div class="card-body">
                            <h3>Available Packages</h3>
                            <?php if (!empty($packages)): ?>
                                <div class="row">
                                    <?php foreach ($packages as $package): ?>
                                        <div class="col-md-6 mb-4">
                                            <div class="card package-card h-100">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo htmlspecialchars($package['name']); ?></h5>
                                                    <p class="card-text"><?php echo htmlspecialchars($package['description']); ?></p>
                                                    <p class="price h5 text-primary">From <?php echo formatPrice($package['price']); ?></p>
                                                    <?php if (isLoggedIn()): ?>
                                                        <a href="cart.php?add=<?php echo $package['id']; ?>" class="btn btn-primary">Add to Cart</a>
                                                    <?php else: ?>
                                                        <a href="login.php" class="btn btn-primary">Login to Add to Cart</a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p>No packages available at the moment.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Quick Info -->
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4>Quick Information</h4>
                            <ul class="list-unstyled quick-info">
                                <li><i class="fas fa-globe"></i> Country: <?php echo htmlspecialchars($destination['country']); ?></li>
                                <li><i class="fas fa-money-bill"></i> Starting from: <?php echo formatPrice(min(array_column($packages, 'price'))); ?></li>
                                <li><i class="fas fa-calendar-check"></i> Best Time to Visit: Year-round</li>
                                <li><i class="fas fa-clock"></i> Recommended Stay: 5-7 days</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Weather Widget -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4>Current Weather</h4>
                            <div id="weather-info" class="mt-3">
                                <div class="d-flex justify-content-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Map Placeholder -->
                    <div class="card">
                        <div class="card-body">
                            <h4>Location</h4>
                            <p class="text-muted">Interactive map coming soon...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
    <script>
        // Destination coordinates and timezones
        const destinationData = {
            1: { coords: [48.8566, 2.3522], timezone: 'Europe/Paris' },       // Paris
            2: { coords: [35.6762, 139.6503], timezone: 'Asia/Tokyo' },       // Tokyo
            3: { coords: [40.7128, -74.0060], timezone: 'America/New_York' },  // New York City
            4: { coords: [41.9028, 12.4964], timezone: 'Europe/Rome' },       // Rome
            5: { coords: [-8.4095, 115.1889], timezone: 'Asia/Makassar' },    // Bali
            6: { coords: [25.2048, 55.2708], timezone: 'Asia/Dubai' },        // Dubai
            7: { coords: [-33.8688, 151.2093], timezone: 'Australia/Sydney' }, // Sydney
            8: { coords: [41.3851, 2.1734], timezone: 'Europe/Madrid' },      // Barcelona
            9: { coords: [-33.9249, 18.4241], timezone: 'Africa/Johannesburg' }, // Cape Town
            10: { coords: [4.1755, 73.5093], timezone: 'Indian/Maldives' }    // Maldives
        };

        // Weather icons mapping with day/night variations and descriptions
        const weatherCodes = {
            0: { icon: 'sun', nightIcon: 'moon', label: 'Clear sky' },
            1: { icon: 'cloud-sun', nightIcon: 'cloud-moon', label: 'Mainly clear' },
            2: { icon: 'cloud-sun', nightIcon: 'cloud-moon', label: 'Partly cloudy' },
            3: { icon: 'cloud', nightIcon: 'cloud', label: 'Overcast' },
            45: { icon: 'smog', nightIcon: 'smog', label: 'Foggy conditions' },
            48: { icon: 'smog', nightIcon: 'smog', label: 'Depositing rime fog' },
            51: { icon: 'cloud-rain', nightIcon: 'cloud-rain', label: 'Light drizzle' },
            53: { icon: 'cloud-rain', nightIcon: 'cloud-rain', label: 'Moderate drizzle' },
            55: { icon: 'cloud-rain', nightIcon: 'cloud-rain', label: 'Dense drizzle' },
            61: { icon: 'cloud-showers-heavy', nightIcon: 'cloud-showers-heavy', label: 'Slight rain' },
            63: { icon: 'cloud-showers-heavy', nightIcon: 'cloud-showers-heavy', label: 'Moderate rain' },
            65: { icon: 'cloud-showers-heavy', nightIcon: 'cloud-showers-heavy', label: 'Heavy rain' },
            71: { icon: 'snowflake', nightIcon: 'snowflake', label: 'Light snow' },
            73: { icon: 'snowflake', nightIcon: 'snowflake', label: 'Moderate snow' },
            75: { icon: 'snowflake', nightIcon: 'snowflake', label: 'Heavy snow' },
            77: { icon: 'snowflake', nightIcon: 'snowflake', label: 'Snow grains' },
            80: { icon: 'cloud-rain', nightIcon: 'cloud-rain', label: 'Light rain showers' },
            81: { icon: 'cloud-rain', nightIcon: 'cloud-rain', label: 'Moderate rain showers' },
            82: { icon: 'cloud-rain', nightIcon: 'cloud-rain', label: 'Violent rain showers' },
            85: { icon: 'snowflake', nightIcon: 'snowflake', label: 'Light snow showers' },
            86: { icon: 'snowflake', nightIcon: 'snowflake', label: 'Heavy snow showers' },
            95: { icon: 'cloud-bolt', nightIcon: 'cloud-bolt', label: 'Thunderstorm' },
            96: { icon: 'cloud-bolt', nightIcon: 'cloud-bolt', label: 'Thunderstorm with light hail' },
            99: { icon: 'cloud-bolt', nightIcon: 'cloud-bolt', label: 'Thunderstorm with heavy hail' }
        };

        async function getWeather(lat, lon, timezone) {
            try {
                const response = await fetch(
                    `https://api.open-meteo.com/v1/forecast?` +
                    `latitude=${lat}&longitude=${lon}&` +
                    `current_weather=true&` +
                    `temperature_unit=celsius&` +
                    `timezone=${timezone}`
                );
                const data = await response.json();
                
                const weather = data.current_weather;
                const weatherInfo = document.getElementById('weather-info');
                
                // Get current time in the destination's timezone
                const now = new Date();
                
                // Create formatters for the specific timezone
                const timeFormatter = new Intl.DateTimeFormat('en-US', {
                    hour: 'numeric',
                    minute: 'numeric',
                    hour12: true,
                    timeZone: timezone
                });

                const dateFormatter = new Intl.DateTimeFormat('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    timeZone: timezone
                });

                // Get the hour in the destination's timezone
                const hourFormatter = new Intl.DateTimeFormat('en-US', {
                    hour: 'numeric',
                    hour12: false,
                    timeZone: timezone
                });
                
                const hour = parseInt(hourFormatter.format(now));
                const isNight = hour >= 18 || hour < 6;
                
                // Get weather info from our mapping
                const weatherData = weatherCodes[weather.weathercode] || { 
                    icon: 'question',
                    nightIcon: 'question',
                    label: 'Unknown weather condition'
                };
                
                // Choose the appropriate icon based on time of day
                const iconToUse = isNight ? weatherData.nightIcon : weatherData.icon;
                
                // Format the current time and date using the formatters
                const localTime = timeFormatter.format(now);
                const localDate = dateFormatter.format(now);

                weatherInfo.innerHTML = `
                    <div class="weather-container">
                        <div class="d-flex align-items-start mb-3">
                            <div class="weather-icon">
                                <i class="fas fa-${iconToUse}" title="${weatherData.label}"></i>
                            </div>
                            <div class="weather-info">
                                <div class="weather-description">${weatherData.label}</div>
                                <div class="weather-time">
                                    <i class="fas fa-clock"></i> Local time: ${localTime}
                                </div>
                                <div class="weather-date text-muted">
                                    <small>${localDate}</small>
                                </div>
                            </div>
                        </div>
                        <div class="weather-detail">
                            <i class="fas fa-temperature-high"></i>
                            <span>${weather.temperature}°C</span>
                        </div>
                        <div class="weather-detail">
                            <i class="fas fa-wind"></i>
                            <span>${weather.windspeed} km/h wind speed</span>
                        </div>
                    </div>`;

                // Log timezone information for debugging
                console.log('Current time (system):', now.toISOString());
                console.log('Timezone:', timezone);
                console.log('Local hour in destination:', hour);
                console.log('Is night:', isNight);
                console.log('Formatted local time:', localTime);
                console.log('Formatted local date:', localDate);

            } catch (error) {
                console.error('Error fetching weather:', error);
                document.getElementById('weather-info').innerHTML = `
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Weather information temporarily unavailable
                    </div>`;
            }
        }

        // Get the destination ID and fetch weather
        const destinationId = <?php echo $destination_id; ?>;
        const destination = destinationData[destinationId];
        if (destination) {
            getWeather(destination.coords[0], destination.coords[1], destination.timezone);
        }
    </script>
</body>
</html> 