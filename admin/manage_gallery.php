<?php
require_once 'auth_check.php';
$success = '';
$error = '';
$uploadDir = __DIR__ . '/../assets/uploads/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'upload') {
        $title = trim($_POST['title'] ?? '');
        $category = trim($_POST['category'] ?? 'general');
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            
            if (in_array($ext, $allowed)) {
                $filename = 'gallery_' . time() . '_' . rand(100,999) . '.' . $ext;
                $dest = $uploadDir . $filename;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
                    $all = readJson('gallery.json');
                    $maxId = 0;
                    foreach ($all as $g) { if (($g['id'] ?? 0) > $maxId) $maxId = $g['id']; }
                    $all[] = [
                        'id' => $maxId + 1,
                        'title' => $title,
                        'category' => $category,
                        'image_path' => $filename,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    writeJson('gallery.json', $all);
                    $success = 'Image uploaded successfully!';
                } else {
                    $error = 'Failed to move uploaded file.';
                }
            } else {
                $error = 'Invalid file type. Allowed: jpg, png, webp, gif';
            }
        } else {
            $error = 'Please select an image to upload.';
        }
    }
    
    if ($action === 'delete') {
        $id = (int)$_POST['id'];
        $all = readJson('gallery.json');
        foreach ($all as $i => $item) {
            if ($item['id'] == $id) {
                $file = $uploadDir . $item['image_path'];
                if (file_exists($file)) unlink($file);
                unset($all[$i]);
                break;
            }
        }
        writeJson('gallery.json', array_values($all));
        $success = 'Image deleted.';
    }
}

$gallery = getGallery();

// Load active services to use as categories
$services = readJson('services.json');
usort($services, function($a, $b) {
    return ($a['sort_order'] ?? 0) <=> ($b['sort_order'] ?? 0);
});

// Keep only active services
$activeServices = array_filter($services, function($s) {
    return !empty($s['is_active']);
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gallery | Thrimana Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="admin-layout">
        <?php include 'sidebar.php'; ?>
        <main class="admin-main">
            <header class="admin-header">
                <h1>Manage Gallery</h1>
                <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </header>
            
            <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
            <?php if ($error): ?><div class="alert" style="background:rgba(230,57,70,0.15);border:1px solid rgba(230,57,70,0.3);color:#ff8a80;"><?php echo $error; ?></div><?php endif; ?>
            
            <div class="admin-card">
                <h2><i class="fas fa-upload"></i> Upload New Image</h2>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="upload">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" placeholder="e.g. Custom Iron Gate">
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select name="category" required>
                            <?php if (empty($activeServices)): ?>
                                <option value="general">General</option>
                            <?php else: ?>
                                <?php foreach ($activeServices as $service): 
                                    // Create a clean slug from the service title
                                    $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $service['title']), '-'));
                                ?>
                                    <option value="<?php echo htmlspecialchars($slug); ?>">
                                        <?php echo htmlspecialchars($service['title']); ?>
                                    </option>
                                <?php endforeach; ?>
                                <option value="general">General</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Image File</label>
                        <input type="file" name="image" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-cloud-upload-alt"></i> Upload</button>
                </form>
            </div>
            
            <div class="admin-card">
                <h2>Gallery Images (<?php echo count($gallery); ?>)</h2>
                <?php if (empty($gallery)): ?>
                <p class="empty">No images yet. Upload your project photos above.</p>
                <?php else: ?>
                <div class="gallery-admin-grid">
                    <?php foreach ($gallery as $item): ?>
                    <div class="gallery-admin-item">
                        <img src="../assets/uploads/<?php echo htmlspecialchars($item['image_path']); ?>" alt="" onerror="this.src='../assets/images/logo.png'">
                        <div class="info">
                            <strong><?php echo htmlspecialchars($item['title'] ?: 'Untitled'); ?></strong><br>
                            <small style="color:#888;"><?php echo htmlspecialchars($item['category']); ?></small>
                        </div>
                        <div class="actions">
                            <form method="POST" onsubmit="return confirm('Delete this image?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>