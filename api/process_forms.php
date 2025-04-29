<?php
require_once 'database.php';

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
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Invalid email format";
    }
}

// Handle Portal Access Form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['roomnumber']) && isset($_POST['password'])) {
    $roomnumber = filter_var($_POST['roomnumber'], FILTER_SANITIZE_STRING);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
    
    $sql = "INSERT INTO portal_access (room_number, password_hash, created_at) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    
    try {
        $stmt->execute([$roomnumber, $password]);
        echo "Portal access created successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Handle Lost or Stolen Items Form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['lost_stolen_form'])) {
    $roomnumber = filter_var($_POST['roomnumber'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $time_incident = filter_var($_POST['time_incident'], FILTER_SANITIZE_STRING);
    $location = filter_var($_POST['location'], FILTER_SANITIZE_STRING);
    $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
    
    // Validate status
    if ($status !== 'lost' && $status !== 'stolen') {
        echo "Invalid status. Must be either 'lost' or 'stolen'.";
        exit;
    }
    
    $sql = "INSERT INTO lost_stolen_items (room_number, item_description, time_incident, location, status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    try {
        $stmt->execute([$roomnumber, $description, $time_incident, $location, $status]);
        echo "Lost or stolen item report submitted successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?> 