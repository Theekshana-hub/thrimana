<?php
$page_title = 'About Us';
$page_desc = 'Learn about Thrimana Advertising & Construction Services - Ruhunu Iron Works';
require_once 'includes/header.php';

$about = getContent('about_body');
?>

<section class="page-hero">
    <div class="container">
        <h1 data-aos="fade-up">About Us</h1>
        <p data-aos="fade-up" data-aos-delay="100">The story behind Thrimana & Ruhunu Iron Works</p>
        <div class="breadcrumb" data-aos="fade-up" data-aos-delay="150">
            <a href="index.php">Home</a> &nbsp;/&nbsp; About
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="about-grid">
            <div class="about-image" data-aos="fade-right">
                <img src="<?php echo ASSETS_URL; ?>/images/logo.png" alt="Thrimana" style="border-radius:20px;box-shadow:0 20px 60px rgba(0,0,0,0.5);">
            </div>
            <div class="about-content" data-aos="fade-left">
                <span class="tag">Our Story</span>
                <h2><?php echo htmlspecialchars($about['title'] ?: 'About Thrimana'); ?></h2>
                <div style="color:var(--text-muted);white-space:pre-line;">
                    <?php echo nl2br(htmlspecialchars($about['body'] ?: 'Content will appear here after editing from admin panel.')); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section" style="background:rgba(245,184,0,0.03);">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="tag">Our Values</span>
            <h2>What Drives Us</h2>
        </div>
        
        <div class="services-grid">
            <div class="service-card" data-aos="fade-up" data-aos-delay="0">
                <div class="service-icon"><i class="fas fa-medal"></i></div>
                <h3>Quality First</h3>
                <p>We never compromise on materials or workmanship. Every weld, every finish is done to the highest standard.</p>
            </div>
            <div class="service-card" data-aos="fade-up" data-aos-delay="100">
                <div class="service-icon"><i class="fas fa-handshake"></i></div>
                <h3>Integrity</h3>
                <p>Honest pricing, clear communication and reliable timelines. We treat every client’s project as our own.</p>
            </div>
            <div class="service-card" data-aos="fade-up" data-aos-delay="200">
                <div class="service-icon"><i class="fas fa-lightbulb"></i></div>
                <h3>Innovation</h3>
                <p>Combining traditional metal craft with modern design and technology to create unique solutions.</p>
            </div>
            <div class="service-card" data-aos="fade-up" data-aos-delay="300">
                <div class="service-icon"><i class="fas fa-users"></i></div>
                <h3>Client Focus</h3>
                <p>Your vision guides our work. We listen, advise and deliver results that exceed expectations.</p>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container" data-aos="zoom-in">
        <h2>Want to Work With Us?</h2>
        <p>Let’s discuss your next iron works, advertising or construction project.</p>
        <a href="contact.php" class="btn btn-primary"><i class="fas fa-envelope"></i> Get in Touch</a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
