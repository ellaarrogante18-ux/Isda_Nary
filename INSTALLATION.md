# Quick Installation Guide

## Prerequisites
- XAMPP with PHP 8.1+ and MySQL
- Composer (PHP package manager)
- Node.js and npm

## Quick Setup (Windows)

1. **Run the setup script:**
   ```cmd
   setup.bat
   ```

2. **Create database:**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create database named `fish_inventory`

3. **Configure database:**
   - Edit `.env` file
   - Update database settings:
   ```env
   DB_DATABASE=fish_inventory
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Run migrations:**
   ```cmd
   php artisan migrate
   ```

5. **Create storage link:**
   ```cmd
   php artisan storage:link
   ```

6. **Start the application:**
   ```cmd
   php artisan serve
   ```

7. **Access the application:**
   - Open browser: http://localhost:8000
   - Or via XAMPP: http://localhost/fish_inventory/public

## Manual Installation

If the setup script doesn't work, follow these steps:

```cmd
# Install dependencies
composer install
npm install

# Setup environment
copy .env.example .env
php artisan key:generate

# Build assets
npm run build

# Setup database (after creating database)
php artisan migrate
php artisan storage:link

# Start server
php artisan serve
```

## Default Login
After installation, register a new account at:
http://localhost:8000/register

## Troubleshooting

### Common Issues:
1. **Composer not found**: Install Composer from https://getcomposer.org
2. **npm not found**: Install Node.js from https://nodejs.org
3. **Database connection error**: Check MySQL is running and credentials are correct
4. **Permission errors**: Make sure storage/ folder is writable

### File Permissions (if needed):
```cmd
# Make storage writable
chmod -R 775 storage bootstrap/cache
```

## System Requirements

- **PHP**: 8.1 or higher
- **MySQL**: 5.7+ or MariaDB 10.3+
- **Memory**: 512MB minimum
- **Disk Space**: 100MB for application + space for uploaded images

## Dependencies Installed

### PHP Packages (via Composer):
- Laravel Framework 10.x
- Laravel UI for authentication
- Laravel Sanctum for API authentication

### Node.js Packages (via npm):
- Tailwind CSS for styling
- Vite for asset building
- Alpine.js for interactive components

## Next Steps

1. **Create your first fish entry**
2. **Record a sale**
3. **Add some expenses**
4. **Explore the dashboard**

For detailed usage instructions, see README.md
