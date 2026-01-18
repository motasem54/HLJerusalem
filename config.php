<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'hljerusalem');
define('DB_USER', 'root');
define('DB_PASS', '');

// Site Configuration
define('SITE_URL', 'http://localhost/hljerusalem');
define('SITE_NAME', 'H.L. Jerusalem Stone & Marble');
define('UPLOAD_PATH', __DIR__ . '/uploads/');

// Database Connection
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Session Start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>