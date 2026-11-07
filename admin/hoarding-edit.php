<?php
require_once '../includes/config.php';
// require_once '../includes/functions.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$loc = [
    'id' => 0,
    'site_number' => '',
    'title' => '',
    'location' => '',
    'size' => '30X20',
    'price' => '',
    'price_note' => 'with ground rental, RDA charges, municipal council tax, digital printed flex',
    'image' => '',
    'description' => '',
    'sort_order' => 0,
    'is_active' => true
];

if ($id > 0) {
    $found = getHoardingById($id);
    if ($found) $loc = $found;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $site_number = trim($_POST['site_number'] ?? '');
    $title       = trim($_POST['title'] ?? '');
    $location    = trim($_POST['location'] ?? '');
    $size        = trim($_POST['size'] ?? '30X20');
    $price       = (float)str_replace([',', ' '], '', $_POST['price'] ?? 0);
    $price_note  = trim($_POST['price_note'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $sort_order  = (int)($_POST['sort_order'] ?? 0);
    $is_active   = isset($_POST['is_active']) ? true : false;
    $image       = $loc['image'] ?? '';

    // Image upload
    if (!empty($_FILES['image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array($ext, $allowed) && $_FILES['image']['size'] < 5 * 1024 * 1024) {
            $newName = 'hoarding_' . time() . '_' . rand(100,999) . '.' . $ext;
            $uploadDir = '../assets/uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $newName)) {
                $image = $newName;
            }
        } else {
            $error = 'Invalid image. Use JPG/PNG/WEBP under 5MB.';
        }
    }

    if (!$error && $title && $site_number) {
        $all = getHoardingLocations(false);

        if ($id > 0) {
            // Update existing
            foreach ($all as &$item) {
                if ((int)$item['id'] === $id) {
                    $item['site_number'] = $site_number;
                    $item['title']       = $title;
                    $item['location']    = $location;
                    $item['size']        = $size;
                    $item['price']       = $price;
                    $item['price_note']  = $price_note;
                    $item['image']       = $image;
                    $item['description'] = $description;
                    $item['sort_order']  = $sort_order;
                    $item['is_active']   = $is_active;
                    break;
                }
            }
        } else {
            // Add new
            $all[] = [
                'id'          => getNextHoardingId(),
                'site_number' => $site_number,
                'title'       => $title,
                'location'    => $location,
                'size'        => $size,
                'price'       => $price,
                'price_note'  => $price_note,
                'image'       => $image,
                'description' => $description,
                'sort_order'  => $sort_order,
                'is_active'   => $is_active
            ];
        }

        saveHoardingLocations($all);
        header('Location: hoarding.php?msg=saved');
        exit;
    } elseif (!$error) {
        $error = 'Site number and Title are required.';
    }

    // Keep posted values on error
    $loc = array_merge($loc, compact('site_number','title','location','size','price','price_note','image','description','sort_order','is_active'));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $id ? 'Edit' : 'Add'; ?> Hoarding Location | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Poppins', sans-serif; background: #050505; color: #fff; min-height: 100vh; }
        .admin-header { background: #121212; border-bottom: 1px solid #1f1f1f; padding: 16px 30px; display: flex; justify-content: space-between; align-items: center; }
        .admin-header h1 { font-size: 1.3rem; color: #f5b800; }
        .admin-header a { color: #888; text-decoration: none; margin-left: 20px; font-size: 0.9rem; }
        .admin-header a:hover { color: #f5b800; }
        .container { max-width: 700px; margin: 0 auto; padding: 30px 20px; }
        .form-card { background: #121212; border: 1px solid #1f1f1f; border-radius: 16px; padding: 32px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-size: 0.9rem; color: #aaa; }
        .form-group input, .form-group textarea {
            width: 100%; padding: 13px 16px; background: #0a0a0a; border: 1px solid #2a2a2a;
            border-radius: 10px; color: #fff; font-size: 0.95rem; font-family: inherit;
        }
        .form-group input:focus, .form-group textarea:focus { outline: none; border-color: #f5b800; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 0.95rem; border: none; cursor: pointer; transition: all 0.3s; }
        .btn-primary { background: linear-gradient(135deg, #f5b800, #d4a000); color: #111; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(245,184,0,0.35); }
        .btn-outline { background: transparent; border: 1px solid #333; color: #ccc; }
        .btn-outline:hover { border-color: #f5b800; color: #f5b800; }
        .error { background: rgba(230,57,70,0.15); border: 1px solid rgba(230,57,70,0.3); color: #ff8a80; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; }
        .preview-img { max-width: 200px; border-radius: 8px; margin-top: 10px; border: 1px solid #333; }
        .checkbox-label { display: flex; align-items: center; gap: 10px; cursor: pointer; color: #ccc; }
        .checkbox-label input { width: auto; }
        @media (max-width: 600px) { .form-row { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="admin-header">
        <h1><i class="fas fa-edit"></i> <?php echo $id ? 'Edit' : 'Add'; ?> Location</h1>
        <div>
            <a href="hoarding.php"><i class="fas fa-arrow-left"></i> Back to List</a>
            <a href="dashboard.php">Dashboard</a>
        </div>
    </div>

    <div class="container">
        <div class="form-card">
            <?php if ($error): ?>
                <div class="error"><i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group">
                        <label>Site Number *</label>
                        <input type="text" name="site_number" required value="<?php echo htmlspecialchars($loc['site_number']); ?>" placeholder="e.g. 01, 22">
                    </div>
                    <div class="form-group">
                        <label>Size</label>
                        <input type="text" name="size" value="<?php echo htmlspecialchars($loc['size']); ?>" placeholder="30X20">
                    </div>
                </div>

                <div class="form-group">
                    <label>Title *</label>
                    <input type="text" name="title" required value="<?php echo htmlspecialchars($loc['title']); ?>" placeholder="e.g. Polgahawela Town">
                </div>

                <div class="form-group">
                    <label>Location / Area</label>
                    <input type="text" name="location" value="<?php echo htmlspecialchars($loc['location'] ?? ''); ?>" placeholder="e.g. Polgahawela, Kurunegala">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Price (1 Year) Rs. *</label>
                        <input type="number" name="price" required step="1000" value="<?php echo htmlspecialchars($loc['price']); ?>" placeholder="475000">
                    </div>
                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" value="<?php echo (int)($loc['sort_order'] ?? 0); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Price Note</label>
                    <input type="text" name="price_note" value="<?php echo htmlspecialchars($loc['price_note'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label>Description (optional)</label>
                    <textarea name="description" rows="3"><?php echo htmlspecialchars($loc['description'] ?? ''); ?></textarea>
                </div>

                <div class="form-group">
                    <label>Site Image</label>
                    <input type="file" name="image" accept="image/*">
                    <?php if (!empty($loc['image'])): ?>
                        <img src="../assets/uploads/<?php echo htmlspecialchars($loc['image']); ?>" class="preview-img" alt="Current">
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="is_active" <?php echo !empty($loc['is_active']) ? 'checked' : ''; ?>>
                        Active (show on website)
                    </label>
                </div>

                <div style="display:flex; gap:12px; margin-top:10px;">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Location</button>
                    <a href="hoarding.php" class="btn btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>