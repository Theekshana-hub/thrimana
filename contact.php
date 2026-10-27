<?php
$page_title = 'Contact';
$page_desc = 'Contact Thrimana Advertising & Construction Services';
require_once 'includes/header.php';

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        try {
            addMessage($name, $email, $phone, $subject, $message);
            $success = true;
        } catch (Exception $e) {
            $error = 'Something went wrong. Please try again later.';
        }
    }
}
?>

<section class="page-hero">
    <div class="container">
        <h1 data-aos="fade-up">Contact Us</h1>
        <p data-aos="fade-up" data-aos-delay="100">We’d love to hear about your project</p>
        <div class="breadcrumb" data-aos="fade-up" data-aos-delay="150">
            <a href="index.php">Home</a> &nbsp;/&nbsp; Contact
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-info-cards" data-aos="fade-right">
                <div class="contact-card">
                    <div class="icon"><i class="fas fa-phone-alt"></i></div>
                    <div>
                        <h4>Phone</h4>
                        <p><?php echo htmlspecialchars(getSetting('phone', SITE_PHONE)); ?></p>
                    </div>
                </div>
                <div class="contact-card">
                    <div class="icon"><i class="fas fa-envelope"></i></div>
                    <div>
                        <h4>Email</h4>
                        <p><?php echo htmlspecialchars(getSetting('email', SITE_EMAIL)); ?></p>
                    </div>
                </div>
                <div class="contact-card">
                    <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <h4>Location</h4>
                        <p><?php echo htmlspecialchars(getSetting('address', SITE_ADDRESS)); ?></p>
                    </div>
                </div>
                <div class="contact-card">
                    <div class="icon"><i class="fab fa-whatsapp"></i></div>
                    <div>
                        <h4>WhatsApp</h4>
                        <p>
                            <a href="https://wa.me/<?php echo getSetting('whatsapp'); ?>" target="_blank" style="color:var(--primary);">
                                Chat with us instantly
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="contact-form" data-aos="fade-left">
                <h3 style="margin-bottom:24px;font-size:1.4rem;">Send us a Message</h3>
                
                <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> Thank you! Your message has been sent successfully. We will contact you soon.
                </div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                </div>
                <?php endif; ?>
                
                <?php if (!$success): ?>
                <form method="POST" action="">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Your Name *</label>
                            <input type="text" name="name" required value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label>Email Address *</label>
                            <input type="email" name="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" name="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label>Subject</label>
                            <input type="text" name="subject" value="<?php echo htmlspecialchars($_POST['subject'] ?? ''); ?>" placeholder="e.g. Gate quotation">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Your Message *</label>
                        <textarea name="message" rows="5" required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
