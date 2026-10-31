<?php
$page_title = 'Home';
$page_desc  = 'Thrimana Advertising & Construction Services - Premium Iron Works, Signage, Construction in Sri Lanka';
require_once 'includes/header.php';

$hero     = getContent('hero_title');
$hero_sub = getContent('hero_subtitle');
$gallery  = getGallery(6);
$services = getServices(6);
?>

<section class="hero">
    <div class="hero-bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>

    <div class="container">
        <div class="hero-content">
            <div class="hero-text" data-aos="fade-right">
                <h1>
                    <span><?php echo htmlspecialchars($hero['title'] ?: 'THRIMANA'); ?></span><br>
                    Advertising &amp; Construction
                </h1>
                <p class="subtitle">
                    <?php echo htmlspecialchars($hero_sub['body'] ?: 'Premier advertising, iron fabrication and construction solutions across Sri Lanka. Quality craftsmanship that lasts.'); ?>
                </p>
                <div class="hero-buttons">
                    <a href="services.php" class="btn btn-primary">
                        <i class="fas fa-briefcase"></i> Our Services
                    </a>
                    <a href="contact.php" class="btn btn-outline">
                        <i class="fas fa-phone-alt"></i> Get a Quote
                    </a>
                </div>

                <div class="hero-stats">
                    <div class="stat-item" data-aos="fade-up" data-aos-delay="100">
                        <div class="stat-number" data-target="15" data-suffix="+">0</div>
                        <div class="stat-label">Years Experience</div>
                    </div>
                    <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                        <div class="stat-number" data-target="500" data-suffix="+">0</div>
                        <div class="stat-label">Projects Done</div>
                    </div>
                    <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
                        <div class="stat-number" data-target="100" data-suffix="%">0</div>
                        <div class="stat-label">Client Satisfaction</div>
                    </div>
                </div>
            </div>

            <div class="hero-visual" data-aos="fade-left" data-aos-delay="200">
                <div class="hero-logo-wrapper">
                    <img src="<?php echo ASSETS_URL; ?>/images/logo.png" alt="Thrimana Logo" class="hero-logo">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="tag">What We Do</span>
            <h2>Our Premium Services</h2>
            <p>From custom iron fabrication to impactful advertising and solid construction — we deliver excellence in every project.</p>
        </div>

        <div class="services-grid">
            <?php foreach ($services as $i => $service): ?>
            <div class="service-card" data-aos="fade-up" data-aos-delay="<?php echo $i * 100; ?>">
                <div class="service-icon">
                    <i class="fas <?php echo htmlspecialchars($service['icon'] ?? 'fa-tools'); ?>"></i>
                </div>
                <h3><?php echo htmlspecialchars($service['title']); ?></h3>
                <p><?php echo htmlspecialchars($service['description']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="section-action" data-aos="fade-up">
            <a href="services.php" class="btn btn-outline">View All Services <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</section>

<section class="section section-tinted">
    <div class="container">
        <div class="about-grid">
            <div class="about-image" data-aos="fade-right">
                <img src="<?php echo ASSETS_URL; ?>/images/logo.png" alt="Thrimana Quality" class="about-logo">
            </div>
            <div class="about-content" data-aos="fade-left">
                <span class="tag">Why Thrimana</span>
                <h2>Crafted with Precision.<br>Built to Last.</h2>
                <p>We combine traditional craftsmanship with modern technology to create iron works, signage and structures that stand out and stand strong.</p>
                <p>Every project is handled with attention to detail, quality materials and professional installation.</p>

                <div class="about-features">
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Premium Materials</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Expert Team</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>On-Time Delivery</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>After-Sales Support</span>
                    </div>
                </div>

                <div class="about-action">
                    <a href="about.php" class="btn btn-primary">Learn More About Us</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section gallery-preview-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="tag">Our Work</span>
            <h2>Project Gallery</h2>
            <p>A glimpse of the quality work we deliver for our valued clients.</p>
        </div>

        <?php if (count($gallery) > 0): ?>
            <div class="gallery-grid">
                <?php foreach ($gallery as $i => $item): ?>
                    <div class="gallery-item" data-aos="zoom-in" data-aos-delay="<?php echo $i * 80; ?>">
                        <div class="gallery-img-wrap">
                            <img src="<?php echo ASSETS_URL; ?>/uploads/<?php echo htmlspecialchars($item['image_path']); ?>"
                                 alt="<?php echo htmlspecialchars($item['title']); ?>"
                                 loading="lazy"
                                 onerror="this.src='<?php echo ASSETS_URL; ?>/images/logo.png'">
                        </div>
                        <div class="gallery-overlay">
                            <h4><?php echo htmlspecialchars($item['title'] ?: 'Project'); ?></h4>
                            <span><?php echo htmlspecialchars($item['category'] ?: 'General'); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="gallery-grid">
                <?php for ($i = 1; $i <= 6; $i++): ?>
                    <div class="gallery-item empty" data-aos="zoom-in" data-aos-delay="<?php echo $i * 80; ?>">
                        <div class="empty-placeholder">
                            <i class="fas fa-image"></i>
                            <span>Project <?php echo $i; ?></span>
                        </div>
                        <div class="gallery-overlay">
                            <h4>Sample Project <?php echo $i; ?></h4>
                            <span>Upload via Admin</span>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        <?php endif; ?>

        <div class="section-action" data-aos="fade-up">
            <a href="gallery.php" class="btn btn-outline">View Full Gallery <i class="fas fa-images"></i></a>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container" data-aos="zoom-in">
        <h2>Ready to Start Your Project?</h2>
        <p>Contact us today for a free consultation and quote. Let’s build something exceptional together.</p>
        <a href="contact.php" class="btn btn-primary">
            <i class="fas fa-paper-plane"></i> Contact Us Now
        </a>
    </div>
</section>

<style>
/* ========== Project Gallery Styles (original) ========== */
.gallery-preview-section {
    background: #0a0a0a;
    padding: 80px 0;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 28px;
    margin-bottom: 40px;
}

.gallery-item {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    background: #151515;
    border: 1px solid #252525;
    aspect-ratio: 4 / 3;
    transition: all 0.35s ease;
    cursor: pointer;
}

.gallery-item:hover {
    border-color: #f5c518;
    transform: translateY(-8px);
    box-shadow: 0 16px 40px rgba(245, 197, 24, 0.18);
}

.gallery-img-wrap {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #111;
}

.gallery-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
    display: block;
    transition: transform 0.5s ease;
    background: #111;
}

.gallery-item:hover .gallery-img-wrap img {
    transform: scale(1.05);
}

.gallery-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 22px 20px;
    background: linear-gradient(to top, rgba(0,0,0,0.95) 0%, rgba(0,0,0,0.55) 55%, transparent 100%);
    transform: translateY(10px);
    opacity: 0.92;
    transition: all 0.35s ease;
}

.gallery-item:hover .gallery-overlay {
    transform: translateY(0);
    opacity: 1;
}

.gallery-overlay h4 {
    color: #ffffff;
    font-size: 1.15rem;
    font-weight: 600;
    margin: 0 0 6px 0;
    line-height: 1.3;
}

.gallery-overlay span {
    color: #f5c518;
    font-size: 0.85rem;
    font-weight: 500;
    letter-spacing: 0.3px;
}

.gallery-item.empty {
    background: linear-gradient(145deg, #151515, #1f1f1f);
}

.empty-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 14px;
}

.empty-placeholder i {
    font-size: 2.8rem;
    color: #3a3a3a;
    transition: color 0.3s ease;
}

.gallery-item.empty:hover .empty-placeholder i {
    color: #f5c518;
}

.empty-placeholder span {
    color: #555;
    font-size: 0.9rem;
}

/* =====================================================
   MOBILE / TABLET: text udin, LOGO YATIN (pahalin)
   PC design ekata kisima wenasak na
   ===================================================== */

@media (max-width: 992px) {

    .hero {
        overflow: hidden;
    }

    /* Single column: text udin, logo yatin */
    .hero-content {
        display: grid !important;
        grid-template-columns: 1fr !important;
        align-items: start !important;
        gap: 36px !important;
        text-align: left !important;
    }

    .hero-text {
        order: 1 !important;
        min-width: 0;
        max-width: 100% !important;
        text-align: left !important;
    }

    .hero-visual {
        order: 2 !important;              /* logo eka yatinma */
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        min-width: 0;
        width: 100% !important;
        height: auto !important;
    }

    /* ===== LOGO: hariyatama circle, oval wenne na, crop wenne na ===== */
    .hero-logo-wrapper {
        position: relative;
        width: min(72vw, 320px) !important;
        max-width: 100% !important;
        height: auto !important;
        min-height: 0 !important;
        aspect-ratio: 1 / 1 !important;
        margin: 0 auto !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .hero-logo {
        width: 100% !important;
        max-width: 100% !important;
        height: 100% !important;
        aspect-ratio: 1 / 1 !important;
        object-fit: contain !important;
        object-position: center !important;
        padding: 9% !important;
        box-sizing: border-box !important;
        border-radius: 50% !important;
        display: block;
    }

    /* Heading: THRIMANA <br> Advertising & Construction */
    .hero-text h1 {
        font-size: clamp(1.1rem, 4.8vw, 2.1rem) !important;
        line-height: 1.2 !important;
        overflow-wrap: break-word;
    }

    .hero-text h1 span {
        font-size: clamp(2rem, 11vw, 3.8rem) !important;
        line-height: 1.1 !important;
    }

    .hero-text .subtitle {
        font-size: clamp(0.85rem, 3.2vw, 1.05rem) !important;
        line-height: 1.6 !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        max-width: 100% !important;
    }

    /* Buttons PC eke wage (row ekak) */
    .hero-buttons {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: wrap !important;
        justify-content: flex-start !important;
        gap: 10px !important;
        max-width: 100% !important;
        margin-left: 0 !important;
    }

    .hero-buttons .btn {
        width: auto !important;
        padding: 0.65em 1.1em !important;
        font-size: clamp(0.75rem, 3vw, 0.95rem) !important;
        white-space: nowrap;
    }

    /* Stats 3 eka row ekakata */
    .hero-stats {
        display: grid !important;
        grid-template-columns: repeat(3, auto) !important;
        justify-content: start !important;
        gap: 6vw !important;
    }

    .hero-stats .stat-item {
        padding: 0 !important;
        text-align: left;
    }

    .hero-stats .stat-number {
        font-size: clamp(1.3rem, 6vw, 2.2rem) !important;
    }

    .hero-stats .stat-label {
        font-size: clamp(0.62rem, 2.4vw, 0.85rem) !important;
        line-height: 1.25 !important;
    }

    .hero-bg-shapes .shape {
        max-width: 80vw;
        max-height: 80vw;
    }
}

/* Mobile phones */
@media (max-width: 768px) {
    .hero {
        padding-top: 80px !important;
        padding-bottom: 40px !important;
    }

    .hero .container {
        padding-left: 16px !important;
        padding-right: 16px !important;
    }

    /* Gallery */
    .gallery-preview-section {
        padding: 50px 0;
    }

    .gallery-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
    }

    .gallery-overlay {
        padding: 14px 12px;
    }

    .gallery-overlay h4 {
        font-size: 0.95rem;
    }

    .gallery-overlay span {
        font-size: 0.75rem;
    }
}

/* Chuti phones */
@media (max-width: 400px) {
    .hero-buttons .btn i {
        display: none;
    }

    .hero-stats {
        gap: 4vw !important;
    }
}

@media (max-width: 480px) {
    .gallery-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php require_once 'includes/footer.php'; ?>