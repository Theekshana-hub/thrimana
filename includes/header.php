<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' | ' : ''; ?><?php echo SITE_NAME; ?></title>
    <meta name="description" content="<?php echo isset($page_desc) ? $page_desc : 'Thrimana Advertising & Construction Services - Premium Iron Works, Signage and Construction in Sri Lanka'; ?>">
    <link rel="icon" type="image/png" href="<?php echo ASSETS_URL; ?>/images/logo.png">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Orbitron:wght@500;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/style.css">
</head>
<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="loader-content">
            <img src="<?php echo ASSETS_URL; ?>/images/logo.png" alt="Loading" class="loader-logo">
            <div class="loader-bar"><div class="loader-progress"></div></div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="container nav-container">
            <a href="index.php" class="logo">
                <img src="<?php echo ASSETS_URL; ?>/images/logo.png" alt="Thrimana Logo">
                <div class="logo-text">
                    <span class="logo-main">THRIMANA</span>
                    <span class="logo-sub">Iron Works & Advertising</span>
                </div>
            </a>
            
            <ul class="nav-menu" id="nav-menu">
<<<<<<< HEAD
                <li><a href="index.php" class="<?php echo $current_page == 'index' ? 'active' : ''; ?>">Home1</a></li>
=======
                <li><a href="index.php" class="<?php echo $current_page == 'index' ? 'active' : ''; ?>">Home</a></li>
>>>>>>> 310a586e08d98d2eb59b8fa89857d848f84dca62
                <li><a href="about.php" class="<?php echo $current_page == 'about' ? 'active' : ''; ?>">About</a></li>
                <li><a href="services.php" class="<?php echo $current_page == 'services' ? 'active' : ''; ?>">Services</a></li>
                <li><a href="gallery.php" class="<?php echo $current_page == 'gallery' ? 'active' : ''; ?>">Gallery</a></li>
                <li><a href="contact.php" class="<?php echo $current_page == 'contact' ? 'active' : ''; ?>">Contact</a></li>
            </ul>
            
            <div class="nav-actions">
                <a href="https://wa.me/<?php echo getSetting('whatsapp', '94771234567'); ?>" class="btn-whatsapp" target="_blank" title="WhatsApp">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <button class="hamburger" id="hamburger" aria-label="Menu">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </nav>
