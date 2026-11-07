<?php
require_once 'auth_check.php';

// ========== HOARDING FUNCTIONS ==========
if (!function_exists('getHoardingLocations')) {
    function getHoardingLocations($limit = null, $activeOnly = true) {
        $defaultLocations = [
            ['id'=>1,'site_number'=>'01','title'=>'Polgahawela Town','location'=>'Polgahawela','size'=>'30X20','price'=>475000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>1,'is_active'=>1,'status'=>'available'],
            ['id'=>2,'site_number'=>'04','title'=>'Kanthale, Agbopura 85 - Junction','location'=>'Kanthale / Agbopura','size'=>'30X20','price'=>550000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>2,'is_active'=>1,'status'=>'available'],
            ['id'=>3,'site_number'=>'05','title'=>'Habarana Roundabout - Site 1','location'=>'Habarana','size'=>'30X20','price'=>750000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>3,'is_active'=>1,'status'=>'available'],
            ['id'=>4,'site_number'=>'06','title'=>'Habarana - Site 2','location'=>'Habarana','size'=>'30X20','price'=>490000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>4,'is_active'=>1,'status'=>'available'],
            ['id'=>5,'site_number'=>'07','title'=>'Sigiriya - Audangawa','location'=>'Sigiriya / Audangawa','size'=>'30X20','price'=>475000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>5,'is_active'=>1,'status'=>'available'],
            ['id'=>6,'site_number'=>'08','title'=>'Trincomalee - Roundabout Site 1','location'=>'Trincomalee','size'=>'30X20','price'=>850000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>6,'is_active'=>1,'status'=>'available'],
            ['id'=>7,'site_number'=>'09','title'=>'Trincomalee - Roundabout Site 2','location'=>'Trincomalee','size'=>'30X20','price'=>850000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>7,'is_active'=>1,'status'=>'available'],
            ['id'=>8,'site_number'=>'11','title'=>'Morawaka, Nelumdeniya','location'=>'Morawaka / Nelumdeniya','size'=>'30X20','price'=>550000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>8,'is_active'=>1,'status'=>'available'],
            ['id'=>9,'site_number'=>'13','title'=>'Anuradapura Jayanthi Mawath (Near Bikku University)','location'=>'Anuradhapura','size'=>'30X20','price'=>950000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>9,'is_active'=>1,'status'=>'available'],
            ['id'=>10,'site_number'=>'14','title'=>'Kadawatha','location'=>'Kadawatha','size'=>'30X20','price'=>750000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>10,'is_active'=>1,'status'=>'available'],
            ['id'=>11,'site_number'=>'15','title'=>'Wewaldeniya - Koragasmankada','location'=>'Wewaldeniya','size'=>'30X20','price'=>550000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>11,'is_active'=>1,'status'=>'available'],
            ['id'=>12,'site_number'=>'17','title'=>'Kappalthurei - Trincomalee Road','location'=>'Kappalthurei','size'=>'30X20','price'=>550000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>12,'is_active'=>1,'status'=>'available'],
            ['id'=>13,'site_number'=>'18','title'=>'Eheliyagoda Road, Minnana, Gataheththa','location'=>'Eheliyagoda / Minnana','size'=>'30X20','price'=>590000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>13,'is_active'=>1,'status'=>'available'],
            ['id'=>14,'site_number'=>'21','title'=>'Bawilgamuwa, Pothuhera','location'=>'Bawilgamuwa / Pothuhera','size'=>'30X20','price'=>650000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>14,'is_active'=>1,'status'=>'available'],
            ['id'=>15,'site_number'=>'22','title'=>'Near Peliyagoda Highway Exit','location'=>'Peliyagoda','size'=>'30X20','price'=>1500000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>15,'is_active'=>1,'status'=>'available'],
            ['id'=>16,'site_number'=>'23','title'=>'Pasyala - Muruthawela','location'=>'Pasyala / Muruthawela','size'=>'30X20','price'=>475000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>16,'is_active'=>1,'status'=>'available'],
        ];

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
    'description' => '',
    'sort_order' => 0,
    'is_active' => 1,
    'status' => 'available'
];

if ($id > 0) {
    $found = getHoardingById($id);
    if ($found) $loc = $found;
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
    $image       = $loc['image'] ?? '';

    // Image upload
    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (in_array($ext, $allowed) && $_FILES['image']['size'] < 5 * 1024 * 1024) {
            $filename = 'hoarding_' . time() . '_' . rand(100, 999) . '.' . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename)) {
                $image = $filename;
            } else {
                $error = 'Failed to upload image.';
            }
        } else {
            $error = 'Invalid image. Use JPG/PNG/WEBP/GIF under 5MB.';
        }
    }

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

    // Keep posted values on error
    $loc = array_merge($loc, compact(
        'site_number', 'title', 'location', 'size', 'price',
        'price_note', 'image', 'description', 'sort_order', 'is_active', 'status'
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
        .preview-img { max-width: 180px; border-radius: 8px; margin-top: 10px; border: 1px solid #333; }
        .checkbox-label { display: flex; align-items: center; gap: 10px; cursor: pointer; color: #ccc; }
        .checkbox-label input { width: auto; }
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

                    <div style="display:flex; gap:12px; margin-top:10px; flex-wrap:wrap;">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Location</button>
                        <a href="hoarding.php" class="btn btn-outline">Cancel</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>