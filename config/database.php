<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'travel_agency');

try {
    // First connect without database
    $conn = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if it doesn't exist
    $conn->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
    
    // Then connect to the database
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if destinations table exists
    $result = $conn->query("SHOW TABLES LIKE 'destinations'");
    if ($result->rowCount() == 0) {
        // Read and execute the SQL file
        $sql = file_get_contents(dirname(__DIR__) . '/database/travel_agency.sql');
        
        // Split the SQL file into individual queries
        $queries = array_filter(array_map('trim', explode(';', $sql)));
        
        // Execute each query separately
        foreach ($queries as $query) {
            if (!empty($query)) {
                try {
                    $conn->exec($query);
                } catch (PDOException $e) {
                    // Log the error but continue with other queries
                    error_log("Error executing query: " . $e->getMessage());
                }
            }
        }
        
        // Verify if the destinations table was created
        $result = $conn->query("SHOW TABLES LIKE 'destinations'");
        if ($result->rowCount() == 0) {
            throw new Exception("Failed to create destinations table");
        }
    }
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
} catch(Exception $e) {
    die("Error: " . $e->getMessage());
}
?> 