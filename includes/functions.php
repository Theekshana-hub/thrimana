<?php
function getServices($limit = null) {
    $defaultServices = [
        [
            'id' => 1,
            'title' => 'Advertising & Billboard Solutions',
            'description' => 'Highway billboards, city hoardings, light boxes, digital LED display units',
            'icon' => 'fa-ad',
            'image' => '',
            'sort_order' => 1,
            'is_active' => 1
        ],
        [
            'id' => 2,
            'title' => 'Civil & Construction Works',
            'description' => 'Foundation base welding, civil masonry, structural foundation, site construction',
            'icon' => 'fa-hard-hat',
            'image' => '',
            'sort_order' => 2,
            'is_active' => 1
        ],
        [
            'id' => 3,
            'title' => 'Iron & Steel Fabrication',
            'description' => 'Automatic gate systems, carports, canopies, pergolas, railings, balustrades, commercial steel structures',
            'icon' => 'fa-industry',
            'image' => '',
            'sort_order' => 3,
            'is_active' => 1
        ],
        [
            'id' => 4,
            'title' => 'Printing & Branding Materials',
            'description' => 'Large format digital printing, vinyl stickers, flex banners, promotional signboards',
            'icon' => 'fa-print',
            'image' => '',
            'sort_order' => 4,
            'is_active' => 1
        ],
        [
            'id' => 5,
            'title' => 'Specialized Architectural Works',
            'description' => 'Tempered glass, polycarbonate sheets, aluminium partitions, gutter systems, I-panels, cladding',
            'icon' => 'fa-drafting-compass',
            'image' => '',
            'sort_order' => 5,
            'is_active' => 1
        ],
        [
            'id' => 6,
            'title' => 'Test Fabrication Sector',
            'description' => 'Test Category',
            'icon' => 'fa-tools',
            'image' => '',
            'sort_order' => 6,
            'is_active' => 1
        ]
    ];

    $jsonServices = [];
    if (function_exists('readJson')) {
        $jsonServices = readJson('services.json');
        if (!is_array($jsonServices)) $jsonServices = [];
    }

    $merged = [];
    $usedTitles = [];

    foreach ($jsonServices as $s) {
        if (empty($s['is_active'])) continue;
        $merged[] = $s;
        $usedTitles[] = strtolower(trim($s['title'] ?? ''));
    }

    foreach ($defaultServices as $d) {
        $title = strtolower(trim($d['title']));
        if (!in_array($title, $usedTitles)) {
            $merged[] = $d;
        }
    }

    usort($merged, function($a, $b) {
        return ($a['sort_order'] ?? 999) <=> ($b['sort_order'] ?? 999);
    });

    if ($limit) {
        $merged = array_slice($merged, 0, $limit);
    }

    return $merged;
}
// ========== HOARDING LOCATIONS ==========
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

    // JSON eke data thiyenawanam eka use karanna, neththan defaults
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

function getHoardingById($id) {
    $all = getHoardingLocations(null, false);
    foreach ($all as $item) {
        if ((int)($item['id'] ?? 0) === (int)$id) {
            return $item;
        }
    }
    return null;
}

function saveHoardingLocations($data) {
    $data = array_values($data);
    if (function_exists('writeJson')) {
        return writeJson('hoarding.json', $data);
    }
    // Fallback
    $file = __DIR__ . '/../data/hoarding.json';
    return file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function getNextHoardingId() {
    $all = getHoardingLocations(null, false);
    $max = 0;
    foreach ($all as $item) {
        $id = (int)($item['id'] ?? 0);
        if ($id > $max) $max = $id;
    }
    return $max + 1;
}