<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log errors to a file
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

// Include database connection
require_once 'database.php';

// Log the request method and POST data
error_log("Lost/Stolen Form - Request method: " . $_SERVER["REQUEST_METHOD"]);
error_log("Lost/Stolen Form - POST data: " . print_r($_POST, true));

// Check if this is a POST request with the required fields
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['roomnumber']) && isset($_POST['description'])) {
    error_log("Processing lost/stolen form submission");
    
    // Sanitize inputs
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