# 🚀 IsdaNary Deployment Guide

This guide will help you deploy your IsdaNary Fish Inventory System to various hosting platforms.

## 🎯 Deployment Options

### 1. 🌐 **Netlify** (Recommended for Static/Frontend)
### 2. 🔥 **Heroku** (Full-Stack with Database)
### 3. 🌊 **DigitalOcean** (VPS Hosting)
### 4. ⚡ **Vercel** (Modern Deployment)
### 5. 🏠 **Shared Hosting** (cPanel/Traditional)

---

## 🔥 Option 1: Heroku Deployment (Recommended)

Heroku is perfect for Laravel applications with database support.

### Prerequisites
1. **Heroku Account**: Sign up at https://heroku.com
2. **Heroku CLI**: Download from https://devcenter.heroku.com/articles/heroku-cli

### Step-by-Step Heroku Deployment

#### 1. Prepare Your Application

Create a `Procfile` in your project root:
```
web: vendor/bin/heroku-php-apache2 public/
```

#### 2. Update Composer.json
Add to your `composer.json` in the scripts section:
```json
{
    "scripts": {
        "post-install-cmd": [
            "php artisan clear-compiled",
            "php artisan optimize",
            "chmod -R 755 storage"
        ]
    }
}
```

#### 3. Environment Configuration
Create production environment variables on Heroku:
```bash
# Login to Heroku
heroku login

# Create Heroku app
heroku create your-isdanary-app

# Set environment variables
heroku config:set APP_NAME="IsdaNary"
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
heroku config:set APP_URL=https://your-isdanary-app.herokuapp.com

# Generate app key
heroku config:set APP_KEY=$(php artisan --no-ansi key:generate --show)

# Database (Heroku will provide)
heroku addons:create heroku-postgresql:hobby-dev
```

#### 4. Deploy to Heroku
```bash
# Add Heroku remote
heroku git:remote -a your-isdanary-app

# Push to Heroku
git push heroku main

# Run migrations
heroku run php artisan migrate --force

# Create storage link
heroku run php artisan storage:link
```

---

## 🌐 Option 2: Netlify Deployment

Netlify is great for frontend deployment, but requires API backend setup.

### Step 1: Build for Production
```bash
npm run build
```

### Step 2: Deploy to Netlify
1. Go to https://netlify.com
2. Connect your GitHub repository
3. Set build settings:
   - **Build command**: `npm run build`
   - **Publish directory**: `public`

### Step 3: Configure Redirects
Create `public/_redirects` file:
```
/*    /index.html   200
```

---

## 🌊 Option 3: DigitalOcean Droplet

For full control over your server environment.

### Step 1: Create Droplet
1. Sign up at https://digitalocean.com
2. Create a new Droplet (Ubuntu 20.04 LTS)
3. Choose size based on your needs ($5/month minimum)

### Step 2: Server Setup
```bash
# Connect via SSH
ssh root@your_server_ip

# Update system
apt update && apt upgrade -y

# Install LAMP stack
apt install apache2 mysql-server php8.1 php8.1-mysql php8.1-xml php8.1-gd php8.1-curl php8.1-zip unzip -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
apt-get install -y nodejs
```

### Step 3: Deploy Application
```bash
# Clone your repository
cd /var/www/html
git clone https://github.com/yourusername/isdanary-fish-inventory.git
cd isdanary-fish-inventory

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run build

# Set permissions
chown -R www-data:www-data /var/www/html/isdanary-fish-inventory
chmod -R 755 storage bootstrap/cache
```

---

## ⚡ Option 4: Vercel Deployment

Modern serverless deployment platform.

### Step 1: Install Vercel CLI
```bash
npm i -g vercel
```

### Step 2: Configure for Laravel
Create `vercel.json`:
```json
{
  "version": 2,
  "builds": [
    { "src": "public/**", "use": "@vercel/static" },
    { "src": "api/**/*.php", "use": "@vercel/php" }
  ],
  "routes": [
    { "src": "/(.*)", "dest": "public/$1" }
  ]
}
```

### Step 3: Deploy
```bash
vercel --prod
```

---

## 🏠 Option 5: Shared Hosting (cPanel)

Traditional web hosting with cPanel interface.

### Step 1: Prepare Files
1. Zip your entire project
2. Upload via cPanel File Manager
3. Extract in `public_html` directory

### Step 2: Configure
1. Move Laravel files outside `public_html`
2. Move `public` folder contents to `public_html`
3. Update `index.php` paths:
```php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
```

### Step 3: Database Setup
1. Create MySQL database in cPanel
2. Import your SQL file
3. Update `.env` with hosting database credentials

---

## 🛠️ Pre-Deployment Checklist

### ✅ Code Preparation
- [ ] Remove debug statements and `dd()` functions
- [ ] Set `APP_DEBUG=false` in production
- [ ] Update `APP_URL` to your domain
- [ ] Optimize autoloader: `composer install --optimize-autoloader --no-dev`
- [ ] Clear and cache config: `php artisan config:cache`
- [ ] Cache routes: `php artisan route:cache`
- [ ] Cache views: `php artisan view:cache`

### ✅ Security
- [ ] Generate new `APP_KEY` for production
- [ ] Use strong database passwords
- [ ] Enable HTTPS/SSL
- [ ] Set proper file permissions (755 for directories, 644 for files)
- [ ] Remove `.env` from version control (already in .gitignore)

### ✅ Database
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Seed initial data if needed: `php artisan db:seed`
- [ ] Backup database regularly

### ✅ Storage
- [ ] Create storage symlink: `php artisan storage:link`
- [ ] Set proper storage permissions
- [ ] Configure file upload limits

---

## 🌍 Domain and DNS Setup

### Custom Domain Configuration
1. **Purchase Domain** (Namecheap, GoDaddy, etc.)
2. **Configure DNS**:
   - Point A record to your server IP
   - Add CNAME for www subdomain
3. **SSL Certificate**:
   - Use Let's Encrypt (free)
   - Or hosting provider SSL

### Example DNS Records
```
Type    Name    Value
A       @       your.server.ip.address
CNAME   www     yourdomain.com
```

---

## 📊 Monitoring and Maintenance

### Performance Monitoring
- Set up application monitoring (New Relic, Sentry)
- Monitor server resources (CPU, RAM, disk space)
- Set up uptime monitoring

### Regular Maintenance
- **Daily**: Check error logs
- **Weekly**: Database backup
- **Monthly**: Security updates
- **Quarterly**: Performance optimization

### Backup Strategy
```bash
# Database backup
mysqldump -u username -p database_name > backup_$(date +%Y%m%d).sql

# File backup
tar -czf files_backup_$(date +%Y%m%d).tar.gz /path/to/your/app
```

---

## 🚨 Troubleshooting Common Issues

### 1. **500 Internal Server Error**
- Check Apache/Nginx error logs
- Verify file permissions
- Check `.env` configuration
- Run `php artisan config:clear`

### 2. **Database Connection Issues**
- Verify database credentials
- Check database server status
- Ensure database exists

### 3. **File Upload Issues**
- Check `upload_max_filesize` in php.ini
- Verify storage permissions
- Check disk space

### 4. **Performance Issues**
- Enable caching (Redis/Memcached)
- Optimize database queries
- Use CDN for static assets

---

## 🎉 Post-Deployment Steps

### 1. Test Everything
- [ ] User registration/login
- [ ] Fish inventory CRUD operations
- [ ] Sales recording with discounts
- [ ] Search functionality
- [ ] File uploads
- [ ] All filters and reports

### 2. Set Up Analytics
- Google Analytics
- Application performance monitoring
- Error tracking

### 3. Documentation
- Update README with live URL
- Document any deployment-specific configurations
- Create user manual if needed

---

## 🌟 Recommended Deployment: Heroku

For beginners, I recommend **Heroku** because:
- ✅ Easy deployment process
- ✅ Automatic HTTPS
- ✅ Built-in database
- ✅ Free tier available
- ✅ Excellent Laravel support
- ✅ Automatic backups

---

**Your IsdaNary Fish Inventory System will be live and helping fish vendors manage their business! 🌊🐟🚀**
