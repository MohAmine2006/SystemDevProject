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

-- Users
INSERT INTO users (username, email, password_hash, full_name, role) VALUES
('admin',    'admin@lafruiterieglobal.local',    '$2y$12$GXNmf.MYY.Z5VR6aIrukUuobiVuPHPnSwpCxpsSRbuTrXGGs8LqUa', 'Store Admin',    'owner'),
('employee', 'employee@lafruiterieglobal.local', '$2y$12$b/ftkeWRpX1BNLPOW.GTEOmfpuO6KvekN/AYLM6fiSnIe4XlaaQJi', 'Store Employee', 'employee');

-- Snacks
INSERT INTO products (name_en, name_fr, category, description, quantity, price, low_stock_threshold, max_stock_threshold) VALUES
('KitKat',        'KitKat',               'Snacks', 'Classic KitKat chocolate wafer bar.',            45, 2.49, 12, 120),
('Cheerios',      'Cheerios',             'Snacks', 'Whole grain oat cereal.',                        30, 5.99, 10,  90),
('Lays Chips',    'Chips Lays',           'Snacks', 'Original salted potato chips.',                  40, 3.99, 10, 100),
('Ruffles',       'Ruffles',              'Snacks', 'Ridged potato chips.',                           35, 3.99, 10, 100),
('Doritos',       'Doritos',              'Snacks', 'Nacho cheese flavoured tortilla chips.',         38, 4.49, 10, 100),
('Pista Cookies', 'Biscuits aux pistaches','Snacks','Crunchy pistachio cookies.',                    25,  3.49,  8,  80),
('Super Cookies', 'Super Biscuits',       'Snacks', 'Assorted cream-filled cookies.',                30,  2.99,  8,  80),
('Lollipops',     'Sucettes',             'Snacks', 'Assorted fruit-flavoured lollipops.',           60,  0.99, 15, 150),
('Gum',           'Gomme',                'Snacks', 'Sugarless chewing gum pack.',                   50,  1.99, 15, 120),
('Excel',         'Excel',                'Snacks', 'Peppermint chewing gum.',                       45,  1.49, 15, 120);

-- Vegetables
INSERT INTO products (name_en, name_fr, category, description, quantity, price, low_stock_threshold, max_stock_threshold) VALUES
('Celery',        'Céleri',         'Vegetables', 'Fresh celery bunch.',              20, 2.49,  5, 60),
('Green Onion',   'Oignon vert',    'Vegetables', 'Fresh green onion bunch.',         25, 1.49,  5, 60),
('Coriander',     'Coriandre',      'Vegetables', 'Fresh coriander bunch.',           20, 1.29,  5, 50),
('Parsley',       'Persil',         'Vegetables', 'Fresh flat-leaf parsley.',         20, 1.29,  5, 50),
('Cucumber',      'Concombre',      'Vegetables', 'Field cucumber.',                  30, 1.99,  8, 70),
('Carrots',       'Carottes',       'Vegetables', 'Fresh carrots by the pound.',      35, 1.79, 10, 80),
('Spinach',       'Épinards',       'Vegetables', 'Baby spinach bag.',                20, 3.49,  5, 50),
('Broccoli',      'Brocoli',        'Vegetables', 'Fresh broccoli crown.',            18, 2.99,  5, 50),
('Bell Peppers',  'Poivrons',       'Vegetables', 'Mixed colour bell peppers.',       25, 2.49,  8, 60),
('Green Chili',   'Piment vert',    'Vegetables', 'Fresh hot green chili peppers.',  30, 0.99,  8, 70);

-- Fruits
INSERT INTO products (name_en, name_fr, category, description, quantity, price, low_stock_threshold, max_stock_threshold) VALUES
('Banana',      'Banane',     'Fruits', 'Fresh yellow bananas, sold by bunch.',  40, 1.49, 10, 100),
('Apple',       'Pomme',      'Fruits', 'Crisp red or green apple.',             50, 0.99, 15, 120),
('Pear',        'Poire',      'Fruits', 'Ripe Bartlett pear.',                  30, 1.29,  8,  80),
('Peach',       'Pêche',      'Fruits', 'Sweet summer peach.',                  25, 1.49,  8,  70),
('Grapes',      'Raisins',    'Fruits', 'Seedless grapes, per bunch.',          20, 3.99,  5,  60),
('Strawberry',  'Fraise',     'Fruits', 'Fresh strawberry pint.',               18, 4.49,  5,  50),
('Blueberry',   'Bleuet',     'Fruits', 'Fresh blueberry pint.',               15, 4.99,  5,  50),
('Raspberry',   'Framboise',  'Fruits', 'Fresh raspberry half-pint.',           12, 4.99,  5,  40),
('Blackberry',  'Mûre',       'Fruits', 'Fresh blackberry half-pint.',          14, 4.99,  5,  40),
('Orange',      'Orange',     'Fruits', 'Navel orange.',                        45, 0.99, 10, 100);

-- Dairy
INSERT INTO products (name_en, name_fr, category, description, quantity, price, low_stock_threshold, max_stock_threshold) VALUES
('Cheese - Petit Québec',    'Fromage - Petit Québec',      'Dairy', 'Aged cheddar from Petit Québec.',        25, 5.99,  8, 60),
('Mozzarella',               'Mozzarella',                  'Dairy', 'Fresh mozzarella block.',                20, 4.99,  8, 60),
('Feta',                     'Féta',                        'Dairy', 'Crumbled feta cheese.',                  18, 4.99,  5, 50),
('Milk (3.25%)',              'Lait (3,25%)',                'Dairy', 'Whole milk, 2L carton.',                 30, 4.49, 10, 80),
('Milk (2%)',                 'Lait (2%)',                   'Dairy', 'Partly skimmed milk, 2L carton.',        35, 4.29, 10, 80),
('Yogurt - Astro',           'Yogourt - Astro',             'Dairy', 'Astro original plain yogurt.',           20, 5.49,  8, 60),
('Yogurt - Hallal/Khaas',    'Yogourt - Hallal/Khaas',     'Dairy', 'Halal certified yogurt.',                15, 5.49,  8, 50),
('Paneer',                   'Paneer',                      'Dairy', 'Fresh homestyle paneer block.',          12, 6.99,  5, 40),
('Cooking Cream',            'Crème à cuisson',             'Dairy', '35% cooking cream, 473ml.',              18, 3.99,  5, 50),
('Drumsticks',               'Cornets Drumstick',           'Dairy', 'Classic vanilla ice cream cones.',      24, 5.99,  8, 60),
('KitKat Drumsticks',        'Cornets KitKat',              'Dairy', 'KitKat flavoured ice cream cones.',     20, 6.49,  8, 60);

-- Meat
INSERT INTO products (name_en, name_fr, category, description, quantity, price, low_stock_threshold, max_stock_threshold) VALUES
('Chicken Breast',    'Poitrine de poulet', 'Meat', 'Fresh boneless skinless chicken breast.',  24, 11.99, 8, 50),
('Whole Chicken',     'Poulet entier',      'Meat', 'Fresh whole chicken, approx. 1.5–2kg.',    15, 14.99, 5, 40),
('Chicken Drumsticks','Pilons de poulet',   'Meat', 'Fresh chicken drumstick pack.',            20,  9.99, 6, 50),
('Chicken Legs',      'Cuisses de poulet',  'Meat', 'Fresh chicken leg quarters.',              18, 10.99, 6, 45),
('Ground Chicken',    'Poulet haché',       'Meat', 'Fresh lean ground chicken, per lb.',       22,  8.99, 8, 50);
