<?php
$page_title = 'Hoarding Locations';
$page_desc  = 'Island Wide 30x20 Hoarding Sites - Premium Billboard Advertising across Sri Lanka | Thrimana Advertising';

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
                'image' => '',    // Board image (hoarding eke photo)
                'image2' => '',   // Location image (thaena / road eke photo)
                'description' => '', 'sort_order' => $i + 1, 'is_active' => 1, 'status' => 'available',
            ];
        }

        $jsonLocations = [];
        $jsonFile = __DIR__ . '/data/hoarding.json';

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

require_once 'includes/header.php';

$locations = getHoardingLocations();
?>

<section class="section" style="padding-top: 120px;">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="tag">Outdoor Advertising</span>
            <h2>Island Wide Hoarding Sites</h2>
            <p>Premium 30′ × 20′ billboard locations across Sri Lanka. High-traffic sites with excellent visibility.</p>
        </div>

        <?php if (count($locations) > 0): ?>
        <div class="hoarding-grid">
            <?php foreach ($locations as $i => $loc):
                $status = strtolower($loc['status'] ?? 'available');
                $isAvailable = ($status === 'available');

                // Images collect karanawa
                $slides = [];
                if (!empty($loc['image']))  $slides[] = ['src' => ASSETS_URL . '/uploads/' . $loc['image'],  'label' => 'Board',    'icon' => 'fa-ad'];
                if (!empty($loc['image2'])) $slides[] = ['src' => ASSETS_URL . '/uploads/' . $loc['image2'], 'label' => 'Location', 'icon' => 'fa-map-marker-alt'];
                $slideCount = count($slides);
            ?>
            <div class="hoarding-card <?php echo $isAvailable ? '' : 'not-available'; ?>" data-aos="fade-up" data-aos-delay="<?php echo min($i * 60, 400); ?>">
                <div class="hoarding-image" data-slider>
                    <?php if ($slideCount > 0): ?>
                        <div class="slides">
                            <?php foreach ($slides as $k => $s): ?>
                                <div class="slide <?php echo $k === 0 ? 'active' : ''; ?>">
                                    <img src="<?php echo htmlspecialchars($s['src']); ?>"
                                         alt="<?php echo htmlspecialchars($loc['title'] . ' - ' . $s['label']); ?>"
                                         loading="lazy"
                                         data-full="<?php echo htmlspecialchars($s['src']); ?>"
                                         onerror="this.onerror=null; this.src='<?php echo ASSETS_URL; ?>/images/logo.png'; this.classList.add('img-fallback');">
                                    <span class="slide-label"><i class="fas <?php echo $s['icon']; ?>"></i> <?php echo $s['label']; ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if ($slideCount > 1): ?>
                            <button type="button" class="nav-btn prev" aria-label="Previous"><i class="fas fa-chevron-left"></i></button>
                            <button type="button" class="nav-btn next" aria-label="Next"><i class="fas fa-chevron-right"></i></button>
                            <div class="slide-tabs">
                                <?php foreach ($slides as $k => $s): ?>
                                    <button type="button" class="tab <?php echo $k === 0 ? 'active' : ''; ?>" data-index="<?php echo $k; ?>">
                                        <?php echo $s['label']; ?>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="hoarding-placeholder">
                            <i class="fas fa-ad"></i>
                            <span>Site <?php echo htmlspecialchars($loc['site_number']); ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="site-badge">SITE <?php echo htmlspecialchars($loc['site_number']); ?></div>

                    <div class="status-badge <?php echo $isAvailable ? 'status-available' : 'status-not-available'; ?>">
                        <?php if ($isAvailable): ?>
                            <i class="fas fa-check-circle"></i> Available
                        <?php else: ?>
                            <i class="fas fa-times-circle"></i> Not Available
                        <?php endif; ?>
                    </div>
                </div>

                <div class="hoarding-body">
                    <h3><?php echo htmlspecialchars($loc['title']); ?></h3>
                    <?php if (!empty($loc['location'])): ?>
                        <p class="location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($loc['location']); ?></p>
                    <?php endif; ?>

                    <div class="hoarding-meta">
                        <span class="size"><i class="fas fa-expand"></i> <?php echo htmlspecialchars($loc['size'] ?: '30X20'); ?></span>
                    </div>

                    <div class="price-box">
                        <div class="price-label">One Year Lease</div>
                        <div class="price">Rs. <?php echo number_format((float)$loc['price'], 0); ?></div>
                        <?php if (!empty($loc['price_note'])): ?>
                            <div class="price-note"><?php echo htmlspecialchars($loc['price_note']); ?></div>
                        <?php endif; ?>
                    </div>

                    <?php if ($isAvailable): ?>
                        <a href="contact.php?subject=Hoarding%20Site%20<?php echo urlencode($loc['site_number']); ?>%20-%20Available" class="btn btn-primary btn-sm">
                            <i class="fas fa-phone-alt"></i> Inquire Now
                        </a>
                    <?php else: ?>
                        <button class="btn btn-disabled btn-sm" disabled>
                            <i class="fas fa-ban"></i> Currently Booked
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
            <div class="empty-state" data-aos="fade-up">
                <i class="fas fa-ad"></i>
                <h3>No locations available at the moment</h3>
                <p>Please check back later or contact us for available sites.</p>
                <a href="contact.php" class="btn btn-primary">Contact Us</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="cta-section">
    <div class="container" data-aos="zoom-in">
        <h2>Ready to Advertise Island Wide?</h2>
        <p>Contact us today for the best available sites and special package rates.</p>
        <a href="contact.php" class="btn btn-primary">
            <i class="fas fa-paper-plane"></i> Get a Quote
        </a>
    </div>
</section>

<!-- Lightbox -->
<div class="hd-lightbox" id="hdLightbox" aria-hidden="true">
    <button type="button" class="hd-close" aria-label="Close">&times;</button>
    <img src="" alt="">
</div>

<style>
.hoarding-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 28px;
    margin-top: 20px;
}
.hoarding-card {
    background: #151515;
    border: 1px solid #252525;
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.35s ease;
    display: flex;
    flex-direction: column;
}
.hoarding-card:hover {
    border-color: #f5c518;
    transform: translateY(-8px);
    box-shadow: 0 16px 40px rgba(245, 197, 24, 0.15);
}
.hoarding-card.not-available { opacity: 0.85; }
.hoarding-card.not-available:hover { border-color: #555; box-shadow: none; }

.hoarding-image {
    position: relative;
    width: 100%;
    height: 240px;
    background: #111;
    overflow: hidden;
}

/* Slider */
.hoarding-image .slides { position: absolute; inset: 0; }
.hoarding-image .slide {
    position: absolute; inset: 0;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.45s ease;
}
.hoarding-image .slide.active { opacity: 1; visibility: visible; }
.hoarding-image .slide img {
    width: 100%; height: 100%;
    object-fit: cover;
    cursor: zoom-in;
    transition: transform 0.5s ease;
}
.hoarding-image .slide img.img-fallback {
    object-fit: contain;
    padding: 30px;
    background: #1a1a1a;
    cursor: default;
}
.hoarding-card:hover .slide.active img:not(.img-fallback) { transform: scale(1.05); }

.slide-label {
    position: absolute;
    left: 14px; bottom: 52px;
    background: rgba(0,0,0,0.7);
    color: #fff;
    font-size: 0.72rem;
    font-weight: 600;
    padding: 5px 10px;
    border-radius: 20px;
    z-index: 2;
    pointer-events: none;
}
.slide-label i { color: #f5c518; margin-right: 4px; }

.nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 34px; height: 34px;
    border-radius: 50%;
    border: none;
    background: rgba(0,0,0,0.6);
    color: #fff;
    cursor: pointer;
    z-index: 3;
    opacity: 0;
    transition: all 0.25s ease;
    display: flex; align-items: center; justify-content: center;
}
.nav-btn:hover { background: #f5c518; color: #111; }
.nav-btn.prev { left: 10px; }
.nav-btn.next { right: 10px; }
.hoarding-image:hover .nav-btn { opacity: 1; }

.slide-tabs {
    position: absolute;
    left: 0; right: 0; bottom: 0;
    display: flex;
    z-index: 3;
    background: rgba(0,0,0,0.75);
    backdrop-filter: blur(4px);
}
.slide-tabs .tab {
    flex: 1;
    padding: 10px 0;
    background: transparent;
    border: none;
    border-top: 2px solid transparent;
    color: #aaa;
    font-size: 0.78rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.25s ease;
}
.slide-tabs .tab:hover { color: #fff; }
.slide-tabs .tab.active { color: #f5c518; border-top-color: #f5c518; }

.hoarding-placeholder {
    width: 100%; height: 100%;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    gap: 12px;
    background: linear-gradient(145deg, #1a1a1a, #111);
    color: #444;
}
.hoarding-placeholder i { font-size: 3rem; color: #333; }
.hoarding-placeholder span { font-size: 0.9rem; color: #555; }

.site-badge {
    position: absolute;
    top: 14px; left: 14px;
    background: linear-gradient(135deg, #f5b800, #d4a000);
    color: #111;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 6px 12px;
    border-radius: 6px;
    letter-spacing: 0.5px;
    z-index: 4;
}
.status-badge {
    position: absolute;
    top: 14px; right: 14px;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 6px 12px;
    border-radius: 20px;
    letter-spacing: 0.3px;
    z-index: 4;
    display: flex; align-items: center; gap: 5px;
}
.status-available { background: rgba(46, 204, 113, 0.9); color: #fff; }
.status-not-available { background: rgba(231, 76, 60, 0.9); color: #fff; }

.hoarding-body {
    padding: 22px 20px 24px;
    display: flex; flex-direction: column; flex: 1;
}
.hoarding-body h3 {
    color: #fff; font-size: 1.15rem; font-weight: 600;
    margin: 0 0 8px 0; line-height: 1.35;
}
.hoarding-body .location { color: #888; font-size: 0.88rem; margin: 0 0 12px 0; }
.hoarding-body .location i { color: #f5c518; margin-right: 6px; }
.hoarding-meta { margin-bottom: 16px; }
.hoarding-meta .size {
    display: inline-flex; align-items: center; gap: 6px;
    background: #1f1f1f; color: #ccc;
    font-size: 0.82rem; padding: 5px 12px; border-radius: 20px;
}
.hoarding-meta .size i { color: #f5c518; font-size: 0.75rem; }
.price-box {
    background: #0d0d0d; border: 1px solid #222;
    border-radius: 12px; padding: 14px 16px; margin-bottom: 18px;
}
.price-label {
    font-size: 0.75rem; color: #888; text-transform: uppercase;
    letter-spacing: 0.5px; margin-bottom: 4px;
}
.price { font-size: 1.45rem; font-weight: 700; color: #f5c518; line-height: 1.2; }
.price-note { font-size: 0.72rem; color: #666; margin-top: 6px; line-height: 1.4; }
.hoarding-body .btn { margin-top: auto; width: 100%; text-align: center; }
.btn-sm { padding: 0.7em 1.2em; font-size: 0.9rem; }
.btn-disabled {
    background: #333 !important; color: #777 !important;
    border: none; cursor: not-allowed; opacity: 0.8;
}
.empty-state { text-align: center; padding: 80px 20px; color: #666; }
.empty-state i { font-size: 4rem; color: #333; margin-bottom: 20px; }
.empty-state h3 { color: #aaa; margin-bottom: 10px; }

/* Lightbox */
.hd-lightbox {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.92);
    display: none;
    align-items: center; justify-content: center;
    z-index: 99999;
    padding: 20px;
}
.hd-lightbox.open { display: flex; }
.hd-lightbox img {
    max-width: 100%; max-height: 90vh;
    border-radius: 10px;
    box-shadow: 0 10px 50px rgba(0,0,0,0.6);
}
.hd-close {
    position: absolute; top: 18px; right: 24px;
    background: none; border: none;
    color: #fff; font-size: 2.6rem; line-height: 1;
    cursor: pointer;
}
.hd-close:hover { color: #f5c518; }

@media (max-width: 768px) {
    .hoarding-grid { grid-template-columns: 1fr; gap: 20px; }
    .hoarding-image { height: 220px; }
    .nav-btn { opacity: 1; }
}
@media (min-width: 769px) and (max-width: 1100px) {
    .hoarding-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Slider
    document.querySelectorAll('[data-slider]').forEach(function (box) {
        var slides = box.querySelectorAll('.slide');
        var tabs = box.querySelectorAll('.tab');
        if (slides.length < 2) return;
        var current = 0;

        function show(n) {
            current = (n + slides.length) % slides.length;
            slides.forEach(function (s, i) { s.classList.toggle('active', i === current); });
            tabs.forEach(function (t, i) { t.classList.toggle('active', i === current); });
        }

        var prev = box.querySelector('.prev');
        var next = box.querySelector('.next');
        if (prev) prev.addEventListener('click', function (e) { e.stopPropagation(); show(current - 1); });
        if (next) next.addEventListener('click', function (e) { e.stopPropagation(); show(current + 1); });
        tabs.forEach(function (t) {
            t.addEventListener('click', function (e) {
                e.stopPropagation();
                show(parseInt(t.dataset.index, 10));
            });
        });

        // Swipe (mobile)
        var startX = null;
        box.addEventListener('touchstart', function (e) { startX = e.touches[0].clientX; }, {passive: true});
        box.addEventListener('touchend', function (e) {
            if (startX === null) return;
            var diff = e.changedTouches[0].clientX - startX;
            if (Math.abs(diff) > 40) show(diff < 0 ? current + 1 : current - 1);
            startX = null;
        });
    });

    // Lightbox
    var lb = document.getElementById('hdLightbox');
    var lbImg = lb.querySelector('img');
    function closeLb() { lb.classList.remove('open'); lbImg.src = ''; }

    document.querySelectorAll('.hoarding-image .slide img').forEach(function (img) {
        img.addEventListener('click', function () {
            if (img.classList.contains('img-fallback')) return;
            lbImg.src = img.dataset.full || img.src;
            lb.classList.add('open');
        });
    });
    lb.addEventListener('click', function (e) { if (e.target !== lbImg) closeLb(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeLb(); });
});
</script>

<?php require_once 'includes/footer.php'; ?>