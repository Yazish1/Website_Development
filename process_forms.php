<?php
require_once 'database.php';

// Handle Newsletter Signup Form
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['email'])) {
    $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = "INSERT INTO newsletter_subscribers (email, subscription_date) VALUES (?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        
        if ($stmt->execute()) {
            echo "Thank you for subscribing to our newsletter!";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
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
    $stmt->bind_param("ss", $roomnumber, $password);
    
    if ($stmt->execute()) {
        echo "Portal access created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?> 