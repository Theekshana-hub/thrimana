<?php
require_once 'auth_check.php';

// ========== HOARDING FUNCTIONS ==========
if (!function_exists('getHoardingLocations')) {
    function getHoardingLocations($limit = null, $activeOnly = true) {
        $defaultLocations = [
            ['id'=>1,'site_number'=>'01','title'=>'Polgahawela Town','location'=>'Polgahawela','size'=>'30X20','price'=>475000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>1,'is_active'=>1],
            ['id'=>2,'site_number'=>'04','title'=>'Kanthale, Agbopura 85 - Junction','location'=>'Kanthale / Agbopura','size'=>'30X20','price'=>550000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>2,'is_active'=>1],
            ['id'=>3,'site_number'=>'05','title'=>'Habarana Roundabout - Site 1','location'=>'Habarana','size'=>'30X20','price'=>750000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>3,'is_active'=>1],
            ['id'=>4,'site_number'=>'06','title'=>'Habarana - Site 2','location'=>'Habarana','size'=>'30X20','price'=>490000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>4,'is_active'=>1],
            ['id'=>5,'site_number'=>'07','title'=>'Sigiriya - Audangawa','location'=>'Sigiriya / Audangawa','size'=>'30X20','price'=>475000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>5,'is_active'=>1],
            ['id'=>6,'site_number'=>'08','title'=>'Trincomalee - Roundabout Site 1','location'=>'Trincomalee','size'=>'30X20','price'=>850000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>6,'is_active'=>1],
            ['id'=>7,'site_number'=>'09','title'=>'Trincomalee - Roundabout Site 2','location'=>'Trincomalee','size'=>'30X20','price'=>850000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>7,'is_active'=>1],
            ['id'=>8,'site_number'=>'11','title'=>'Morawaka, Nelumdeniya','location'=>'Morawaka / Nelumdeniya','size'=>'30X20','price'=>550000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>8,'is_active'=>1],
            ['id'=>9,'site_number'=>'13','title'=>'Anuradapura Jayanthi Mawath (Near Bikku University)','location'=>'Anuradhapura','size'=>'30X20','price'=>950000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>9,'is_active'=>1],
            ['id'=>10,'site_number'=>'14','title'=>'Kadawatha','location'=>'Kadawatha','size'=>'30X20','price'=>750000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>10,'is_active'=>1],
            ['id'=>11,'site_number'=>'15','title'=>'Wewaldeniya - Koragasmankada','location'=>'Wewaldeniya','size'=>'30X20','price'=>550000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>11,'is_active'=>1],
            ['id'=>12,'site_number'=>'17','title'=>'Kappalthurei - Trincomalee Road','location'=>'Kappalthurei','size'=>'30X20','price'=>550000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>12,'is_active'=>1],
            ['id'=>13,'site_number'=>'18','title'=>'Eheliyagoda Road, Minnana, Gataheththa','location'=>'Eheliyagoda / Minnana','size'=>'30X20','price'=>590000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>13,'is_active'=>1],
            ['id'=>14,'site_number'=>'21','title'=>'Bawilgamuwa, Pothuhera','location'=>'Bawilgamuwa / Pothuhera','size'=>'30X20','price'=>650000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>14,'is_active'=>1],
            ['id'=>15,'site_number'=>'22','title'=>'Near Peliyagoda Highway Exit','location'=>'Peliyagoda','size'=>'30X20','price'=>1500000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>15,'is_active'=>1],
            ['id'=>16,'site_number'=>'23','title'=>'Pasyala - Muruthawela','location'=>'Pasyala / Muruthawela','size'=>'30X20','price'=>475000,'price_note'=>'with ground rental, RDA charges, municipal council tax, digital printed flex','image'=>'','description'=>'','sort_order'=>16,'is_active'=>1],
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

if (!function_exists('saveHoardingLocations')) {
    function saveHoardingLocations($data) {
        $data = array_values($data);
        if (function_exists('writeJson')) {
            return writeJson('hoarding.json', $data);
        }
        $file = __DIR__ . '/../data/hoarding.json';
        return file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}

$success = '';
$error = '';

// Delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $all = getHoardingLocations(null, false);
    $all = array_filter($all, function($item) use ($id) {
        return (int)($item['id'] ?? 0) !== $id;
    });
    saveHoardingLocations($all);
    $success = 'Location deleted successfully.';
}

// Toggle
if (isset($_GET['toggle']) && is_numeric($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    $all = getHoardingLocations(null, false);
    foreach ($all as &$item) {
        if ((int)($item['id'] ?? 0) === $id) {
            $item['is_active'] = empty($item['is_active']) ? 1 : 0;
            break;
        }
    }
    unset($item);
    saveHoardingLocations($all);
    $success = 'Status updated.';
}

if (isset($_GET['msg']) && $_GET['msg'] === 'saved') {
    $success = 'Location saved successfully.';
}

$locations = getHoardingLocations(null, false);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoarding Locations | Thrimana Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
    <style>
        .hoarding-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .hoarding-table th, .hoarding-table td { padding: 12px 14px; text-align: left; border-bottom: 1px solid #222; vertical-align: middle; }
        .hoarding-table th { color: #f5b800; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.4px; }
        .hoarding-table td { color: #ccc; font-size: 0.9rem; }
        .hoarding-table tr:hover td { background: #161616; }
        .thumb {
            width: 70px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #333;
            background: #111;
        }
        .thumb-placeholder {
            width: 70px;
            height: 50px;
            border-radius: 6px;
            background: #1a1a1a;
            border: 1px solid #333;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #444;
            font-size: 1.2rem;
        }
        .badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-active { background: rgba(46,204,113,0.15); color: #2ecc71; }
        .badge-inactive { background: rgba(231,76,60,0.15); color: #e74c3c; }
        .price-col { color: #f5b800; font-weight: 600; white-space: nowrap; }
        .actions { display: flex; gap: 8px; flex-wrap: wrap; }
        .top-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
        @media (max-width: 768px) {
            .hoarding-table, .hoarding-table thead, .hoarding-table tbody, .hoarding-table th, .hoarding-table td, .hoarding-table tr { display: block; }
            .hoarding-table thead { display: none; }
            .hoarding-table tr { background: #151515; margin-bottom: 12px; border-radius: 10px; padding: 12px; border: 1px solid #222; }
            .hoarding-table td { border: none; padding: 6px 0; }
            .hoarding-table td:before { content: attr(data-label); font-weight: 600; color: #f5b800; display: block; font-size: 0.72rem; margin-bottom: 2px; }
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <?php include 'sidebar.php'; ?>
        <main class="admin-main">
            <header class="admin-header">
                <h1>Hoarding Locations</h1>
                <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </header>

            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert" style="background:rgba(230,57,70,0.15);border:1px solid rgba(230,57,70,0.3);color:#ff8a80;"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <div class="admin-card">
                <div class="top-actions">
                    <h2><i class="fas fa-ad"></i> All Sites (<?php echo count($locations); ?>)</h2>
                    <a href="hoarding-edit.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Location</a>
                </div>

                <?php if (empty($locations)): ?>
                    <p class="empty">No locations yet. Click "Add New Location" to create one.</p>
                <?php else: ?>
                <div style="overflow-x:auto;">
                    <table class="hoarding-table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Site #</th>
                                <th>Title</th>
                                <th>Location</th>
                                <th>Size</th>
                                <th>Price (1 Year)</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($locations as $loc): ?>
                            <tr>
                                <td data-label="Image">
                                    <?php if (!empty($loc['image'])): ?>
                                        <img src="../assets/uploads/<?php echo htmlspecialchars($loc['image']); ?>" 
                                             class="thumb" 
                                             alt=""
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="thumb-placeholder" style="display:none;"><i class="fas fa-image"></i></div>
                                    <?php else: ?>
                                        <div class="thumb-placeholder"><i class="fas fa-image"></i></div>
                                    <?php endif; ?>
                                </td>
                                <td data-label="Site #"><strong><?php echo htmlspecialchars($loc['site_number']); ?></strong></td>
                                <td data-label="Title"><?php echo htmlspecialchars($loc['title']); ?></td>
                                <td data-label="Location"><?php echo htmlspecialchars($loc['location'] ?? '-'); ?></td>
                                <td data-label="Size"><?php echo htmlspecialchars($loc['size'] ?? '30X20'); ?></td>
                                <td data-label="Price" class="price-col">Rs. <?php echo number_format((float)$loc['price'], 0); ?></td>
                                <td data-label="Status">
                                    <a href="?toggle=<?php echo (int)$loc['id']; ?>">
                                        <span class="badge <?php echo !empty($loc['is_active']) ? 'badge-active' : 'badge-inactive'; ?>">
                                            <?php echo !empty($loc['is_active']) ? 'Active' : 'Hidden'; ?>
                                        </span>
                                    </a>
                                </td>
                                <td data-label="Actions">
                                    <div class="actions">
                                        <a href="hoarding-edit.php?id=<?php echo (int)$loc['id']; ?>" class="btn btn-sm btn-outline"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="?delete=<?php echo (int)$loc['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this location?');"><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                                <td data-label="Availability">
    <?php 
    $st = strtolower($loc['status'] ?? 'available');
    if ($st === 'available'): ?>
        <span class="badge badge-active">Available</span>
    <?php else: ?>
        <span class="badge badge-inactive">Not Available</span>
    <?php endif; ?>
</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>