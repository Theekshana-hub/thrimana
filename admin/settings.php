<?php
require_once 'auth_check.php';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keys = ['phone', 'email', 'address', 'facebook', 'instagram', 'whatsapp', 'site_name'];
    foreach ($keys as $k) {
        setSetting($k, trim($_POST[$k] ?? ''));
    }
    $success = 'Settings saved successfully!';
}

function s($key, $default = '') {
    return htmlspecialchars(getSetting($key, $default));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings | Thrimana Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="admin-layout">
        <?php include 'sidebar.php'; ?>
        <main class="admin-main">
            <header class="admin-header">
                <h1>Site Settings</h1>
                <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </header>
            
            <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
            
            <form method="POST">
                <div class="admin-card">
                    <h2><i class="fas fa-phone"></i> Contact Information</h2>
                    <div class="form-group">
                        <label>Site Name</label>
                        <input type="text" name="site_name" value="<?php echo s('site_name', SITE_NAME); ?>">
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" value="<?php echo s('phone', SITE_PHONE); ?>">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo s('email', SITE_EMAIL); ?>">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" value="<?php echo s('address', SITE_ADDRESS); ?>">
                    </div>
                </div>
                
                <div class="admin-card">
                    <h2><i class="fas fa-share-alt"></i> Social Media</h2>
                    <div class="form-group">
                        <label>WhatsApp Number (with country code, no +)</label>
                        <input type="text" name="whatsapp" value="<?php echo s('whatsapp', '94771234567'); ?>" placeholder="94771234567">
                    </div>
                    <div class="form-group">
                        <label>Facebook URL</label>
                        <input type="url" name="facebook" value="<?php echo s('facebook'); ?>">
                    </div>
                    <div class="form-group">
                        <label>Instagram URL</label>
                        <input type="url" name="instagram" value="<?php echo s('instagram'); ?>">
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Settings</button>
            </form>
            
            <div class="admin-card" style="margin-top:30px;">
                <h2><i class="fas fa-key"></i> Admin Login Credentials</h2>
                <p style="color:#888;margin-bottom:12px;">Current username: <strong>admin</strong></p>
                <p style="color:#888;">Password: <strong>Thrimana@2026</strong></p>
                <p style="color:#666;font-size:0.85rem;margin-top:10px;">To change password, edit the ADMIN_PASSWORD_HASH in includes/config.php</p>
            </div>
        </main>
    </div>
</body>
</html>
