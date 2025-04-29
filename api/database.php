<?php
// Get database connection details from environment variables
$host = getenv('DB_HOST') ?: 'localhost';
$username = getenv('DB_USERNAME') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';
$dbname = getenv('DB_NAME') ?: 'harbourview_db';
$port = getenv('DB_PORT') ?: '5432'; // PostgreSQL default port

// Create connection using PDO for PostgreSQL
try {
    // Add sslmode=require to ensure secure connection
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$username;password=$password;sslmode=require";
    $conn = new PDO($dsn);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?> 