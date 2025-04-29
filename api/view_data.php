<?php
require_once 'database.php';

header('Content-Type: application/json');

try {
    // Get data from all tables
    $tables = ['newsletter_subscribers', 'portal_access', 'lost_stolen_items'];
    $data = [];
    
    foreach ($tables as $table) {
        $stmt = $conn->query("SELECT * FROM $table");
        $data[$table] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    echo json_encode($data, JSON_PRETTY_PRINT);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?> 