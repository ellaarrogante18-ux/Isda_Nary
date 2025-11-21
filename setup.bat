@echo off
echo ========================================
echo Fish Inventory System Setup
echo ========================================
echo.

echo Step 1: Installing PHP dependencies...
call composer install
if %errorlevel% neq 0 (
    echo Error: Composer install failed. Please make sure Composer is installed.
    pause
    exit /b 1
)

echo.
echo Step 2: Installing Node.js dependencies...
call npm install
if %errorlevel% neq 0 (
    echo Error: npm install failed. Please make sure Node.js is installed.
    pause
    exit /b 1
)

echo.
echo Step 3: Setting up environment file...
if not exist .env (
    copy .env.example .env
    echo Environment file created from .env.example
) else (
    echo Environment file already exists
)

echo.
echo Step 4: Generating application key...
call php artisan key:generate
if %errorlevel% neq 0 (
    echo Error: Failed to generate application key.
    pause
    exit /b 1
)

echo.
echo Step 5: Building assets...
call npm run build
if %errorlevel% neq 0 (
    echo Error: Asset build failed.
    pause
    exit /b 1
)

echo.
echo ========================================
echo Setup completed successfully!
echo ========================================
echo.
echo Next steps:
echo 1. Create a MySQL database named 'fish_inventory'
echo 2. Update database credentials in .env file
echo 3. Run: php artisan migrate
echo 4. Run: php artisan storage:link
echo 5. Start the server: php artisan serve
echo.
echo For detailed instructions, see README.md
echo.
pause
