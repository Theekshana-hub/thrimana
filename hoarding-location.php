<?php
$page_title = 'Hoarding Locations';
$page_desc  = 'Island Wide 30x20 Hoarding Sites - Premium Billboard Advertising across Sri Lanka | Thrimana Advertising';
require_once 'includes/header.php';

$locations = getHoardingLocations(true); // only active
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
            <?php foreach ($locations as $i => $loc): ?>
            <div class="hoarding-card" data-aos="fade-up" data-aos-delay="<?php echo min($i * 60, 400); ?>">
                <div class="hoarding-image">
                    <?php if (!empty($loc['image'])): ?>
                        <img src="<?php echo ASSETS_URL; ?>/uploads/<?php echo htmlspecialchars($loc['image']); ?>" 
                             alt="<?php echo htmlspecialchars($loc['title']); ?>"
                             loading="lazy"
                             onerror="this.src='<?php echo ASSETS_URL; ?>/images/logo.png'">
                    <?php else: ?>
                        <div class="hoarding-placeholder">
                            <i class="fas fa-ad"></i>
                            <span>Site <?php echo htmlspecialchars($loc['site_number']); ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="site-badge">SITE <?php echo htmlspecialchars($loc['site_number']); ?></div>
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

                    <a href="contact.php?subject=Hoarding%20Site%20<?php echo urlencode($loc['site_number']); ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-phone-alt"></i> Inquire Now
                    </a>
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

<style>
/* ========== HOARDING LOCATIONS ========== */
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

.hoarding-image {
    position: relative;
    width: 100%;
    height: 220px;
    background: #111;
    overflow: hidden;
}

.hoarding-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.hoarding-card:hover .hoarding-image img {
    transform: scale(1.06);
}

.hoarding-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 12px;
    background: linear-gradient(145deg, #1a1a1a, #111);
    color: #444;
}

.hoarding-placeholder i {
    font-size: 3rem;
    color: #333;
}

.hoarding-placeholder span {
    font-size: 0.9rem;
    color: #555;
}

.site-badge {
    position: absolute;
    top: 14px;
    left: 14px;
    background: linear-gradient(135deg, #f5b800, #d4a000);
    color: #111;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 6px 12px;
    border-radius: 6px;
    letter-spacing: 0.5px;
}

.hoarding-body {
    padding: 22px 20px 24px;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.hoarding-body h3 {
    color: #fff;
    font-size: 1.15rem;
    font-weight: 600;
    margin: 0 0 8px 0;
    line-height: 1.35;
}

.hoarding-body .location {
    color: #888;
    font-size: 0.88rem;
    margin: 0 0 12px 0;
}

.hoarding-body .location i {
    color: #f5c518;
    margin-right: 6px;
}

.hoarding-meta {
    margin-bottom: 16px;
}

.hoarding-meta .size {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #1f1f1f;
    color: #ccc;
    font-size: 0.82rem;
    padding: 5px 12px;
    border-radius: 20px;
}

.hoarding-meta .size i {
    color: #f5c518;
    font-size: 0.75rem;
}

.price-box {
    background: #0d0d0d;
    border: 1px solid #222;
    border-radius: 12px;
    padding: 14px 16px;
    margin-bottom: 18px;
}

.price-label {
    font-size: 0.75rem;
    color: #888;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.price {
    font-size: 1.45rem;
    font-weight: 700;
    color: #f5c518;
    line-height: 1.2;
}

.price-note {
    font-size: 0.72rem;
    color: #666;
    margin-top: 6px;
    line-height: 1.4;
}

.hoarding-body .btn {
    margin-top: auto;
    width: 100%;
    text-align: center;
}

.btn-sm {
    padding: 0.7em 1.2em;
    font-size: 0.9rem;
}

.empty-state {
    text-align: center;
    padding: 80px 20px;
    color: #666;
}

.empty-state i {
    font-size: 4rem;
    color: #333;
    margin-bottom: 20px;
}

.empty-state h3 {
    color: #aaa;
    margin-bottom: 10px;
}

@media (max-width: 768px) {
    .hoarding-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    .hoarding-image {
        height: 200px;
    }
}

@media (min-width: 769px) and (max-width: 1100px) {
    .hoarding-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<?php require_once 'includes/footer.php'; ?>