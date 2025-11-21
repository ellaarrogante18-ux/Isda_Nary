@echo off
echo ========================================
echo Fish Inventory System - Simple Setup
echo ========================================
echo.

echo Clearing composer cache...
composer clear-cache

echo.
echo Removing existing vendor folder...
if exist vendor rmdir /s /q vendor

echo.
echo Installing PHP dependencies (no scripts)...
composer install --no-scripts --no-dev
if %errorlevel% neq 0 (
    echo Error: Basic composer install failed.
    pause
    exit /b 1
)

echo.
echo Setting up environment file...
if not exist .env (
    copy .env.example .env
    echo Environment file created
)

echo.
echo Generating application key...
php artisan key:generate --force

echo.
echo Installing Node.js dependencies...
npm install

echo.
echo Building assets...
npm run build

echo.
echo ========================================
echo Setup completed!
echo ========================================
echo.
echo Next steps:
echo 1. Create MySQL database 'fish_inventory'
echo 2. Update .env with database credentials
echo 3. Run: php artisan migrate
echo 4. Run: php artisan storage:link
echo 5. Start: php artisan serve
echo.
pause
