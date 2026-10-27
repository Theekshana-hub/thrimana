<?php
require_once __DIR__ . '/config.php';

define('DATA_DIR', __DIR__ . '/../data/');

function ensureDataFiles() {
    if (!is_dir(DATA_DIR)) {
        mkdir(DATA_DIR, 0755, true);
    }
    
    $files = [
        'content.json' => [
            'hero_title' => ['title' => 'THRIMANA', 'body' => ''],
            'hero_subtitle' => ['title' => 'Ruhunu Iron Works', 'body' => 'Premier advertising, iron fabrication and construction solutions across Sri Lanka. Quality craftsmanship that lasts.'],
            'about_body' => [
                'title' => 'About Thrimana',
                'body' => "Thrimana Advertising & Construction Services (Ruhunu Iron Works) is a trusted name in high-quality iron works, architectural metal fabrication, outdoor advertising solutions, and general construction. With years of experience, precision engineering and creative design, we deliver projects that stand the test of time.\n\nWe specialize in:\n• Custom iron gates, railings, staircases and structural steel\n• LED signage, billboards and branding solutions\n• Residential & commercial construction and renovations\n• Industrial fabrication and installation\n\nOur commitment is quality craftsmanship, on-time delivery and client satisfaction."
            ],
        ],
        'services.json' => [
            ['id' => 1, 'title' => 'Iron Works & Fabrication', 'description' => 'Custom steel fabrication, gates, railings, structural frames, industrial metal works with precision welding and finishing.', 'icon' => 'fa-industry', 'sort_order' => 1, 'is_active' => 1],
            ['id' => 2, 'title' => 'Advertising & Signage', 'description' => 'LED boards, 3D letters, billboards, vehicle branding, shop fronts and complete outdoor advertising solutions.', 'icon' => 'fa-ad', 'sort_order' => 2, 'is_active' => 1],
            ['id' => 3, 'title' => 'Construction Services', 'description' => 'Residential, commercial and industrial construction, renovations, structural works and project management.', 'icon' => 'fa-hard-hat', 'sort_order' => 3, 'is_active' => 1],
            ['id' => 4, 'title' => 'Architectural Metal Design', 'description' => 'Designer staircases, balconies, canopies, pergolas and modern metal architectural elements.', 'icon' => 'fa-drafting-compass', 'sort_order' => 4, 'is_active' => 1],
            ['id' => 5, 'title' => 'Powder Coating & Finishing', 'description' => 'Durable powder coating, anti-rust treatment and premium finishes for long-lasting protection.', 'icon' => 'fa-spray-can', 'sort_order' => 5, 'is_active' => 1],
            ['id' => 6, 'title' => 'Installation & Maintenance', 'description' => 'Professional on-site installation, repairs and maintenance services for all our products.', 'icon' => 'fa-tools', 'sort_order' => 6, 'is_active' => 1],
        ],
        'gallery.json' => [],
        'messages.json' => [],
        'settings.json' => [
            'site_name' => SITE_NAME,
            'phone' => SITE_PHONE,
            'email' => SITE_EMAIL,
            'address' => SITE_ADDRESS,
            'facebook' => 'https://facebook.com/',
            'instagram' => 'https://instagram.com/',
            'whatsapp' => '94771234567',
        ],
    ];
    
    foreach ($files as $file => $default) {
        $path = DATA_DIR . $file;
        if (!file_exists($path)) {
            file_put_contents($path, json_encode($default, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
    }
}

function readJson($file) {
    ensureDataFiles();
    $path = DATA_DIR . $file;
    $data = json_decode(file_get_contents($path), true);
    return is_array($data) ? $data : [];
}

function writeJson($file, $data) {
    ensureDataFiles();
    file_put_contents(DATA_DIR . $file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function getContent($section) {
    $all = readJson('content.json');
    return $all[$section] ?? ['title' => '', 'body' => ''];
}

function setContent($section, $title, $body) {
    $all = readJson('content.json');
    $all[$section] = ['title' => $title, 'body' => $body];
    writeJson('content.json', $all);
}

function getSetting($key, $default = '') {
    $all = readJson('settings.json');
    return $all[$key] ?? $default;
}

function setSetting($key, $value) {
    $all = readJson('settings.json');
    $all[$key] = $value;
    writeJson('settings.json', $all);
}

function getServices($activeOnly = true) {
    $all = readJson('services.json');
    if ($activeOnly) {
        $all = array_filter($all, function($s) { return !empty($s['is_active']); });
    }
    usort($all, function($a, $b) { return ($a['sort_order'] ?? 0) <=> ($b['sort_order'] ?? 0); });
    return array_values($all);
}

function getGallery($limit = null) {
    $all = readJson('gallery.json');
    usort($all, function($a, $b) { return ($b['id'] ?? 0) <=> ($a['id'] ?? 0); });
    if ($limit) $all = array_slice($all, 0, $limit);
    return $all;
}

function addMessage($name, $email, $phone, $subject, $message) {
    $all = readJson('messages.json');
    $all[] = [
        'id' => time() . rand(10,99),
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'subject' => $subject,
        'message' => $message,
        'is_read' => 0,
        'created_at' => date('Y-m-d H:i:s'),
    ];
    writeJson('messages.json', $all);
}

function getMessages() {
    $all = readJson('messages.json');
    usort($all, function($a, $b) { return strcmp($b['created_at'] ?? '', $a['created_at'] ?? ''); });
    return $all;
}
?>
