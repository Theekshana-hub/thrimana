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