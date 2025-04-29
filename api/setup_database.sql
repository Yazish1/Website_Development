-- Create the database
CREATE DATABASE IF NOT EXISTS harbourview_db;
USE harbourview_db;

-- Create newsletter subscribers table
CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    subscription_date DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create portal access table
CREATE TABLE IF NOT EXISTS portal_access (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_number VARCHAR(10) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL,
    last_login DATETIME DEFAULT NULL
);

-- Create lost or stolen items table
CREATE TABLE IF NOT EXISTS lost_stolen_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_number VARCHAR(10) NOT NULL,
    item_description TEXT NOT NULL,
    time_incident DATETIME NOT NULL,
    location VARCHAR(255) NOT NULL,
    status ENUM('lost', 'stolen') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
); 