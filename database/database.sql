SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS suple_store
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE suple_store;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    image VARCHAR(255),
    active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uk_products_name (name),
    CONSTRAINT fk_products_categories
        FOREIGN KEY (category_id) REFERENCES categories(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Contraseña inicial: admin123. El login actualiza este hash a password_hash() en el primer acceso.
INSERT IGNORE INTO users (username, password) VALUES
('admin', SHA2('admin123', 256));

INSERT IGNORE INTO categories (name) VALUES
('Proteínas'),
('Creatinas'),
('Preentrenos'),
('Accesorios'),
('Aminoácidos');

INSERT IGNORE INTO products (category_id, name, description, price, stock, image, active) VALUES
(
    (SELECT id FROM categories WHERE name = 'Proteínas'),
    'Whey Protein 900g',
    'Suplemento proteico para ayudar en el aumento y mantenimiento de masa muscular.',
    129.90,
    20,
    'isolate.webp',
    1
),
(
    (SELECT id FROM categories WHERE name = 'Creatinas'),
    'Creatina Monohidratada 300g',
    'Creatina monohidratada para mejorar el rendimiento en entrenamientos de alta intensidad.',
    79.90,
    30,
    'creatina300.webp',
    1
),
(
    (SELECT id FROM categories WHERE name = 'Creatinas'),
    'Creatina Monohidratada 1kg',
    'Presentación económica de creatina monohidratada para uso continuo.',
    199.90,
    12,
    'creatina1.webp',
    1
),
(
    (SELECT id FROM categories WHERE name = 'Accesorios'),
    'Shaker',
    'Coctelera práctica para preparar suplementos antes o después del entrenamiento.',
    24.90,
    40,
    'vaso.webp',
    1
),
(
    (SELECT id FROM categories WHERE name = 'Aminoácidos'),
    'BCAA 60 cápsulas',
    'Aminoácidos en cápsulas para complementar la rutina deportiva.',
    49.90,
    25,
    'bcaa.webp',
    1
),
(
    (SELECT id FROM categories WHERE name = 'Proteínas'),
    'Anabolic Mass 28500 3kg',
    'Hipercalórico indicado para dietas con mayor necesidad calórica.',
    149.90,
    15,
    'anabolic.webp',
    1
);
