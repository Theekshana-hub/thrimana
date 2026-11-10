<?php
require_once 'auth_check.php';

$uploadDir = __DIR__ . '/../assets/uploads/';

// ===== Helper functions =====
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
        $defaults = [];
        foreach ($rows as $i => $r) {
            $defaults[] = [
                'id' => $i + 1, 'site_number' => $r[0], 'title' => $r[1], 'location' => $r[2],
                'size' => '30X20', 'price' => $r[3], 'price_note' => $note,
                'image' => '', 'image2' => '', 'description' => '',
                'sort_order' => $i + 1, 'is_active' => 1, 'status' => 'available',
            ];
        }

        $json = [];
        if (function_exists('readJson')) {
            $json = readJson('hoarding.json');
            if (!is_array($json)) $json = [];
        }
        $merged = !empty($json) ? $json : $defaults;

        if ($activeOnly) {
            $merged = array_values(array_filter($merged, function($i) { return !empty($i['is_active']); }));
        }
        usort($merged, function($a, $b) { return ($a['sort_order'] ?? 999) <=> ($b['sort_order'] ?? 999); });
        if ($limit) $merged = array_slice($merged, 0, $limit);
        return $merged;
    }
}

if (!function_exists('saveHoardingLocations')) {
    function saveHoardingLocations($data) {
        $data = array_values($data);
        if (function_exists('writeJson')) return writeJson('hoarding.json', $data);
        $file = __DIR__ . '/../data/hoarding.json';
        $dir = dirname($file);
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        return file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}

// ===== Actions =====
$msg = '';

// Delete
if (isset($_GET['delete'])) {
    $delId = (int)$_GET['delete'];
    $all = getHoardingLocations(null, false);
    $new = [];
    foreach ($all as $item) {
        if ((int)($item['id'] ?? 0) === $delId) {
            foreach (['image', 'image2'] as $f) {
                if (!empty($item[$f]) && file_exists($uploadDir . $item[$f])) @unlink($uploadDir . $item[$f]);
            }
            continue;
        }
        $new[] = $item;
    }
    saveHoardingLocations($new);
    header('Location: hoarding.php?msg=deleted');
    exit;
}

// Toggle availability
if (isset($_GET['toggle'])) {
    $tId = (int)$_GET['toggle'];
    $all = getHoardingLocations(null, false);
    foreach ($all as &$item) {
        if ((int)($item['id'] ?? 0) === $tId) {
            $item['status'] = (($item['status'] ?? 'available') === 'available') ? 'not_available' : 'available';
            break;
        }
    }
    unset($item);
    saveHoardingLocations($all);
    header('Location: hoarding.php?msg=updated');
    exit;
}

if (isset($_GET['msg'])) {
    $map = ['saved' => 'Location saved successfully.', 'deleted' => 'Location deleted.', 'updated' => 'Status updated.'];
    $msg = $map[$_GET['msg']] ?? '';
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
        .table-wrap { overflow-x: auto; }
        .h-table { width: 100%; border-collapse: collapse; min-width: 900px; }
        .h-table th, .h-table td { padding: 12px 10px; text-align: left; border-bottom: 1px solid #222; color: #ccc; font-size: 0.88rem; vertical-align: middle; }
        .h-table th { color: #f5c518; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.4px; }
        .thumbs { display: flex; gap: 6px; }
        .thumbs img, .thumbs .no-img {
            width: 54px; height: 40px; object-fit: cover;
            border-radius: 6px; border: 1px solid #333;
        }
        .thumbs .no-img { display: flex; align-items: center; justify-content: center; background: #111; color: #444; font-size: 0.7rem; }
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 700; display: inline-block; }
        .badge-ok { background: rgba(46,204,113,0.18); color: #2ecc71; }
        .badge-no { background: rgba(231,76,60,0.18); color: #e74c3c; }
        .badge-off { background: #2a2a2a; color: #888; }
        .actions { display: flex; gap: 6px; }
        .actions a {
            width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;
            border-radius: 6px; background: #1f1f1f; color: #ccc; text-decoration: none; transition: all .2s;
        }
        .actions a:hover { background: #f5c518; color: #111; }
        .actions a.del:hover { background: #e74c3c; color: #fff; }
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

            <?php if ($msg): ?>
                <div class="alert" style="background:rgba(46,204,113,0.15);border:1px solid rgba(46,204,113,0.3);color:#2ecc71;">
                    <?php echo htmlspecialchars($msg); ?>
                </div>
            <?php endif; ?>

            <div class="admin-card">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;flex-wrap:wrap;gap:10px;">
                    <h2 style="margin:0;"><i class="fas fa-ad"></i> All Locations (<?php echo count($locations); ?>)</h2>
                    <a href="hoarding-edit.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
                </div>

                <div class="table-wrap">
                    <table class="h-table">
                        <thead>
                            <tr>
                                <th>Site</th>
                                <th>Images</th>
                                <th>Title</th>
                                <th>Location</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Active</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($locations as $l):
                            $avail = (($l['status'] ?? 'available') === 'available');
                        ?>
                            <tr>
                                <td><strong>#<?php echo htmlspecialchars($l['site_number']); ?></strong></td>
                                <td>
                                    <div class="thumbs">
                                        <?php foreach (['image', 'image2'] as $f): ?>
                                            <?php if (!empty($l[$f])): ?>
                                                <img src="../assets/uploads/<?php echo htmlspecialchars($l[$f]); ?>" alt="">
                                            <?php else: ?>
                                                <div class="no-img">—</div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($l['title']); ?></td>
                                <td><?php echo htmlspecialchars($l['location'] ?? ''); ?></td>
                                <td>Rs. <?php echo number_format((float)$l['price']); ?></td>
                                <td>
                                    <span class="badge <?php echo $avail ? 'badge-ok' : 'badge-no'; ?>">
                                        <?php echo $avail ? 'Available' : 'Not Available'; ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?php echo !empty($l['is_active']) ? 'badge-ok' : 'badge-off'; ?>">
                                        <?php echo !empty($l['is_active']) ? 'Yes' : 'Hidden'; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="hoarding-edit.php?id=<?php echo (int)$l['id']; ?>" title="Edit"><i class="fas fa-edit"></i></a>
                                        <a href="hoarding.php?toggle=<?php echo (int)$l['id']; ?>" title="Toggle availability"><i class="fas fa-exchange-alt"></i></a>
                                        <a href="hoarding.php?delete=<?php echo (int)$l['id']; ?>" class="del" title="Delete" onclick="return confirm('Delete this location?');"><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>