<?php
require_once 'auth_check.php';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    setContent('hero_title', trim($_POST['hero_title_title'] ?? ''), '');
    setContent('hero_subtitle', 'Ruhunu Iron Works', trim($_POST['hero_subtitle_body'] ?? ''));
    setContent('about_body', trim($_POST['about_body_title'] ?? ''), trim($_POST['about_body_body'] ?? ''));
    $success = 'Content updated successfully!';
}

$hero = getContent('hero_title');
$hero_sub = getContent('hero_subtitle');
$about = getContent('about_body');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Content | Thrimana Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="admin-layout">
        <?php include 'sidebar.php'; ?>
        <main class="admin-main">
            <header class="admin-header">
                <h1>Edit Website Content</h1>
                <div class="header-user">
                    <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </header>
            
            <?php if ($success): ?>
            <div class="alert alert-success"><i class="fas fa-check"></i> <?php echo $success; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="admin-card">
                    <h2><i class="fas fa-home"></i> Hero Section</h2>
                    <div class="form-group">
                        <label>Hero Main Title</label>
                        <input type="text" name="hero_title_title" value="<?php echo htmlspecialchars($hero['title']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Hero Subtitle / Tagline</label>
                        <textarea name="hero_subtitle_body" rows="3"><?php echo htmlspecialchars($hero_sub['body']); ?></textarea>
                    </div>
                </div>
                
                <div class="admin-card">
                    <h2><i class="fas fa-info-circle"></i> About Section</h2>
                    <div class="form-group">
                        <label>About Title</label>
                        <input type="text" name="about_body_title" value="<?php echo htmlspecialchars($about['title']); ?>">
                    </div>
                    <div class="form-group">
                        <label>About Content</label>
                        <textarea name="about_body_body" rows="12"><?php echo htmlspecialchars($about['body']); ?></textarea>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
            </form>
        </main>
    </div>
</body>
</html>
