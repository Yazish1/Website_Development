<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log errors to a file
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

require_once 'database.php';

// Log the request method and POST data
error_log("Request method: " . $_SERVER["REQUEST_METHOD"]);
error_log("POST data: " . print_r($_POST, true));

// Handle Newsletter Signup Form
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['email'])) {
    $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = "INSERT INTO newsletter_subscribers (email, subscription_date) VALUES (?, NOW())";
        $stmt = $conn->prepare($sql);
        
        try {
            $stmt->execute([$email]);
            echo "Thank you for subscribing to our newsletter!";
        } catch (PDOException $e) {
            error_log("Newsletter error: " . $e->getMessage());
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Invalid email format";
    }
}

// Handle Portal Access Form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['roomnumber']) && isset($_POST['password'])) {
    $roomnumber = htmlspecialchars($_POST['roomnumber'], ENT_QUOTES, 'UTF-8');
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO portal_access (room_number, password_hash, created_at) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    
    try {
        $stmt->execute([$roomnumber, $password]);
        echo "Portal access created successfully!";
    } catch (PDOException $e) {
        error_log("Portal access error: " . $e->getMessage());
        echo "Error: " . $e->getMessage();
    }
}

// Handle Lost or Stolen Items Form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['roomnumber']) && isset($_POST['description'])) {
    error_log("Processing lost/stolen form submission");
    
    // Sanitize inputs using htmlspecialchars instead of deprecated FILTER_SANITIZE_STRING
    $roomnumber = htmlspecialchars($_POST['roomnumber'], ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
    $time_incident = htmlspecialchars($_POST['time_incident'], ENT_QUOTES, 'UTF-8');
    $location = htmlspecialchars($_POST['location'], ENT_QUOTES, 'UTF-8');
    $status = htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8');
    
    error_log("Form data: Room: $roomnumber, Description: $description, Time: $time_incident, Location: $location, Status: $status");
    
    // Validate status
    if ($status !== 'lost' && $status !== 'stolen') {
        error_log("Invalid status: $status");
        echo "Invalid status. Must be either 'lost' or 'stolen'.";
        exit;
    }
    
    try {
        // First verify the database connection
        $conn->query("SELECT 1");
        
        $sql = "INSERT INTO lost_stolen_items (room_number, item_description, time_incident, location, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        $stmt->execute([$roomnumber, $description, $time_incident, $location, $status]);
        error_log("Lost/stolen item report submitted successfully");
        echo "Lost or stolen item report submitted successfully!";
    } catch (PDOException $e) {
        error_log("Lost/stolen form error: " . $e->getMessage());
        echo "Error: " . $e->getMessage();
    }
} else {
    error_log("Missing required fields in POST data");
    echo "Error: Missing required fields";
}
?> 