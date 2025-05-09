-- Create database
CREATE DATABASE IF NOT EXISTS tugas_login_register;
USE tugas_login_register;

-- Create table users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user
INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@example.com', 
 -- Password: admin123 (hashed with password_hash in PHP)
 '$2y$10$e0NRzQ6Q6Q6Q6Q6Q6Q6Q6O6Q6Q6Q6Q6Q6Q6Q6Q6Q6Q6Q6Q6Q6Q6Q6Q6', 
 'admin');
