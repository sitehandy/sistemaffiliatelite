# Affiliate Management System

A complete affiliate marketing management system built with Laravel 12. Manage your affiliate programs, track conversions, and handle payouts all in one place.

## Repository

**GitHub:** [https://github.com/sitehandy/sistemaffiliatelite](https://github.com/sitehandy/sistemaffiliatelite)

Clone the repository:
```bash
git clone https://github.com/sitehandy/sistemaffiliatelite.git
cd sistemaffiliatelite
```

## Features

### For Administrators
- **Program Management** - Create and manage multiple affiliate programs (Pay Per Sale, Pay Per Lead, Pay Per View)
- **Product Management** - Add products with images, prices, and associate them with programs
- **Affiliate Management** - Approve/reject affiliates, manage enrollments, view performance
- **Commission Tracking** - Track all conversions and commissions with detailed reports
- **Payout Management** - Process affiliate payouts via multiple payment methods
- **Reports & Analytics** - Comprehensive reports on sales, affiliates, and program performance
- **System Settings** - Configure app settings, mail settings, cookie duration, and more
- **Announcements** - Send announcements to all affiliates

### For Affiliates
- **Dashboard** - View earnings, clicks, conversions at a glance
- **Program Discovery** - Browse and join available affiliate programs
- **Tracking Links** - Generate unique tracking links for products
- **Commission Reports** - Track all earned commissions and their status
- **Payout Requests** - Request payouts when balance reaches minimum threshold
- **Payment Methods** - Manage payment methods (PayPal, Bank Transfer, etc.)

### Integration Features
- **Easy Integration** - Simple JavaScript snippet or API for your e-commerce site
- **Multiple Platforms** - Supports WooCommerce, Shopify, Laravel, and custom integrations
- **Webhook Support** - Receive real-time notifications for conversions
- **Cookie-Based Tracking** - Configurable cookie duration (default 30 days)
- **API Access** - Full REST API for advanced integrations

## Requirements

- PHP 8.2 or higher
- MySQL 5.7+ / MariaDB 10.3+
- Composer
- Node.js & NPM (for asset compilation)
- Required PHP Extensions:
  - BCMath
  - Ctype
  - JSON
  - Mbstring
  - OpenSSL
  - PDO
  - Tokenizer
  - XML
  - cURL
  - Fileinfo

## Installation

### Video Tutorial

Watch the complete installation guide:

**[Click here to watch Installation Video Tutorial](https://screenrec.com/share/PVAWoIjiJQ)**

### Quick Installation (Web Installer)

1. **Upload Files**
   - Upload all files to your web server
   - Point your domain to the `public` folder

2. **Create Database**
   - Create an empty MySQL database
   - Note down the database name, username, and password

3. **Run Web Installer**
   - Navigate to `https://yourdomain.com/install`
   - Accept the Terms & Conditions
   - Follow the installation wizard:
     - Step 1: Accept Terms & Conditions
     - Step 2: Server Requirements Check
     - Step 3: Database Configuration
     - Step 4: Create Admin Account
     - Step 5: Installation Complete

4. **Login**
   - Go to `https://yourdomain.com/login`
   - Login with your admin credentials

### Shared Hosting Installation (cPanel/DirectAdmin)

If you're using shared hosting where you cannot change the document root:

1. **Upload Files to public_html**
   - Upload ALL files directly to `public_html` folder
   - The `.htaccess` file in root will automatically redirect to `/public`

2. **Create Database**
   - Go to cPanel > MySQL Databases
   - Create a new database and user
   - Assign user to database with ALL PRIVILEGES

3. **Set Permissions**
   - Set `storage/` folder permission to `775` or `777`
   - Set `bootstrap/cache/` folder permission to `775` or `777`

4. **Run Web Installer**
   - Navigate to `https://yourdomain.com/install`
   - Follow the installation wizard

**Folder Structure for Shared Hosting:**
```
public_html/
├── .htaccess          # Redirects to /public (included)
├── .env               # Will be created by installer
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
│   ├── .htaccess      # Laravel's htaccess
│   └── index.php      # Entry point
├── resources/
├── routes/
├── storage/
└── vendor/
```

> **Note:** The root `.htaccess` file protects sensitive files (`.env`, `composer.json`, etc.) and blocks direct access to `app/`, `config/`, `storage/`, and other sensitive directories.

### Manual Installation (Developer)

```bash
# Clone or extract files
cd sistemaffiliate

# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure your .env file with database credentials
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=your_database
# DB_USERNAME=your_username
# DB_PASSWORD=your_password

# Run migrations
php artisan migrate

# Seed the database
php artisan db:seed

# Install NPM dependencies (optional, for development)
npm install
npm run build

# Set proper permissions
chmod -R 775 storage bootstrap/cache

# Create storage symlink
php artisan storage:link
```

## Configuration

### Mail Settings

Configure mail settings in Admin Panel > Settings > Mail Setup, or manually in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="Your App Name"
```

### Cookie Duration

Configure default cookie duration in Admin Panel > Settings > General Settings.

### Demo Mode

Enable demo mode to protect your live demo from unauthorized changes:

```env
DEMO_MODE=true
```

When `DEMO_MODE=true`:
- Admin configuration cannot be updated (Settings pages)
- Admin profile cannot be modified
- Prevents unauthorized changes to system settings on live demos
- Default is `false` for normal operation

**Note:** Set `DEMO_MODE=false` in production environments where you need full admin access.

## Integration Guide

### JavaScript Snippet (Recommended)

Add this to your website's `<head>`:

```html
<script>
(function() {
    var urlParams = new URLSearchParams(window.location.search);
    var ref = urlParams.get('ref');
    if (ref) {
        document.cookie = 'ref=' + ref + '; max-age=' + (30*24*60*60) + '; path=/';
    }
})();
</script>
```

### Recording Conversions

When a sale is completed:

```javascript
// JavaScript
fetch('https://yourdomain.com/api/track/conversion', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        tracking_code: getCookie('ref'),
        order_id: 'ORDER-123',
        amount: 99.99,
        type: 'sale'
    })
});
```

```php
// PHP
$response = Http::post('https://yourdomain.com/api/track/conversion', [
    'tracking_code' => $_COOKIE['ref'] ?? null,
    'order_id' => $order->id,
    'amount' => $order->total,
    'type' => 'sale'
]);
```

For detailed integration guides (WooCommerce, Shopify, Laravel), see **Admin Panel > Integration Guide**.

## Upgrading

### Web UI Upgrade (Recommended for Shared Hosting)

If you don't have SSH/terminal access:

```
┌─────────────────────────────────────────────────────────────┐
│  STEP 1: Upload New Files (Manual)                          │
│  - Download latest version (zip from GitHub)                │
│  - Upload/overwrite to server via FTP/File Manager          │
│  - DO NOT overwrite: .env, storage/installed                │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│  STEP 2: Click "Run System Upgrade" (Web UI)                │
│  - Run pending database migrations                          │
│  - Clear all cache                                          │
│  - Update version in database                               │
└─────────────────────────────────────────────────────────────┘
```

**Detailed Steps:**

1. **Upload New Files First**
   - Download the latest version from GitHub
   - Upload/overwrite files to your server via FTP or cPanel File Manager
   - **DO NOT overwrite:** `.env`, `storage/installed`, and `storage/` folder contents

2. **Run Upgrade via Web UI**
   - Login as Admin
   - Go to **Settings > System Upgrade**
   - Click **"Run System Upgrade"** to run pending migrations and clear cache

> **Important:** The Web UI only runs migrations and clears cache. It does NOT download files automatically. You must upload the new files first before clicking upgrade.

### Developer Upgrade (Terminal)

```bash
# Pull latest changes
git pull origin master

# Update dependencies
composer install --no-dev --optimize-autoloader

# Run migrations
php artisan migrate --force

# Clear cache
php artisan optimize:clear

# Rebuild cache (production)
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

For detailed upgrade instructions, see [docs/upgrade-guide.md](docs/upgrade-guide.md).

## Folder Structure

```
sistemaffiliate/
├── app/                    # Application code
│   ├── Http/Controllers/   # Web and API controllers
│   ├── Models/             # Eloquent models
│   └── Services/           # Business logic services
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/            # Database seeders
├── docs/                   # Documentation
├── examples/               # Integration examples
├── landing-pages/          # Static landing pages
├── public/                 # Public assets (point domain here)
├── resources/
│   └── views/              # Blade templates
├── routes/
│   ├── web.php             # Web routes
│   └── api.php             # API routes
└── storage/                # Uploads, logs, cache
```

## API Endpoints

### Public Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/track/{code}` | Track click & redirect |
| GET | `/api/track/{code}` | Track click (JSON response) |
| POST | `/api/track/conversion` | Record conversion |

### Authenticated Endpoints

See `routes/api.php` for full API documentation.

## Security

- Always use HTTPS in production
- Keep `APP_DEBUG=false` in production
- Regularly update dependencies
- Use strong admin passwords
- Configure proper file permissions

## Support

For support and questions:
- Documentation: `docs/` folder
- Video Tutorial: [Installation Video](https://screenrec.com/share/PVAWoIjiJQ)

## License

This software is proprietary. See the Terms & Conditions during installation for usage rights.

## Copyright & Disclaimer

Copyright © SistemAffiliate.com and SiteHandy Solutions (sitehandy.com). All rights reserved.

- The system is provided as a self-hosted free version for your own use. Use at your own risk. No warranty for the free version.
- Support, installation, and customization are available as paid services. Charges depend on scope.
- The free version may be time-limited and can be converted to a paid version in the future.
- All trademarks and logos are the property of their respective owners.
- Refer to the Terms & Conditions during installation for full usage rights and limitations.

---

**Powered by [Sistem Affiliate](https://sistemaffiliate.com)**
