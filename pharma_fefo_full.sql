-- Active: 1780917375212@@127.0.0.1@3306@pharma_fefo
-- =========================
-- DATABASE
-- =========================
CREATE DATABASE IF NOT EXISTS pharma_fefo;
USE pharma_fefo;

-- =========================
-- USER TABLE
-- =========================
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('ADMINISTRATEUR', 'PHARMACIEN', 'PREPARATEUR') NOT NULL
);

-- =========================
-- ROLE TABLES
-- =========================
CREATE TABLE administrateur (
    user_id INT PRIMARY KEY,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);

CREATE TABLE pharmacien (
    user_id INT PRIMARY KEY,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);

CREATE TABLE preparateur (
    user_id INT PRIMARY KEY,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);

-- =========================
-- PRODUCT TABLE
-- =========================
CREATE TABLE product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    reference VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    admin_id INT,
    FOREIGN KEY (admin_id) REFERENCES administrateur(user_id)
        ON DELETE SET NULL
);

-- =========================
-- LOT TABLE
-- =========================
CREATE TABLE lot (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    batch_number VARCHAR(100) NOT NULL,
    expiry_date DATE NOT NULL,
    quantity INT NOT NULL,
    status VARCHAR(50),
    pharmacien_id INT,

    FOREIGN KEY (product_id) REFERENCES product(id)
        ON DELETE CASCADE,

    FOREIGN KEY (pharmacien_id) REFERENCES pharmacien(user_id)
        ON DELETE SET NULL
);

-- =========================
-- ALERT TABLE
-- =========================
CREATE TABLE alert (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lot_id INT NOT NULL,
    type VARCHAR(50),
    level VARCHAR(50),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    is_read BOOLEAN DEFAULT FALSE,

    FOREIGN KEY (lot_id) REFERENCES lot(id)
        ON DELETE CASCADE
);

-- =========================
-- INSERT USERS
-- =========================
INSERT INTO user (name, email, password, role) VALUES
('Admin One', 'admin@pharma.com', '123456', 'ADMINISTRATEUR'),
('Dr Pharm', 'pharmacien@pharma.com', '123456', 'PHARMACIEN'),
('Prep Worker', 'preparateur@pharma.com', '123456', 'PREPARATEUR');

-- =========================
-- INSERT ROLES
-- =========================
INSERT INTO administrateur (user_id) VALUES (1);
INSERT INTO pharmacien (user_id) VALUES (2);
INSERT INTO preparateur (user_id) VALUES (3);

-- =========================
-- INSERT PRODUCTS
-- =========================
INSERT INTO product (name, reference, description, admin_id) VALUES
('Paracetamol 500mg', 'PARA500', 'Pain reliever and fever reducer', 1),
('Amoxicillin 1g', 'AMOX1G', 'Antibiotic for infections', 1),
('Ibuprofen 400mg', 'IBU400', 'Anti-inflammatory drug', 1);

-- =========================
-- INSERT LOTS
-- =========================
INSERT INTO lot (product_id, batch_number, expiry_date, quantity, status, pharmacien_id) VALUES
(1, 'BATCH-PARA-001', '2026-02-01', 100, 'VALID', 2),
(1, 'BATCH-PARA-002', '2025-09-01', 50, 'NEAR_EXPIRY', 2),
(2, 'BATCH-AMOX-001', '2025-12-15', 200, 'VALID', 2),
(2, 'BATCH-AMOX-002', '2025-06-01', 30, 'EXPIRED', 2),
(3, 'BATCH-IBU-001', '2026-05-20', 120, 'VALID', 2);

-- =========================
-- INSERT ALERTS
-- =========================
INSERT INTO alert (lot_id, type, level, created_at, is_read) VALUES
(2, 'EXPIRY_WARNING', 'HIGH', NOW(), FALSE),
(4, 'EXPIRED_PRODUCT', 'CRITICAL', NOW(), FALSE);