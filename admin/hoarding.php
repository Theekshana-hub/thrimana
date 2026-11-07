<?php
require_once '../includes/config.php';

// Load functions if available
if (file_exists('../includes/functions.php')) {
    require_once '../includes/functions.php';
}

// ========== HOARDING FUNCTIONS (fallback if not in functions.php) ==========
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
        $jsonFile = __DIR__ . '/../data/hoarding.json';

        if (function_exists('readJson')) {
            $jsonLocations = readJson('hoarding.json');
            if (!is_array($jsonLocations)) $jsonLocations = [];
        } elseif (file_exists($jsonFile)) {
            $jsonLocations = json_decode(file_get_contents($jsonFile), true);
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

// Auth check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

// Delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $all = getHoardingLocations(null, false);
    $all = array_filter($all, function($item) use ($id) {
        return (int)($item['id'] ?? 0) !== $id;
    });
    saveHoardingLocations($all);
    header('Location: hoarding.php?msg=deleted');
    exit;
}

// Toggle active
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
    header('Location: hoarding.php?msg=updated');
    exit;
}

$locations = getHoardingLocations(null, false);
$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoarding Locations | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Poppins', sans-serif; background: #050505; color: #fff; min-height: 100vh; }
        .admin-header { background: #121212; border-bottom: 1px solid #1f1f1f; padding: 16px 30px; display: flex; justify-content: space-between; align-items: center; }
        .admin-header h1 { font-size: 1.3rem; color: #f5b800; }
        .admin-header a { color: #888; text-decoration: none; margin-left: 20px; font-size: 0.9rem; }
        .admin-header a:hover { color: #f5b800; }
        .container { max-width: 1200px; margin: 0 auto; padding: 30px 20px; }
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px; }
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 500; font-size: 0.9rem; border: none; cursor: pointer; transition: all 0.3s; }
        .btn-primary { background: linear-gradient(135deg, #f5b800, #d4a000); color: #111; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(245,184,0,0.3); }
        .btn-outline { background: transparent; border: 1px solid #333; color: #ccc; }
        .btn-outline:hover { border-color: #f5b800; color: #f5b800; }
        .btn-danger { background: #c0392b; color: #fff; padding: 6px 12px; font-size: 0.8rem; }
        .btn-sm { padding: 6px 12px; font-size: 0.8rem; }
        .alert { padding: 12px 18px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; }
        .alert-success { background: rgba(46,204,113,0.15); border: 1px solid rgba(46,204,113,0.3); color: #2ecc71; }
        table { width: 100%; border-collapse: collapse; background: #121212; border-radius: 12px; overflow: hidden; }
        th, td { padding: 14px 16px; text-align: left; border-bottom: 1px solid #1f1f1f; }
        th { background: #1a1a1a; color: #f5b800; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; }
        td { font-size: 0.9rem; color: #ccc; }
        tr:hover td { background: #161616; }
        .badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-active { background: rgba(46,204,113,0.15); color: #2ecc71; }
        .badge-inactive { background: rgba(231,76,60,0.15); color: #e74c3c; }
        .price { color: #f5b800; font-weight: 600; }
        .actions { display: flex; gap: 8px; flex-wrap: wrap; }
        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr { display: block; }
            thead { display: none; }
            tr { background: #121212; margin-bottom: 15px; border-radius: 10px; padding: 12px; border: 1px solid #1f1f1f; }
            td { border: none; padding: 6px 0; }
            td:before { content: attr(data-label); font-weight: 600; color: #f5b800; display: block; font-size: 0.75rem; margin-bottom: 2px; }
        }
    </style>
</head>
<body>
    <div class="admin-header">
        <h1><i class="fas fa-ad"></i> Hoarding Locations</h1>
        <div>
            <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <div class="container">
        <?php if ($msg === 'deleted'): ?>
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> Location deleted successfully.</div>
        <?php elseif ($msg === 'updated'): ?>
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> Status updated.</div>
        <?php elseif ($msg === 'saved'): ?>
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> Location saved successfully.</div>
        <?php endif; ?>

        <div class="top-bar">
            <h2 style="font-size:1.2rem; color:#fff;">All Sites (<?php echo count($locations); ?>)</h2>
            <a href="hoarding-edit.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Location</a>
        </div>

        <table>
            <thead>
                <tr>
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
                <?php if (empty($locations)): ?>
                    <tr><td colspan="7" style="text-align:center; padding:40px; color:#666;">No locations found. Add one!</td></tr>
                <?php else: ?>
                    <?php foreach ($locations as $loc): ?>
                    <tr>
                        <td data-label="Site #"><strong><?php echo htmlspecialchars($loc['site_number']); ?></strong></td>
                        <td data-label="Title"><?php echo htmlspecialchars($loc['title']); ?></td>
                        <td data-label="Location"><?php echo htmlspecialchars($loc['location'] ?? '-'); ?></td>
                        <td data-label="Size"><?php echo htmlspecialchars($loc['size']); ?></td>
                        <td data-label="Price" class="price">Rs. <?php echo number_format((float)$loc['price'], 0); ?></td>
                        <td data-label="Status">
                            <a href="?toggle=<?php echo $loc['id']; ?>">
                                <span class="badge <?php echo !empty($loc['is_active']) ? 'badge-active' : 'badge-inactive'; ?>">
                                    <?php echo !empty($loc['is_active']) ? 'Active' : 'Hidden'; ?>
                                </span>
                            </a>
                        </td>
                        <td data-label="Actions">
                            <div class="actions">
                                <a href="hoarding-edit.php?id=<?php echo $loc['id']; ?>" class="btn btn-outline btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                <a href="?delete=<?php echo $loc['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this location?')"><i class="fas fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>