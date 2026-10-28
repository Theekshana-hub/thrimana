<?php
$page_title = 'Gallery';
$page_desc  = 'Project Gallery - Thrimana Iron Works, Advertising & Construction';
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

<section class="section gallery-section">
    <div class="container">
        <?php if (count($gallery) > 0): ?>
            <div class="gallery-grid">
                <?php foreach ($gallery as $i => $item): ?>
                    <div class="gallery-item" data-aos="zoom-in" data-aos-delay="<?php echo ($i % 4) * 80; ?>">
                        <div class="gallery-img-wrap">
                            <img src="<?php echo ASSETS_URL; ?>/uploads/<?php echo htmlspecialchars($item['image_path']); ?>"
                                 alt="<?php echo htmlspecialchars($item['title']); ?>"
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
                <?php for ($i = 1; $i <= 8; $i++): ?>
                    <div class="gallery-item empty" data-aos="zoom-in" data-aos-delay="<?php echo ($i % 4) * 80; ?>">
                        <div class="empty-placeholder">
                            <i class="fas fa-camera"></i>
                            <span>Upload Project Photos</span>
                        </div>
                        <div class="gallery-overlay">
                            <h4>Sample Project <?php echo $i; ?></h4>
                            <span>Admin → Gallery</span>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>

            <p class="gallery-note" data-aos="fade-up">
                <i class="fas fa-info-circle"></i>
                Gallery images can be uploaded and managed from the Admin Dashboard.
            </p>
        <?php endif; ?>
    </div>
</section>

<style>
/* ===== Gallery Dark Theme (matches Services cards style) ===== */
.gallery-section {
    background: #0a0a0a;
    padding: 80px 0;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
}

.gallery-item {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    background: #151515;
    border: 1px solid #252525;
    aspect-ratio: 4/3;
    transition: all 0.35s ease;
    cursor: pointer;
}

.gallery-item:hover {
    border-color: #f5c518;
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(245, 197, 24, 0.15);
}

.gallery-img-wrap {
    width: 100%;
    height: 100%;
}

.gallery-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.5s ease;
}

.gallery-item:hover .gallery-img-wrap img {
    transform: scale(1.08);
}

.gallery-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 20px;
    background: linear-gradient(to top, rgba(0,0,0,0.92) 0%, rgba(0,0,0,0.4) 60%, transparent 100%);
    transform: translateY(10px);
    opacity: 0.85;
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

/* Empty state cards */
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

.gallery-note {
    text-align: center;
    margin-top: 50px;
    color: #888;
    font-size: 0.95rem;
}

.gallery-note i {
    color: #f5c518;
    margin-right: 6px;
}

/* Responsive */
@media (max-width: 768px) {
    .gallery-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
}

@media (max-width: 480px) {
    .gallery-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php require_once 'includes/footer.php'; ?>