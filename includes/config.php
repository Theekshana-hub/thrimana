<?php
// Configuration for Thrimana / Ruhunu Iron Works Website
define('SITE_NAME', 'Thrimana Advertising & Construction Services');
define('SITE_TAGLINE', 'Ruhunu Iron Works | Advertising | Construction');
define('SITE_URL', 'https://www.ruhunuironworks.site');
define('SITE_EMAIL', 'info@ruhunuironworks.site');
define('SITE_PHONE', '+94 77 123 4567');
define('SITE_ADDRESS', 'Ruhunu, Sri Lanka');

// Database
define('DB_PATH', __DIR__ . '/../data/site.db');

// Admin credentials (change after first login recommended)
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD_HASH', '$2y$10$s5vupTqNTpJQLixsivRLlOu.XrYcClqJDt2u26H3WApHY1J3Lgjtu'); // Password: Thrimana@2026

// Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Paths
define('BASE_PATH', dirname(__DIR__));
define('ASSETS_URL', 'assets');
?>
