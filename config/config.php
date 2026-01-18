<?php
/**
 * Main Configuration File
 * H.L. Jerusalem Stone & Marble
 */

session_start();

// Base URL Configuration
define('BASE_URL', 'http://localhost/HLJerusalem');
define('ADMIN_URL', BASE_URL . '/admin');

// Directory Paths
define('ROOT_PATH', dirname(__DIR__));
define('UPLOAD_PATH', ROOT_PATH . '/uploads');
define('UPLOAD_URL', BASE_URL . '/uploads');

// Upload Directories
define('PRODUCTS_UPLOAD_PATH', UPLOAD_PATH . '/products');
define('PROJECTS_UPLOAD_PATH', UPLOAD_PATH . '/projects');
define('CATEGORIES_UPLOAD_PATH', UPLOAD_PATH . '/categories');

// Site Settings
define('SITE_NAME', 'H.L. Jerusalem Stone & Marble');
define('SITE_DESCRIPTION', 'Premium Natural Stone & Marble Since 1979');
define('DEFAULT_LANGUAGE', 'en');

// Pagination
define('ITEMS_PER_PAGE', 12);
define('ADMIN_ITEMS_PER_PAGE', 20);

// Image Settings
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/webp']);
define('THUMBNAIL_WIDTH', 400);
define('THUMBNAIL_HEIGHT', 400);

// Security
define('SESSION_LIFETIME', 3600); // 1 hour
define('REMEMBER_ME_LIFETIME', 2592000); // 30 days

// Email Configuration (for contact form)
define('ADMIN_EMAIL', 'info@palstone.com');
define('SMTP_HOST', 'localhost');
define('SMTP_PORT', 25);

// Timezone
date_default_timezone_set('Asia/Hebron');

// Error Reporting (Development)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include database config
require_once __DIR__ . '/database.php';

// Helper Functions
function redirect($url) {
    header("Location: $url");
    exit;
}

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

function generateSlug($string) {
    $string = strtolower($string);
    $string = preg_replace('/[^a-z0-9-]/', '-', $string);
    $string = preg_replace('/-+/', '-', $string);
    return trim($string, '-');
}

function uploadImage($file, $directory, $prefix = '') {
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }
    
    if ($file['size'] > MAX_UPLOAD_SIZE) {
        return false;
    }
    
    if (!in_array($file['type'], ALLOWED_IMAGE_TYPES)) {
        return false;
    }
    
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = $prefix . uniqid() . '.' . $extension;
    $filepath = $directory . '/' . $filename;
    
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }
    
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return $filename;
    }
    
    return false;
}

function deleteImage($filepath) {
    if (file_exists($filepath)) {
        return unlink($filepath);
    }
    return false;
}