<?php
require_once 'auth_check.php';

// ========== HOARDING FUNCTIONS ==========
if (!function_exists('getHoardingLocations')) {
    function getHoardingLocations($limit = null, $activeOnly = true) {
        $note = 'with ground rental, RDA charges, municipal council tax, digital printed flex';
        $rows = [
            ['01','Polgahawela Town','Polgahawela',475000],
            ['04','Kanthale, Agbopura 85 - Junction','Kanthale / Agbopura',550000],
            ['05','Habarana Roundabout - Site 1','Habarana',750000],
            ['06','Habarana - Site 2','Habarana',490000],
            ['07','Sigiriya - Audangawa','Sigiriya / Audangawa',475000],
            ['08','Trincomalee - Roundabout Site 1','Trincomalee',850000],
            ['09','Trincomalee - Roundabout Site 2','Trincomalee',850000],
            ['11','Morawaka, Nelumdeniya','Morawaka / Nelumdeniya',550000],
            ['13','Anuradapura Jayanthi Mawath (Near Bikku University)','Anuradhapura',950000],
            ['14','Kadawatha','Kadawatha',750000],
            ['15','Wewaldeniya - Koragasmankada','Wewaldeniya',550000],
            ['17','Kappalthurei - Trincomalee Road','Kappalthurei',550000],
            ['18','Eheliyagoda Road, Minnana, Gataheththa','Eheliyagoda / Minnana',590000],
            ['21','Bawilgamuwa, Pothuhera','Bawilgamuwa / Pothuhera',650000],
            ['22','Near Peliyagoda Highway Exit','Peliyagoda',1500000],
            ['23','Pasyala - Muruthawela','Pasyala / Muruthawela',475000],
        ];

        $defaultLocations = [];
        foreach ($rows as $i => $r) {
            $defaultLocations[] = [
                'id' => $i + 1, 'site_number' => $r[0], 'title' => $r[1], 'location' => $r[2],
                'size' => '30X20', 'price' => $r[3], 'price_note' => $note,
                'image' => '', 'image2' => '',
                'description' => '', 'sort_order' => $i + 1, 'is_active' => 1, 'status' => 'available',
            ];
        }

        $jsonLocations = [];
        if (function_exists('readJson')) {
            $jsonLocations = readJson('hoarding.json');
            if (!is_array($jsonLocations)) $jsonLocations = [];
        }

        $merged = !empty($jsonLocations) ? $jsonLocations : $defaultLocations;

        if ($activeOnly) {
            $merged = array_values(array_filter($merged, function($item) {
                return !empty($item['is_active']);
            }));
        }

        usort($merged, function($a, $b) {
            return ($a['sort_order'] ?? 999) <=> ($b['sort_order'] ?? 999);
        });

        if ($limit) {
            $merged = array_slice($merged, 0, $limit);
        }

        return $merged;
    }
}

if (!function_exists('getHoardingById')) {
    function getHoardingById($id) {
        $all = getHoardingLocations(null, false);
        foreach ($all as $item) {
            if ((int)($item['id'] ?? 0) === (int)$id) return $item;
        }
        return null;
    }
}

if (!function_exists('saveHoardingLocations')) {
    function saveHoardingLocations($data) {
        $data = array_values($data);
        if (function_exists('writeJson')) {
            return writeJson('hoarding.json', $data);
        }
        $file = __DIR__ . '/../data/hoarding.json';
        $dir = dirname($file);
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        return file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}

if (!function_exists('getNextHoardingId')) {
    function getNextHoardingId() {
        $all = getHoardingLocations(null, false);
        $max = 0;
        foreach ($all as $item) {
            $id = (int)($item['id'] ?? 0);
            if ($id > $max) $max = $id;
        }
        return $max + 1;
    }
}

// ========== IMAGE UPLOAD HELPER ==========
/**
 * Image eka upload karanawa.
 * Return: ['file' => filename, 'error' => message]
 */
function handleHoardingImage($field, $oldValue, $removeFlag, $uploadDir) {
    $result = ['file' => $oldValue, 'error' => ''];

    // Remove checkbox tick karala nam
    if ($removeFlag && $oldValue) {
        if (file_exists($uploadDir . $oldValue)) @unlink($uploadDir . $oldValue);
        $result['file'] = '';
    }

    // Aluth file ekak upload karala nam
    if (!empty($_FILES[$field]['name']) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

        if (!in_array($ext, $allowed) || $_FILES[$field]['size'] > 5 * 1024 * 1024) {
            $result['error'] = 'Invalid image. Use JPG/PNG/WEBP/GIF under 5MB.';
            return $result;
        }

        $filename = 'hoarding_' . $field . '_' . time() . '_' . mt_rand(100, 999) . '.' . $ext;
        if (move_uploaded_file($_FILES[$field]['tmp_name'], $uploadDir . $filename)) {
            // Parana image eka delete karanawa
            $prev = $result['file'] ?: $oldValue;
            if ($prev && file_exists($uploadDir . $prev)) @unlink($uploadDir . $prev);
            $result['file'] = $filename;
        } else {
            $result['error'] = 'Failed to upload image.';
        }
    }

    return $result;
}

$success = '';
$error = '';
$uploadDir = __DIR__ . '/../assets/uploads/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

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
    'image2' => '',
    'description' => '',
    'sort_order' => 0,
    'is_active' => 1,
    'status' => 'available'
];

if ($id > 0) {
    $found = getHoardingById($id);
    if ($found) $loc = array_merge($loc, $found);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $site_number = trim($_POST['site_number'] ?? '');
    $title       = trim($_POST['title'] ?? '');
    $location    = trim($_POST['location'] ?? '');
    $size        = trim($_POST['size'] ?? '30X20');
    $price       = (float)str_replace([',', ' '], '', $_POST['price'] ?? 0);
    $price_note  = trim($_POST['price_note'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $sort_order  = (int)($_POST['sort_order'] ?? 0);
    $is_active   = isset($_POST['is_active']) ? 1 : 0;
    $status      = ($_POST['status'] ?? 'available') === 'not_available' ? 'not_available' : 'available';

    $oldImage  = $loc['image']  ?? '';
    $oldImage2 = $loc['image2'] ?? '';
    $image  = $oldImage;
    $image2 = $oldImage2;

    // Board image
    $r1 = handleHoardingImage('image', $oldImage, !empty($_POST['remove_image']), $uploadDir);
    $image = $r1['file'];
    if ($r1['error']) $error = 'Board image: ' . $r1['error'];

    // Location image
    $r2 = handleHoardingImage('image2', $oldImage2, !empty($_POST['remove_image2']), $uploadDir);
    $image2 = $r2['file'];
    if ($r2['error'] && !$error) $error = 'Location image: ' . $r2['error'];

    if (!$error && $title && $site_number) {
        $all = getHoardingLocations(null, false);

        if ($id > 0) {
            // Update existing
            foreach ($all as &$item) {
                if ((int)($item['id'] ?? 0) === $id) {
                    $item['site_number'] = $site_number;
                    $item['title']       = $title;
                    $item['location']    = $location;
                    $item['size']        = $size;
                    $item['price']       = $price;
                    $item['price_note']  = $price_note;
                    $item['image']       = $image;
                    $item['image2']      = $image2;
                    $item['description'] = $description;
                    $item['sort_order']  = $sort_order;
                    $item['is_active']   = $is_active;
                    $item['status']      = $status;
                    break;
                }
            }
            unset($item);
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
                'image2'      => $image2,
                'description' => $description,
                'sort_order'  => $sort_order,
                'is_active'   => $is_active,
                'status'      => $status
            ];
        }

        saveHoardingLocations($all);
        header('Location: hoarding.php?msg=saved');
        exit;
    } elseif (!$error) {
        $error = 'Site number and Title are required.';
    }

    // Error ekak awoth posted values rakinna
    $loc = array_merge($loc, compact(
        'site_number', 'title', 'location', 'size', 'price',
        'price_note', 'image', 'image2', 'description', 'sort_order', 'is_active', 'status'
    ));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $id ? 'Edit' : 'Add'; ?> Hoarding Location | Thrimana Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
    <style>
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .checkbox-label { display: flex; align-items: center; gap: 10px; cursor: pointer; color: #ccc; }
        .checkbox-label input { width: auto; }

        .image-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .image-box {
            background: #0d0d0d;
            border: 1px solid #2a2a2a;
            border-radius: 12px;
            padding: 16px;
        }
        .image-box h4 {
            margin: 0 0 4px 0;
            color: #f5c518;
            font-size: 0.95rem;
            display: flex; align-items: center; gap: 8px;
        }
        .image-box .hint { color: #777; font-size: 0.78rem; margin: 0 0 12px 0; }
        .image-box input[type="file"] { width: 100%; }
        .preview-img {
            display: block;
            width: 100%;
            max-height: 170px;
            object-fit: cover;
            border-radius: 8px;
            margin-top: 12px;
            border: 1px solid #333;
        }
        .preview-empty {
            margin-top: 12px;
            height: 110px;
            border: 1px dashed #333;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #555; font-size: 0.82rem;
        }
        .remove-check {
            margin-top: 10px;
            display: flex; align-items: center; gap: 8px;
            color: #ff8a80; font-size: 0.82rem; cursor: pointer;
        }
        .remove-check input { width: auto; }

        @media (max-width: 700px) { .image-grid { grid-template-columns: 1fr; } }
        @media (max-width: 600px) { .form-row { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="admin-layout">
        <?php include 'sidebar.php'; ?>
        <main class="admin-main">
            <header class="admin-header">
                <h1><?php echo $id ? 'Edit' : 'Add'; ?> Hoarding Location</h1>
                <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </header>

            <?php if ($error): ?>
                <div class="alert" style="background:rgba(230,57,70,0.15);border:1px solid rgba(230,57,70,0.3);color:#ff8a80;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <div class="admin-card">
                <h2><i class="fas fa-<?php echo $id ? 'edit' : 'plus'; ?>"></i> <?php echo $id ? 'Edit Location' : 'New Location'; ?></h2>

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
                        <input type="text" name="location" value="<?php echo htmlspecialchars($loc['location'] ?? ''); ?>" placeholder="e.g. Polgahawela">
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
                        <label>Availability Status *</label>
                        <select name="status" required>
                            <option value="available" <?php echo (($loc['status'] ?? 'available') === 'available') ? 'selected' : ''; ?>>Available</option>
                            <option value="not_available" <?php echo (($loc['status'] ?? '') === 'not_available') ? 'selected' : ''; ?>>Not Available</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Price Note</label>
                        <input type="text" name="price_note" value="<?php echo htmlspecialchars($loc['price_note'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label>Description (optional)</label>
                        <textarea name="description" rows="3"><?php echo htmlspecialchars($loc['description'] ?? ''); ?></textarea>
                    </div>

                    <!-- ===== IMAGES (2) ===== -->
                    <label style="display:block;margin-bottom:10px;">Images</label>
                    <div class="image-grid">

                        <!-- Board Image -->
                        <div class="image-box">
                            <h4><i class="fas fa-ad"></i> Board Image</h4>
                            <p class="hint">Hoarding / billboard eke photo eka</p>
                            <input type="file" name="image" accept="image/*" onchange="previewImg(this, 'prev1')">
                            <?php if (!empty($loc['image'])): ?>
                                <img id="prev1" src="../assets/uploads/<?php echo htmlspecialchars($loc['image']); ?>" class="preview-img" alt="Board">
                                <label class="remove-check">
                                    <input type="checkbox" name="remove_image" value="1"> Remove this image
                                </label>
                            <?php else: ?>
                                <img id="prev1" class="preview-img" style="display:none;" alt="Board">
                                <div class="preview-empty" id="empty1">No image</div>
                            <?php endif; ?>
                        </div>

                        <!-- Location Image -->
                        <div class="image-box">
                            <h4><i class="fas fa-map-marker-alt"></i> Location Image</h4>
                            <p class="hint">Thaena / road / junction eke photo eka</p>
                            <input type="file" name="image2" accept="image/*" onchange="previewImg(this, 'prev2')">
                            <?php if (!empty($loc['image2'])): ?>
                                <img id="prev2" src="../assets/uploads/<?php echo htmlspecialchars($loc['image2']); ?>" class="preview-img" alt="Location">
                                <label class="remove-check">
                                    <input type="checkbox" name="remove_image2" value="1"> Remove this image
                                </label>
                            <?php else: ?>
                                <img id="prev2" class="preview-img" style="display:none;" alt="Location">
                                <div class="preview-empty" id="empty2">No image</div>
                            <?php endif; ?>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="is_active" <?php echo !empty($loc['is_active']) ? 'checked' : ''; ?>>
                            Active (show on website)
                        </label>
                    </div>

                    <div style="display:flex; gap:12px; margin-top:10px; flex-wrap:wrap;">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Location</button>
                        <a href="hoarding.php" class="btn btn-outline">Cancel</a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
    // File select karanakota live preview ekak penawa
    function previewImg(input, imgId) {
        var img = document.getElementById(imgId);
        var emptyBox = document.getElementById(imgId === 'prev1' ? 'empty1' : 'empty2');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                img.src = e.target.result;
                img.style.display = 'block';
                if (emptyBox) emptyBox.style.display = 'none';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
</body>
</html>