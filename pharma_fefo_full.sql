-- Active: 1780917375212@@127.0.0.1@3306@pharma_fefo
-- =========================
-- DATABASE CONFIGURATION
-- =========================
CREATE DATABASE IF NOT EXISTS pharma_fefo;
USE pharma_fefo;
-- =========================
-- USER TABLE (Mapped to App\Entity\User queries)
-- =========================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE, -- used for login match fields
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,        -- stores secure bcrypt hashes
    role ENUM('ADMINISTRATEUR', 'PHARMACIEN', 'PREPARATEUR') NOT NULL
);

-- =========================
-- ROLE TABLES
-- =========================
CREATE TABLE administrateur (
    user_id INT PRIMARY KEY,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE pharmacien (
    user_id INT PRIMARY KEY,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE preparateur (
    user_id INT PRIMARY KEY,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- =========================
-- PRODUCT TABLE
-- =========================
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    reference VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    unit_price DECIMAL(10, 2) NOT NULL DEFAULT 5.00, -- Required for loss/write-off values
    admin_id INT,
    FOREIGN KEY (admin_id) REFERENCES administrateur(user_id) ON DELETE SET NULL
);

-- =========================
-- LOT TABLE
-- =========================
CREATE TABLE lots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    lot_number VARCHAR(100) NOT NULL,      -- synced with Entity getLotNumber()
    expiration_date DATE NOT NULL,         -- synced with Entity getExpirationDate()
    quantity INT NOT NULL,
    status VARCHAR(50),
    pharmacien_id INT,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (pharmacien_id) REFERENCES pharmacien(user_id) ON DELETE SET NULL
);

-- =========================
-- ALERT TABLE
-- =========================
CREATE TABLE alerts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lot_id INT NOT NULL,
    type VARCHAR(50),
    level VARCHAR(50),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    is_read BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (lot_id) REFERENCES lots(id) ON DELETE CASCADE
);

-- =========================
-- INSERT SECURE CRYPT USERS (Password for all is: 123456)
-- =========================
INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@pharma.com', '$2y$10$w8gZ9YhVbA1K5Vb8/hW0U.WzR/X9PzL6wKBeI6iSDe0C3PjC9iR6.', 'ADMINISTRATEUR'),
('pharmacien', 'pharmacien@pharma.com', '$2y$10$w8gZ9YhVbA1K5Vb8/hW0U.WzR/X9PzL6wKBeI6iSDe0C3PjC9iR6.', 'PHARMACIEN'),
('preparateur', 'preparateur@pharma.com', '$2y$10$w8gZ9YhVbA1K5Vb8/hW0U.WzR/X9PzL6wKBeI6iSDe0C3PjC9iR6.', 'PREPARATEUR');

-- INSERT INTO users(username,email,password,role)VALUES('ayoub',"admin@gmail.com",123456,'ADMINISTRATEUR');
INSERT INTO users(username,email,password,role)
VALUES('ayoub','ayoub@gmail.com','$2y$10$w8gZ9YhVbA1K5Vb8/hW0U.WzR/X9PzL6wKBeI6iSDe0C3PjC9iR6.','ADMINISTRATEUR');
UPDATE users 
SET password = '$2y$10$w8gZ9YhVbA1K5Vb8/hW0U.WzR/X9PzL6wKBeI6iSDe0C3PjC9iR6.'
WHERE username = 'ayoub';
-- =========================
-- INSERT DEPENDENT SUB-ROLES
-- =========================
INSERT INTO administrateur (user_id) VALUES (1);
INSERT INTO pharmacien (user_id) VALUES (2);
INSERT INTO preparateur (user_id) VALUES (3);

-- =========================
-- INSERT PRODUCTS
-- =========================
INSERT INTO products (name, reference, description, unit_price, admin_id) VALUES
('Paracetamol 500mg', 'PARA500', 'Pain reliever and fever reducer', 2.50, 1),
('Amoxicillin 1g', 'AMOX1G', 'Antibiotic for infections', 12.99, 1),
('Ibuprofen 400mg', 'IBU400', 'Anti-inflammatory drug', 4.25, 1);

-- =========================
-- INSERT LOTS (Simulating dates near your timeline context)
-- =========================
INSERT INTO lots (product_id, lot_number, expiration_date, quantity, status, pharmacien_id) VALUES
(1, 'BATCH-PARA-001', '2026-12-01', 100, 'VALID', 2),
(1, 'BATCH-PARA-002', '2026-07-05', 50, 'NEAR_EXPIRY', 2),
(2, 'BATCH-AMOX-001', '2026-09-15', 200, 'VALID', 2),
(2, 'BATCH-AMOX-002', '2026-05-01', 30, 'EXPIRED', 2),
(3, 'BATCH-IBU-001', '2026-11-20', 120, 'VALID', 2);

-- =========================
-- INSERT ALERTS
-- =========================
INSERT INTO alerts (lot_id, type, level, created_at, is_read) VALUES
(2, 'EXPIRY_WARNING', 'HIGH', NOW(), FALSE),
(4, 'EXPIRED_PRODUCT', 'CRITICAL', NOW(), FALSE);
SELECT * FROM users;
SELECT DATABASE();
SHOW TABLES;
SELECT * FROM users;
UPDATE users 
SET password = '$2y$10$somethinghashed'
WHERE username = 'admin';