<?php
$page_title = 'Home';
$page_desc = 'Thrimana Advertising & Construction Services - Premium Iron Works, Signage, Construction in Sri Lanka';
require_once 'includes/header.php';

$hero = getContent('hero_title');
$hero_sub = getContent('hero_subtitle');
$services = getServices();
$gallery = getGallery(6);
?>

<!-- Hero Section -->
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

<!-- Services Preview -->
<section class="section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="tag">What We Do</span>
            <h2>Our Premium Services</h2>
            <p>From custom iron fabrication to impactful advertising and solid construction — we deliver excellence in every project.</p>
        </div>

        <div class="services-grid">
            <?php foreach (array_slice($services, 0, 6) as $i => $service): ?>
            <div class="service-card" data-aos="fade-up" data-aos-delay="<?php echo $i * 100; ?>">
                <div class="service-icon">
                    <i class="fas <?php echo htmlspecialchars($service['icon']); ?>"></i>
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

<!-- Why Choose Us -->
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

<!-- Gallery Preview -->
<section class="section">
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
                <img src="<?php echo ASSETS_URL; ?>/uploads/<?php echo htmlspecialchars($item['image_path']); ?>"
                     alt="<?php echo htmlspecialchars($item['title']); ?>"
                     loading="lazy"
                     onerror="this.src='<?php echo ASSETS_URL; ?>/images/logo.png'">
                <div class="gallery-overlay">
                    <h4><?php echo htmlspecialchars($item['title'] ?: 'Project'); ?></h4>
                    <span><?php echo htmlspecialchars($item['category']); ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="gallery-grid">
            <?php for ($i = 1; $i <= 6; $i++): ?>
            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="<?php echo $i * 80; ?>">
                <div class="gallery-placeholder">
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

<!-- CTA -->
<section class="cta-section">
    <div class="container" data-aos="zoom-in">
        <h2>Ready to Start Your Project?</h2>
        <p>Contact us today for a free consultation and quote. Let’s build something exceptional together.</p>
        <a href="contact.php" class="btn btn-primary">
            <i class="fas fa-paper-plane"></i> Contact Us Now
        </a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>