@echo off
echo ========================================
echo IsdaNary App Key Generator
echo ========================================
echo.

echo Generating new Laravel application key...
echo.

php artisan key:generate --show

echo.
echo ========================================
echo Copy the key above (including base64:)
echo and use it as APP_KEY in Railway
echo ========================================
echo.
pause
