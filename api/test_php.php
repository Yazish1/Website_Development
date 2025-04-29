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

// Check if PDO is available
echo "<h1>PDO Check</h1>";
if (extension_loaded('pdo')) {
    echo "<p style='color:green'>PDO extension is loaded</p>";
    
    // Check if PDO PostgreSQL driver is available
    if (extension_loaded('pdo_pgsql')) {
        echo "<p style='color:green'>PDO PostgreSQL driver is loaded</p>";
    } else {
        echo "<p style='color:red'>PDO PostgreSQL driver is NOT loaded</p>";
    }
    
    // List all available PDO drivers
    echo "<h2>Available PDO Drivers:</h2>";
    echo "<pre>";
    print_r(PDO::getAvailableDrivers());
    echo "</pre>";
} else {
    echo "<p style='color:red'>PDO extension is NOT loaded</p>";
}

// Check environment variables
echo "<h1>Environment Variables</h1>";
$envVars = ['DB_HOST', 'DB_USERNAME', 'DB_PASSWORD', 'DB_NAME', 'DB_PORT'];
foreach ($envVars as $var) {
    $value = getenv($var);
    if ($value) {
        // Mask password
        if ($var === 'DB_PASSWORD') {
            echo "<p>$var: ********</p>";
        } else {
            echo "<p>$var: $value</p>";
        }
    } else {
        echo "<p style='color:red'>$var: Not set</p>";
    }
}

// Check file permissions
echo "<h1>File Permissions</h1>";
$files = ['database.php', 'process_forms.php', 'process_lost_stolen.php'];
foreach ($files as $file) {
    if (file_exists($file)) {
        echo "<p>$file: Exists, " . (is_readable($file) ? "readable" : "not readable") . "</p>";
    } else {
        echo "<p style='color:red'>$file: Does not exist</p>";
    }
}
?> 