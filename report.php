<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Stolen/Lost Items</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="date"],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .success-message {
            color: green;
            margin-top: 10px;
        }
        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Report Stolen/Lost Items</h1>
        
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $item_name = $_POST['item_name'] ?? '';
            $item_type = $_POST['item_type'] ?? '';
            $description = $_POST['description'] ?? '';
            $location = $_POST['location'] ?? '';
            $date = $_POST['date'] ?? '';
            $contact = $_POST['contact'] ?? '';
            
            // Basic validation
            $errors = [];
            if (empty($item_name)) $errors[] = "Item name is required";
            if (empty($item_type)) $errors[] = "Item type is required";
            if (empty($description)) $errors[] = "Description is required";
            if (empty($location)) $errors[] = "Location is required";
            if (empty($date)) $errors[] = "Date is required";
            if (empty($contact)) $errors[] = "Contact information is required";
            
            if (empty($errors)) {
                // In a real application, you would save this to a database
                // For now, we'll just show a success message
                echo '<div class="success-message">Report submitted successfully!</div>';
            } else {
                echo '<div class="error-message">';
                foreach ($errors as $error) {
                    echo "<p>$error</p>";
                }
                echo '</div>';
            }
        }
        ?>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="item_name">Item Name:</label>
                <input type="text" id="item_name" name="item_name" required>
            </div>
            
            <div class="form-group">
                <label for="item_type">Item Type:</label>
                <select id="item_type" name="item_type" required>
                    <option value="">Select type</option>
                    <option value="electronics">Electronics</option>
                    <option value="jewelry">Jewelry</option>
                    <option value="documents">Documents</option>
                    <option value="clothing">Clothing</option>
                    <option value="other">Other</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="location">Location (where it was lost/stolen):</label>
                <input type="text" id="location" name="location" required>
            </div>
            
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
            </div>
            
            <div class="form-group">
                <label for="contact">Contact Information:</label>
                <input type="text" id="contact" name="contact" required>
            </div>
            
            <button type="submit">Submit Report</button>
        </form>
    </div>
</body>
</html> 