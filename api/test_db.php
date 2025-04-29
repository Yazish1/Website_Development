<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get database connection details from environment variables
$host = getenv('DB_HOST');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');
$port = getenv('DB_PORT');

echo "<h1>Database Connection Test</h1>";
echo "<p>Host: $host</p>";
echo "<p>Username: $username</p>";
echo "<p>Database: $dbname</p>";
echo "<p>Port: $port</p>";

// Create connection using PDO for PostgreSQL
try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$username;password=$password;sslmode=require";
    $conn = new PDO($dsn);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color: green;'>Connected successfully to the database!</p>";
    
    // Test query to check if tables exist
    $tables = ['newsletter_subscribers', 'portal_access', 'lost_stolen_items'];
    echo "<h2>Table Check:</h2>";
    
    foreach ($tables as $table) {
        try {
            $stmt = $conn->query("SELECT COUNT(*) FROM $table");
            $count = $stmt->fetchColumn();
            echo "<p>Table '$table' exists and has $count records.</p>";
        } catch (PDOException $e) {
            echo "<p style='color: red;'>Table '$table' does not exist or there was an error: " . $e->getMessage() . "</p>";
        }
    }
} catch(PDOException $e) {
    echo "<p style='color: red;'>Connection failed: " . $e->getMessage() . "</p>";
}
?> 