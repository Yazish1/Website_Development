-- Create the database (this will be done in Neon DB dashboard)
-- USE harbourview_db;

-- Create newsletter subscribers table
CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    subscription_date TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create portal access table
CREATE TABLE IF NOT EXISTS portal_access (
    id SERIAL PRIMARY KEY,
    room_number VARCHAR(10) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL,
    last_login TIMESTAMP DEFAULT NULL
);

-- Create lost or stolen items table
CREATE TABLE IF NOT EXISTS lost_stolen_items (
    id SERIAL PRIMARY KEY,
    room_number VARCHAR(10) NOT NULL,
    item_description TEXT NOT NULL,
    time_incident TIMESTAMP NOT NULL,
    location VARCHAR(255) NOT NULL,
    status VARCHAR(10) CHECK (status IN ('lost', 'stolen')) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
); 