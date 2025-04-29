<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log errors to a file
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

// Output PHP info
echo "<h1>PHP Information</h1>";
echo "<pre>";
echo "PHP Version: " . phpversion() . "\n";
echo "Loaded Extensions:\n";
print_r(get_loaded_extensions());
echo "</pre>";

// Try to connect to the database
echo "<h1>Database Connection Test</h1>";

// Get database connection details from environment variables
$host = getenv('DB_HOST');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');
$port = getenv('DB_PORT') ?: '5432';

// Log connection details (without password)
error_log("Test DB - Attempting to connect to database: host=$host, port=$port, dbname=$dbname, user=$username");

// Check if required environment variables are set
if (!$host || !$username || !$password || !$dbname) {
    echo "<p style='color:red'>Database configuration error: Missing required environment variables</p>";
    echo "<p>DB_HOST: " . ($host ? "Set" : "Not set") . "</p>";
    echo "<p>DB_USERNAME: " . ($username ? "Set" : "Not set") . "</p>";
    echo "<p>DB_PASSWORD: " . ($password ? "Set" : "Not set") . "</p>";
    echo "<p>DB_NAME: " . ($dbname ? "Set" : "Not set") . "</p>";
    echo "<p>DB_PORT: " . ($port ? "Set" : "Not set") . "</p>";
    exit;
}

// Try to connect using PDO
try {
    // First try with SSL
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
    $conn = new PDO($dsn, $username, $password, $options);
    echo "<p style='color:green'>Database connection successful!</p>";
    
    // Try a simple query
    $stmt = $conn->query("SELECT 1 as test");
    $result = $stmt->fetch();
    echo "<p>Query result: " . $result['test'] . "</p>";
    
    // Check if the lost_stolen_items table exists
    $stmt = $conn->query("SELECT EXISTS (
        SELECT FROM information_schema.tables 
        WHERE table_schema = 'public' 
        AND table_name = 'lost_stolen_items'
    )");
    $tableExists = $stmt->fetch()['exists'];
    
    if ($tableExists) {
        echo "<p style='color:green'>The lost_stolen_items table exists!</p>";
        
        // Show table structure
        $stmt = $conn->query("SELECT column_name, data_type, character_maximum_length 
                             FROM information_schema.columns 
                             WHERE table_name = 'lost_stolen_items'");
        echo "<h2>Table Structure:</h2>";
        echo "<pre>";
        print_r($stmt->fetchAll());
        echo "</pre>";
    } else {
        echo "<p style='color:red'>The lost_stolen_items table does not exist!</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color:red'>Database connection error: " . $e->getMessage() . "</p>";
    error_log("Test DB - Connection error: " . $e->getMessage());
}
?> 