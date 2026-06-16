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

-- Senha inicial: admin123. O login atualiza este hash para password_hash() no primeiro acesso.
INSERT IGNORE INTO users (username, password) VALUES
('admin', SHA2('admin123', 256));

INSERT IGNORE INTO categories (name) VALUES
('Proteínas'),
('Creatinas'),
('Pre-entrenos'),
('Accesorios'),
('Aminoácidos');

INSERT IGNORE INTO products (category_id, name, description, price, stock, image, active) VALUES
(
    (SELECT id FROM categories WHERE name = 'Proteínas'),
    'Whey Protein 900g',
    'Suplemento proteico para auxiliar no ganho e manutencao de massa muscular.',
    129.90,
    20,
    'product-placeholder.svg',
    1
),
(
    (SELECT id FROM categories WHERE name = 'Creatinas'),
    'Creatina Monohidratada 300g',
    'Creatina monohidratada para melhorar desempenho em treinos de alta intensidade.',
    79.90,
    30,
    'product-placeholder.svg',
    1
),
(
    (SELECT id FROM categories WHERE name = 'Creatinas'),
    'Creatina Monohidratada 1kg',
    'Embalagem economica de creatina monohidratada para uso continuo.',
    199.90,
    12,
    'product-placeholder.svg',
    1
),
(
    (SELECT id FROM categories WHERE name = 'Accesorios'),
    'Shaker',
    'Coqueteleira pratica para preparar suplementos antes ou depois do treino.',
    24.90,
    40,
    'product-placeholder.svg',
    1
),
(
    (SELECT id FROM categories WHERE name = 'Aminoácidos'),
    'BCAA 60 cápsulas',
    'Aminoacidos em capsulas para complementar a rotina esportiva.',
    49.90,
    25,
    'product-placeholder.svg',
    1
),
(
    (SELECT id FROM categories WHERE name = 'Proteínas'),
    'Mass Gainer 3kg',
    'Hipercalorico indicado para dietas com maior necessidade calorica.',
    149.90,
    15,
    'product-placeholder.svg',
    1
);
