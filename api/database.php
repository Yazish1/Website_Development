<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get database connection details from environment variables
$host = getenv('DB_HOST');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');
$port = getenv('DB_PORT') ?: '5432';

// Log connection details (without password)
error_log("Attempting to connect to database: host=$host, port=$port, dbname=$dbname, user=$username");

// Check if required environment variables are set
if (!$host || !$username || !$password || !$dbname) {
    die("Database configuration error: Missing required environment variables");
}

// Create connection using PDO for PostgreSQL
try {
    // First try with SSL
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
    $conn = new PDO($dsn, $username, $password, $options);
    error_log("Database connection successful");
} catch(PDOException $e) {
    error_log("Database connection error: " . $e->getMessage());
    die("Connection failed: " . $e->getMessage());
}
?> 