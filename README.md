# Travelminds Travel Agency

![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3)
![React](https://img.shields.io/badge/React_Chatbot-18.3.1-61DAFB)
[![GitHub](https://img.shields.io/badge/GitHub-Repository-181717?logo=github)](https://github.com/FalloutGhoulBusta/travel-agency)

## Overview

Travelminds is a modern, full-featured travel agency website that helps users discover, explore, and book travel packages around the world. The platform combines a beautiful PHP-based website with an interactive React chatbot to provide an exceptional user experience.

## Features

- ud83cudf0e **Destination Showcase**: Explore popular travel destinations with rich imagery and details
- ud83cudf92 **Travel Packages**: Browse and book curated travel packages
- ud83duded2 **Shopping Cart**: Add packages to cart and proceed to checkout
- ud83dudc64 **User Accounts**: Register, login, and manage your profile
- ud83dudcac **AI Chatbot**: Interactive assistant to help with bookings and inquiries
- ud83dudcf1 **Responsive Design**: Optimized for all devices from mobile to desktop
- ud83dudd12 **Secure Authentication**: Protected user accounts and data

## Project Structure

```
travel-agency/
├── admin/                  # Admin panel for managing content
├── chatbot/                # React-based AI chatbot (see chatbot/README.md)
├── config/                 # Configuration files
├── css/                    # Stylesheets
├── database/               # Database scripts and backups
├── images/                 # Image assets
├── includes/               # PHP include files
├── js/                     # JavaScript files
├── php/                    # PHP scripts for various pages
│   ├── api_*.php           # API endpoints for the chatbot
│   ├── cart.php            # Shopping cart functionality
│   ├── destinations.php    # Destination listings
│   ├── packages.php        # Travel package listings
│   ├── login.php           # User authentication
│   └── profile.php         # User profile management
├── index.php               # Main homepage
├── update-ngrok-urls.ps1   # Script for updating URLs when using ngrok
├── run-ngrok-updater.bat   # Batch file to run the ngrok URL updater
└── README.md               # This documentation
```

## Technologies Used

### Backend
- **PHP**: Server-side scripting
- **MySQL**: Database for storing packages, user accounts, and bookings
- **XAMPP**: Local development environment

### Frontend
- **HTML5/CSS3**: Structure and styling
- **Bootstrap 5**: Responsive design framework
- **JavaScript**: Client-side interactivity
- **Font Awesome**: Icons

### Chatbot
- **React**: Frontend library
- **TypeScript**: Type-safe JavaScript
- **Vite**: Build tool
- **TailwindCSS**: Utility-first CSS framework

## Getting Started

### Prerequisites

- XAMPP (or similar PHP/MySQL environment)
- Node.js (for chatbot development)
- ngrok (optional, for exposing local servers)

### Installation

1. **Set up the website:**
   ```bash
   # Clone the repository to your XAMPP htdocs folder
   git clone https://github.com/FalloutGhoulBusta/travel-agency.git travel-agency
   ```

2. **Import the database:**
   - Start XAMPP (Apache and MySQL)
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create a new database named `travel_agency`
   - Import the SQL file from the `database` folder

3. **Configure the database connection:**
   - Edit `config/database.php` with your database credentials

4. **Set up the chatbot:**
   ```bash
   # Navigate to the chatbot directory
   cd travel-agency/chatbot
   
   # Install dependencies
   npm install
   ```

### Running the Application

1. **Start XAMPP:**
   - Start Apache and MySQL services

2. **Run the chatbot development server:**
   ```bash
   # In the chatbot directory
   npm run dev
   ```

3. **Access the website:**
   - Open your browser and navigate to: http://localhost/travel-agency

## Using ngrok for External Access

To expose your local development environment to the internet (for testing or sharing):

1. **Make sure ngrok is installed**
   - Download from: https://ngrok.com/download

2. **Run the ngrok URL updater:**
   ```bash
   # From the travel-agency root directory
   ./run-ngrok-updater.bat
   ```

3. **Use the provided URLs:**
   - The script will display URLs for both the website and chatbot
   - When finished, press Enter to restore original URLs

## Deployment

For production deployment:

1. **Set up a web server** with PHP 7.4+ and MySQL 8.0+
2. **Build the chatbot for production:**
   ```bash
   cd chatbot
   npm run build
   ```
3. **Transfer all files** to your web server
4. **Import the database** to your production MySQL server
5. **Update configuration** in `config/database.php`

## License

This project is proprietary and confidential.

## Acknowledgements

- Bootstrap for the responsive UI framework
- Font Awesome for the icon set
- React team for the chatbot framework
