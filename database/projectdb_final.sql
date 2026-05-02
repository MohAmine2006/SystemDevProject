CREATE DATABASE IF NOT EXISTS projectdb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE projectdb;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS reports;
DROP TABLE IF EXISTS sales;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role ENUM('owner','employee') NOT NULL DEFAULT 'employee',
    login_status ENUM('logged in','logged out') NOT NULL DEFAULT 'logged out',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE products (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name_en VARCHAR(80) NOT NULL,
    name_fr VARCHAR(80) NOT NULL,
    category VARCHAR(50) NOT NULL,
    description TEXT NULL,
    image_url VARCHAR(255) NOT NULL DEFAULT 'assets/images/products/placeholder.svg',
    quantity INT UNSIGNED NOT NULL DEFAULT 0,
    price DECIMAL(10,2) NOT NULL,
    low_stock_threshold INT UNSIGNED NOT NULL DEFAULT 10,
    max_stock_threshold INT UNSIGNED NOT NULL DEFAULT 100,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_products_category (category),
    INDEX idx_products_name_en (name_en),
    INDEX idx_products_stock (quantity, low_stock_threshold)
) ENGINE=InnoDB;

CREATE TABLE sales (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id INT UNSIGNED NOT NULL,
    sold_by INT UNSIGNED NOT NULL,
    quantity_sold INT UNSIGNED NOT NULL,
    price_at_sale DECIMAL(10,2) NOT NULL,
    sold_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_sales_product (product_id),
    INDEX idx_sales_user (sold_by),
    INDEX idx_sales_date (sold_at),
    CONSTRAINT fk_sales_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT,
    CONSTRAINT fk_sales_user FOREIGN KEY (sold_by) REFERENCES users(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE reports (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    report_date DATE NOT NULL,
    total_items INT UNSIGNED NOT NULL DEFAULT 0,
    total_products INT UNSIGNED NOT NULL DEFAULT 0,
    total_inventory_value DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    pdf_filename VARCHAR(255) NULL,
    generated_by INT UNSIGNED NOT NULL,
    generated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_reports_date (report_date),
    INDEX idx_reports_user (generated_by),
    CONSTRAINT fk_reports_user FOREIGN KEY (generated_by) REFERENCES users(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

INSERT INTO users (username, email, password_hash, full_name, role) VALUES
('admin', 'admin@lafruiterieglobal.local', '$2y$12$GXNmf.MYY.Z5VR6aIrukUuobiVuPHPnSwpCxpsSRbuTrXGGs8LqUa', 'Store Admin', 'owner'),
('employee', 'employee@lafruiterieglobal.local', '$2y$12$b/ftkeWRpX1BNLPOW.GTEOmfpuO6KvekN/AYLM6fiSnIe4XlaaQJi', 'Store Employee', 'employee');

INSERT INTO products (name_en, name_fr, category, description, image_url, quantity, price, low_stock_threshold, max_stock_threshold) VALUES
('Organic Bananas', 'Bananes biologiques', 'Fruits', 'Fresh organic bananas sold by bunch.', 'assets/images/products/placeholder.svg', 42, 1.29, 15, 120),
('Red Apples', 'Pommes rouges', 'Fruits', 'Crisp red apples for daily grocery sales.', 'assets/images/products/placeholder.svg', 68, 0.99, 20, 150),
('Whole Milk 2L', 'Lait entier 2L', 'Dairy', 'Two litre whole milk carton.', 'assets/images/products/placeholder.svg', 18, 4.49, 10, 60),
('Greek Yogurt', 'Yogourt grec', 'Dairy', 'Plain Greek yogurt container.', 'assets/images/products/placeholder.svg', 8, 5.99, 12, 80),
('Chicken Breast', 'Poitrine de poulet', 'Meat', 'Fresh chicken breast package.', 'assets/images/products/placeholder.svg', 24, 11.99, 8, 50),
('Frozen Peas', 'Pois surgelés', 'Frozen', 'Frozen green peas bag.', 'assets/images/products/placeholder.svg', 36, 3.49, 10, 90),
('Strawberry Jam', 'Confiture de fraises', 'Jarred Items', 'Sweet strawberry jam jar.', 'assets/images/products/placeholder.svg', 55, 4.25, 10, 75),
('Corn Flakes', 'Flocons de maïs', 'Cereals', 'Breakfast cereal box.', 'assets/images/products/placeholder.svg', 31, 4.75, 10, 70);
