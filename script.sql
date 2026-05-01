-- =========================================================
--  TechZone - Mini-projet E-commerce
--  Base de donnees MySQL
--  Auteur : LSIM 2 - Technologies & Programmation Web
-- =========================================================

DROP DATABASE IF EXISTS techzone;
CREATE DATABASE techzone CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE techzone;

-- ---------------------------------------------------------
-- Table : users
-- ---------------------------------------------------------
CREATE TABLE users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(80)  NOT NULL,
    email       VARCHAR(120) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Table : products
-- ---------------------------------------------------------
CREATE TABLE products (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(120) NOT NULL,
    description TEXT,
    price       DECIMAL(10,2) NOT NULL,
    image       VARCHAR(255),
    category    VARCHAR(60),
    stock       INT DEFAULT 0,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Table : cart  (table de liaison users <-> products)
-- ---------------------------------------------------------
CREATE TABLE cart (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT NOT NULL,
    product_id  INT NOT NULL,
    quantity    INT NOT NULL DEFAULT 1,
    added_at    DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_cart_user
        FOREIGN KEY (user_id)    REFERENCES users(id)    ON DELETE CASCADE,
    CONSTRAINT fk_cart_product
        FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Donnees de demonstration
-- ---------------------------------------------------------
INSERT INTO users (name, email, password) VALUES
('Demo User', 'demo@techzone.tn', '$2y$10$e0NRQ6Zx5oM8bM8CkBH9c.vR3pE9Dq3Yc1l4O3mR9pX2sN5U7t8sa');
-- Mot de passe demo : demo1234

INSERT INTO products (name, description, price, image, category, stock) VALUES
('Laptop Pro 15',     'Ordinateur portable 15 pouces, Intel i7, 16Go RAM, SSD 512Go.',  3499.00, 'laptop.svg',     'Ordinateurs', 12),
('Smartphone X12',    'Smartphone 6.5 pouces, 128Go, double SIM, appareil 64MP.',       1799.00, 'phone.svg',      'Telephones',  25),
('Casque Bluetooth',  'Casque sans fil avec reduction de bruit active.',                 299.00, 'headphones.svg', 'Accessoires', 40),
('Souris Gaming',     'Souris ergonomique RGB 12000 DPI.',                               149.00, 'mouse.svg',      'Accessoires', 60),
('Clavier mecanique', 'Clavier mecanique RGB switches bleus, AZERTY.',                   349.00, 'keyboard.svg',   'Accessoires', 20),
('Ecran 27 pouces',   'Ecran 27 pouces 144Hz QHD IPS.',                                 1299.00, 'monitor.svg',    'Ordinateurs',  8),
('Tablette T10',      'Tablette 10 pouces, 64Go, stylet inclus.',                        899.00, 'tablet.svg',     'Telephones',  18),
('Webcam HD',         'Webcam Full HD 1080p avec micro integre.',                        199.00, 'webcam.svg',     'Accessoires', 35);
