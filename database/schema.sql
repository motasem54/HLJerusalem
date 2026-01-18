-- H.L. Jerusalem Stone & Marble Database Schema
-- Created: 2026-01-18

CREATE DATABASE IF NOT EXISTS hljerusalem CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE hljerusalem;

-- Admin Users Table
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    full_name VARCHAR(100),
    role ENUM('superadmin', 'admin', 'editor') DEFAULT 'admin',
    is_active TINYINT(1) DEFAULT 1,
    last_login DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Categories Table (أقسام الرخام والحجر)
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name_en VARCHAR(100) NOT NULL,
    name_ar VARCHAR(100),
    slug VARCHAR(100) UNIQUE NOT NULL,
    description_en TEXT,
    description_ar TEXT,
    image VARCHAR(255),
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_active (is_active)
) ENGINE=InnoDB;

-- Products Table (الأصناف والمنتجات)
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name_en VARCHAR(150) NOT NULL,
    name_ar VARCHAR(150),
    slug VARCHAR(150) UNIQUE NOT NULL,
    description_en TEXT,
    description_ar TEXT,
    product_type ENUM('block', 'slab', 'tile', 'cut_to_size') NOT NULL,
    color VARCHAR(50),
    main_image VARCHAR(255),
    specifications JSON,
    is_featured TINYINT(1) DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    display_order INT DEFAULT 0,
    views_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    INDEX idx_category (category_id),
    INDEX idx_type (product_type),
    INDEX idx_featured (is_featured),
    INDEX idx_active (is_active)
) ENGINE=InnoDB;

-- Product Images Gallery
CREATE TABLE IF NOT EXISTS product_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    title VARCHAR(100),
    display_order INT DEFAULT 0,
    is_primary TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_product (product_id)
) ENGINE=InnoDB;

-- Projects Table
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title_en VARCHAR(200) NOT NULL,
    title_ar VARCHAR(200),
    slug VARCHAR(200) UNIQUE NOT NULL,
    description_en TEXT,
    description_ar TEXT,
    location VARCHAR(150),
    country VARCHAR(50),
    project_date DATE,
    main_image VARCHAR(255),
    is_featured TINYINT(1) DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_featured (is_featured),
    INDEX idx_active (is_active)
) ENGINE=InnoDB;

-- Project Images
CREATE TABLE IF NOT EXISTS project_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    caption VARCHAR(200),
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    INDEX idx_project (project_id)
) ENGINE=InnoDB;

-- Company Information
CREATE TABLE IF NOT EXISTS company_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    field_name VARCHAR(50) UNIQUE NOT NULL,
    field_value_en TEXT,
    field_value_ar TEXT,
    field_type ENUM('text', 'textarea', 'email', 'phone', 'url') DEFAULT 'text',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Contact Messages
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(50),
    subject VARCHAR(200),
    message TEXT NOT NULL,
    ip_address VARCHAR(45),
    is_read TINYINT(1) DEFAULT 0,
    replied TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_read (is_read),
    INDEX idx_created (created_at)
) ENGINE=InnoDB;

-- Site Settings
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(50) UNIQUE NOT NULL,
    setting_value TEXT,
    setting_type VARCHAR(20) DEFAULT 'text',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Activity Log
CREATE TABLE IF NOT EXISTS activity_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT,
    action VARCHAR(100) NOT NULL,
    table_name VARCHAR(50),
    record_id INT,
    details TEXT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES admin_users(id) ON DELETE SET NULL,
    INDEX idx_admin (admin_id),
    INDEX idx_created (created_at)
) ENGINE=InnoDB;

-- Insert Default Admin User (password: admin123 - should be changed)
INSERT INTO admin_users (username, password, email, full_name, role) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@hljerusalem.com', 'Administrator', 'superadmin');

-- Insert Default Categories
INSERT INTO categories (name_en, name_ar, slug, description_en, display_order, is_active) VALUES 
('Jerusalem Gold Stone', 'حجر القدس الذهبي', 'jerusalem-gold-stone', 'Premium Jerusalem gold stone from our quarries', 1, 1),
('Marble', 'رخام', 'marble', 'High-quality marble products', 2, 1),
('Granite', 'جرانيت', 'granite', 'Durable granite stone', 3, 1),
('Limestone', 'حجر جيري', 'limestone', 'Natural limestone products', 4, 1);

-- Insert Company Information
INSERT INTO company_info (field_name, field_value_en, field_type) VALUES 
('company_name', 'H.L. Jerusalem Stone & Marble Company', 'text'),
('address', 'Ein Sarah St. Hebron, Palestine', 'text'),
('email', 'info@palstone.com', 'email'),
('phone', '+970 2 2291403', 'phone'),
('fax', '+970 2 2253133', 'phone'),
('general_manager', 'Mr. Fahed Ghaith: 00970-599373163', 'text'),
('director_manager', 'Mr. Nimer Ghaith: 00972-598881778', 'text'),
('marketing_manager', 'Miss. Ola Ghaith: 00970-595188753', 'text');

-- Insert Default Settings
INSERT INTO settings (setting_key, setting_value, setting_type) VALUES 
('site_title', 'H.L. Jerusalem Stone & Marble', 'text'),
('site_description', 'Premium Natural Stone & Marble Since 1979', 'text'),
('items_per_page', '12', 'text'),
('enable_contact_form', '1', 'text'),
('maintenance_mode', '0', 'text');