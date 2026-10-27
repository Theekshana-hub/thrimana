    <!-- Footer -->
    <footer class="footer">
        <div class="footer-top">
            <div class="container">
                <div class="footer-grid">
                    <div class="footer-brand" data-aos="fade-up">
                        <img src="<?php echo ASSETS_URL; ?>/images/logo.png" alt="Thrimana" class="footer-logo">
                        <h3>THRIMANA</h3>
                        <p>Advertising & Construction Services<br>Ruhunu Iron Works</p>
                        <div class="social-links">
                            <a href="<?php echo getSetting('facebook'); ?>" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="<?php echo getSetting('instagram'); ?>" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="https://wa.me/<?php echo getSetting('whatsapp'); ?>" target="_blank" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                    
                    <div class="footer-links" data-aos="fade-up" data-aos-delay="100">
                        <h4>Quick Links</h4>
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="about.php">About Us</a></li>
                            <li><a href="services.php">Services</a></li>
                            <li><a href="gallery.php">Gallery</a></li>
                            <li><a href="contact.php">Contact</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-services" data-aos="fade-up" data-aos-delay="200">
                        <h4>Our Services</h4>
                        <ul>
                            <li><a href="services.php">Iron Works & Fabrication</a></li>
                            <li><a href="services.php">Advertising & Signage</a></li>
                            <li><a href="services.php">Construction</a></li>
                            <li><a href="services.php">Metal Design</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-contact" data-aos="fade-up" data-aos-delay="300">
                        <h4>Contact Us</h4>
                        <ul>
                            <li><i class="fas fa-phone"></i> <?php echo getSetting('phone', SITE_PHONE); ?></li>
                            <li><i class="fas fa-envelope"></i> <?php echo getSetting('email', SITE_EMAIL); ?></li>
                            <li><i class="fas fa-map-marker-alt"></i> <?php echo getSetting('address', SITE_ADDRESS); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="container">
                <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All Rights Reserved. | Designed for excellence.</p>
            </div>
        </div>
    </footer>

    <!-- Back to top -->
    <button id="back-to-top" aria-label="Back to top"><i class="fas fa-chevron-up"></i></button>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="<?php echo ASSETS_URL; ?>/js/main.js"></script>
</body>
</html>
