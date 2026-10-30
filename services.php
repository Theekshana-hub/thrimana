<?php
$page_title = 'Services';
$page_desc = 'Iron Works, Advertising Signage, Construction Services by Thrimana';
require_once 'includes/header.php';

$services = getServices();
?>

<section class="page-hero">
    <div class="container">
        <h1 data-aos="fade-up">Our Services</h1>
        <p data-aos="fade-up" data-aos-delay="100">Complete solutions for iron works, advertising & construction</p>
        <div class="breadcrumb" data-aos="fade-up" data-aos-delay="150">
            <a href="index.php">Home</a> &nbsp;/&nbsp; Services
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="services-grid">
            <?php foreach ($services as $i => $service): ?>
            <div class="service-card" data-aos="fade-up" data-aos-delay="<?php echo ($i % 3) * 100; ?>">
                <?php if (!empty($service['image'])): ?>
                    <div class="service-image">
                        <img src="<?php echo ASSETS_URL; ?>/uploads/<?php echo htmlspecialchars($service['image']); ?>"
                             alt="<?php echo htmlspecialchars($service['title']); ?>"
                             loading="lazy"
                             onerror="this.parentElement.innerHTML='<div class=\'service-icon\'><i class=\'fas <?php echo htmlspecialchars($service['icon'] ?? 'fa-tools'); ?>\'></i></div>'">
                    </div>
                <?php else: ?>
                    <div class="service-icon">
                        <i class="fas <?php echo htmlspecialchars($service['icon'] ?? 'fa-tools'); ?>"></i>
                    </div>
                <?php endif; ?>
                <h3><?php echo htmlspecialchars($service['title']); ?></h3>
                <p><?php echo htmlspecialchars($service['description']); ?></p>
            </div>
            <?php endforeach; ?>

            <?php if (empty($services)): ?>
            <div class="empty-state" style="grid-column:1/-1;">
                <i class="fas fa-tools"></i>
                <p>Services will appear here. Add them from the Admin Dashboard.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container" data-aos="zoom-in">
        <h2>Need a Custom Solution?</h2>
        <p>We design and fabricate according to your exact requirements. Contact us for a free consultation.</p>
        <a href="contact.php" class="btn btn-primary"><i class="fas fa-comments"></i> Request a Quote</a>
    </div>
</section>

<style>
.service-image {
    width: 100%;
    height: 160px;
    overflow: hidden;
    border-radius: 12px;
    margin-bottom: 16px;
    background: #1a1a1a;
}
.service-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.4s ease;
}
.service-card:hover .service-image img {
    transform: scale(1.06);
}
</style>

<?php require_once 'includes/footer.php'; ?>