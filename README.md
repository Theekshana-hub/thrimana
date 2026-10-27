# Thrimana Advertising & Construction Services
## Ruhunu Iron Works Website

Premium PHP website with Admin Dashboard for **www.ruhunuironworks.site**

### Features
- Modern dark theme matching the logo (black + gold + red accents)
- Smooth AOS animations + custom CSS animations
- Responsive design (mobile friendly)
- SQLite database (no MySQL needed)
- Full Admin Dashboard:
  - Edit homepage & about content
  - Manage services (add/edit/delete)
  - Upload & manage gallery images
  - View contact form messages
  - Site settings (phone, email, social links)

### Admin Login
- **URL**: `/admin/`
- **Username**: `admin`
- **Password**: `Thrimana@2026`

### How to Deploy
1. Upload the entire `ruhunuironworks` folder to your web hosting (public_html or domain root).
2. Make sure the `data/` and `assets/uploads/` folders are writable (chmod 755 or 775).
3. Point domain **www.ruhunuironworks.site** to this folder.
4. Open the site in browser. Database will auto-create on first visit.

### Local Testing
```bash
cd ruhunuironworks
php -S localhost:8000
```
Then open http://localhost:8000

### Folder Structure
```
ruhunuironworks/
├── index.php, about.php, services.php, gallery.php, contact.php
├── assets/
│   ├── css/style.css
│   ├── js/main.js
│   ├── images/logo.png
│   └── uploads/          ← gallery images go here
├── admin/                ← Admin panel
├── includes/             ← config, db, header, footer
└── data/                 ← SQLite database (auto created)
```

### Change Admin Password
Edit `includes/config.php` and update the `ADMIN_PASSWORD_HASH` value.
Generate a new hash with:
```php
echo password_hash('YourNewPassword', PASSWORD_DEFAULT);
```

---
Built with pure PHP + SQLite + modern CSS/JS. No React/Node required.
