<?php
header("Content-Type: text/html; charset=UTF-8");

// …the rest of your report.php code…

// api/report.php

// Initialize variables
$errors = [];
$success = false;
$item_name   = '';
$item_type   = '';
$description = '';
$location    = '';
$date        = '';
$contact     = '';

// If form was submitted, validate and “save”
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pull and sanitize inputs
    $item_name   = trim($_POST['item_name']   ?? '');
    $item_type   = trim($_POST['item_type']   ?? '');
    $description = trim($_POST['description'] ?? '');
    $location    = trim($_POST['location']    ?? '');
    $date        = trim($_POST['date']        ?? '');
    $contact     = trim($_POST['contact']     ?? '');

    // Validation
    if ($item_name   === '') $errors[] = 'Item name is required.';
    if ($item_type   === '') $errors[] = 'Item type is required.';
    if ($description === '') $errors[] = 'Description is required.';
    if ($location    === '') $errors[] = 'Location is required.';
    if ($date        === '') $errors[] = 'Date is required.';
    if ($contact     === '') $errors[] = 'Contact information is required.';

    if (empty($errors)) {
        // Here you would insert into a database or call an API.
        // For now, just mark success.
        $success = true;
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Report Lost or Stolen Items</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; max-width: 800px; margin: auto; }
    .form-container { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .form-group { margin-bottom: 15px; }
    label { display: block; margin-bottom: 5px; font-weight: bold; }
    input[type="text"], input[type="date"], textarea, select {
      width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;
    }
    button { background: #4CAF50; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
    button:hover { background: #45a049; }
    .success { color: green; margin-bottom: 15px; }
    .errors { color: red; margin-bottom: 15px; }
  </style>
</head>
<body>
  <div class="form-container">
    <h1>Report Lost or Stolen Items</h1>

    <?php if ($success): ?>
      <div class="success">Thank you! Your report has been submitted successfully.</div>
    <?php elseif (!empty($errors)): ?>
      <div class="errors">
        <ul>
          <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="form-group">
        <label for="item_name">Item Name:</label>
        <input type="text" id="item_name" name="item_name" value="<?= htmlspecialchars($item_name) ?>" required>
      </div>

      <div class="form-group">
        <label for="item_type">Item Type:</label>
        <select id="item_type" name="item_type" required>
          <option value="">Select type</option>
          <?php 
          $types = ['electronics','jewelry','documents','clothing','other'];
          foreach ($types as $t): ?>
            <option value="<?= $t ?>"
              <?= $item_type=== $t ? 'selected' : '' ?>>
              <?= ucfirst($t) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required><?= htmlspecialchars($description) ?></textarea>
      </div>

      <div class="form-group">
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" value="<?= htmlspecialchars($location) ?>" required>
      </div>

      <div class="form-group">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?= htmlspecialchars($date) ?>" required>
      </div>

      <div class="form-group">
        <label for="contact">Contact Information:</label>
        <input type="text" id="contact" name="contact" value="<?= htmlspecialchars($contact) ?>" required>
      </div>

      <button type="submit">Submit Report</button>
    </form>
  </div>
</body>
</html>
