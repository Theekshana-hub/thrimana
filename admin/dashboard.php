<?php
require_once 'auth_check.php';

$messages = getMessages();
$msgCount = count(array_filter($messages, function($m) { return empty($m['is_read']); }));
$galleryCount = count(getGallery());
$serviceCount = count(getServices(false));
$recentMessages = array_slice($messages, 0, 5);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Thrimana Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="admin-layout">
        <?php include 'sidebar.php'; ?>
        
        <main class="admin-main">
            <header class="admin-header">
                <h1>Dashboard</h1>
                <div class="header-user">
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                    <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </header>
            
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-icon" style="background:rgba(245,184,0,0.15);color:#f5b800;"><i class="fas fa-envelope"></i></div>
                    <div>
                        <h3><?php echo $msgCount; ?></h3>
                        <p>Unread Messages</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:rgba(0,200,83,0.15);color:#00c853;"><i class="fas fa-images"></i></div>
                    <div>
                        <h3><?php echo $galleryCount; ?></h3>
                        <p>Gallery Items</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:rgba(33,150,243,0.15);color:#2196f3;"><i class="fas fa-briefcase"></i></div>
                    <div>
                        <h3><?php echo $serviceCount; ?></h3>
                        <p>Services</p>
                    </div>
                </div>
            </div>
            
            <div class="admin-card">
                <h2><i class="fas fa-inbox"></i> Recent Messages</h2>
                <?php if (empty($recentMessages)): ?>
                <p class="empty">No messages yet.</p>
                <?php else: ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentMessages as $m): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($m['name']); ?></td>
                            <td><?php echo htmlspecialchars($m['email']); ?></td>
                            <td><?php echo htmlspecialchars($m['subject'] ?: '-'); ?></td>
                            <td><?php echo date('M d, Y', strtotime($m['created_at'])); ?></td>
                            <td>
                                <?php if (!empty($m['is_read'])): ?>
                                <span class="badge badge-read">Read</span>
                                <?php else: ?>
                                <span class="badge badge-new">New</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="messages.php" class="btn-link">View All Messages →</a>
                <?php endif; ?>
            </div>
            
            <div class="quick-links">
                <a href="edit_content.php" class="quick-card"><i class="fas fa-edit"></i> Edit Website Content</a>
                <a href="manage_services.php" class="quick-card"><i class="fas fa-cogs"></i> Manage Services</a>
                <a href="manage_gallery.php" class="quick-card"><i class="fas fa-images"></i> Manage Gallery</a>
                <a href="settings.php" class="quick-card"><i class="fas fa-sliders-h"></i> Site Settings</a>
            </div>
        </main>
    </div>
</body>
</html>
