<?php
// Get database connection details from environment variables
$host = getenv('ep-still-bar-a76h9qn0-pooler.ap-southeast-2.aws.neon.tech') ?: 'localhost';
$username = getenv('neondb_owner') ?: 'root';
$password = getenv('npg_3U7naAmuTpth') ?: '';
$dbname = getenv('neondb') ?: 'harbourview_db';
$port = getenv('5432') ?: '5432'; // PostgreSQL default port

// Create connection using PDO for PostgreSQL
try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$username;password=$password";
    $conn = new PDO($dsn);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?> 