<?php
$page_title = 'Gallery';
$page_desc = 'Project Gallery - Thrimana Iron Works, Advertising & Construction';
require_once 'includes/header.php';

$gallery = getGallery();
?>

<section class="page-hero">
    <div class="container">
        <h1 data-aos="fade-up">Project Gallery</h1>
        <p data-aos="fade-up" data-aos-delay="100">See the quality and craftsmanship in our completed projects</p>
        <div class="breadcrumb" data-aos="fade-up" data-aos-delay="150">
            <a href="index.php">Home</a> &nbsp;/&nbsp; Gallery
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (count($gallery) > 0): ?>
        <div class="gallery-grid">
            <?php foreach ($gallery as $i => $item): ?>
            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="<?php echo ($i % 4) * 80; ?>">
                <img src="<?php echo ASSETS_URL; ?>/uploads/<?php echo htmlspecialchars($item['image_path']); ?>" 
                     alt="<?php echo htmlspecialchars($item['title']); ?>"
                     onerror="this.src='<?php echo ASSETS_URL; ?>/images/logo.png'">
                <div class="gallery-overlay">
                    <h4><?php echo htmlspecialchars($item['title'] ?: 'Project'); ?></h4>
                    <span><?php echo htmlspecialchars($item['category'] ?: 'General'); ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="gallery-grid">
            <?php for ($i = 1; $i <= 8; $i++): ?>
            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="<?php echo ($i % 4) * 80; ?>">
                <div style="width:100%;height:100%;background:linear-gradient(145deg,#151515,#252525);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:12px;">
                    <i class="fas fa-camera" style="font-size:2.8rem;color:#3a3a3a;"></i>
                    <span style="color:#555;font-size:0.9rem;">Upload Project Photos</span>
                </div>
                <div class="gallery-overlay">
                    <h4>Sample Project <?php echo $i; ?></h4>
                    <span>Admin → Gallery</span>
                </div>
            </div>
            <?php endfor; ?>
        </div>
        <p style="text-align:center;margin-top:40px;color:var(--text-muted);" data-aos="fade-up">
            <i class="fas fa-info-circle"></i> Gallery images can be uploaded and managed from the Admin Dashboard.
        </p>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
