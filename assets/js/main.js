// Thrimana / Ruhunu Iron Works - Main JS

document.addEventListener('DOMContentLoaded', function () {
    // Preloader
    const preloader = document.getElementById('preloader');
    window.addEventListener('load', () => {
        setTimeout(() => {
            if (preloader) preloader.classList.add('hide');
        }, 800);
    });
    // Fallback
    setTimeout(() => {
        if (preloader) preloader.classList.add('hide');
    }, 2500);

    // Navbar scroll
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Mobile menu
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.getElementById('nav-menu');
    if (hamburger && navMenu) {
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
        });

        // Close on link click
        navMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                hamburger.classList.remove('active');
                navMenu.classList.remove('active');
            });
        });
    }

    // Back to top
    const backToTop = document.getElementById('back-to-top');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 400) {
            backToTop.classList.add('show');
        } else {
            backToTop.classList.remove('show');
        }
    });
    if (backToTop) {
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // Counter animation
    const counters = document.querySelectorAll('.stat-number');
    const animateCounter = (el) => {
        const target = parseInt(el.getAttribute('data-target') || el.textContent);
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                el.textContent = target + (el.getAttribute('data-suffix') || '');
                clearInterval(timer);
            } else {
                el.textContent = Math.floor(current) + (el.getAttribute('data-suffix') || '');
            }
        }, 16);
    };

    const observerOptions = { threshold: 0.5 };
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                counterObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);

    counters.forEach(c => counterObserver.observe(c));

    // AOS
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 80
        });
    }

    // Gallery lightbox (simple)
    document.querySelectorAll('.gallery-item').forEach(item => {
        item.addEventListener('click', function () {
            const img = this.querySelector('img');
            if (!img) return;
            const lightbox = document.createElement('div');
            lightbox.className = 'lightbox';
            lightbox.innerHTML = `
                <div class="lightbox-content">
                    <img src="${img.src}" alt="">
                    <button class="lightbox-close">&times;</button>
                </div>
            `;
            document.body.appendChild(lightbox);
            document.body.style.overflow = 'hidden';
            
            // Style
            lightbox.style.cssText = 'position:fixed;inset:0;background:rgba(0,0,0,0.95);z-index:9999;display:flex;align-items:center;justify-content:center;animation:fadeIn 0.3s;';
            const content = lightbox.querySelector('.lightbox-content');
            content.style.cssText = 'position:relative;max-width:90%;max-height:90%;';
            content.querySelector('img').style.cssText = 'max-width:100%;max-height:85vh;border-radius:8px;';
            const closeBtn = lightbox.querySelector('.lightbox-close');
            closeBtn.style.cssText = 'position:absolute;top:-40px;right:0;background:none;border:none;color:white;font-size:2.5rem;cursor:pointer;';
            
            const close = () => {
                lightbox.remove();
                document.body.style.overflow = '';
            };
            closeBtn.addEventListener('click', close);
            lightbox.addEventListener('click', (e) => { if (e.target === lightbox) close(); });
        });
    });
});

// Add fadeIn keyframe dynamically
const style = document.createElement('style');
style.textContent = `@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }`;
document.head.appendChild(style);
