<aside class="admin-sidebar">
    <div class="sidebar-brand">
        <img src="../assets/images/logo.png" alt="Logo">
        <span>THRIMANA</span>
    </div>
    <nav class="sidebar-nav">
        <a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="edit_content.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'edit_content.php' ? 'active' : ''; ?>">
            <i class="fas fa-edit"></i> Edit Content
        </a>
        <a href="manage_services.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'manage_services.php' ? 'active' : ''; ?>">
            <i class="fas fa-briefcase"></i> Services
        </a>
        <a href="manage_gallery.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'manage_gallery.php' ? 'active' : ''; ?>">
            <i class="fas fa-images"></i> Gallery
        </a>
        <a href="messages.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'messages.php' ? 'active' : ''; ?>">
            <i class="fas fa-envelope"></i> Messages
        </a>
        <a href="settings.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : ''; ?>">
            <i class="fas fa-cog"></i> Settings
        </a>
        <a href="../index.php" target="_blank">
            <i class="fas fa-external-link-alt"></i> View Website
        </a>
        <a href="logout.php" class="logout-link">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </nav>
</aside>
