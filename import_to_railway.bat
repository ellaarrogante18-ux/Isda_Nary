@echo off
echo ========================================
echo Importing Database to Railway MySQL
echo ========================================
echo.

echo Connecting to Railway MySQL and importing database...
echo Host: trolley.proxy.rlwy.net
echo Port: 59804
echo Database: railway
echo.

REM Import database to Railway
C:\xampp\mysql\bin\mysql.exe -h trolley.proxy.rlwy.net -P 59804 -u root -pIwVhAKRuIkPfGZwbvQjowkGgPmjCPrhs railway < database_exports\fish_inventory_20251122_005542.sql

if %ERRORLEVEL% == 0 (
    echo.
    echo ========================================
    echo ✓ Database imported successfully!
    echo ========================================
    echo.
    echo Your IsdaNary database is now on Railway!
    echo Tables imported:
    echo - users (3 records)
    echo - fish (7 records) 
    echo - sales (3 records)
    echo - expenses (3 records)
    echo - migrations
    echo - personal_access_tokens
    echo.
) else (
    echo.
    echo ========================================
    echo ✗ Import failed!
    echo ========================================
    echo.
    echo Possible issues:
    echo 1. Network connection
    echo 2. Railway database credentials changed
    echo 3. File path issue
    echo.
    echo Trying alternative method...
    echo.
    
    REM Try connecting first to test connection
    echo Testing connection to Railway...
    C:\xampp\mysql\bin\mysql.exe -h trolley.proxy.rlwy.net -P 59804 -u root -pIwVhAKRuIkPfGZwbvQjowkGgPmjCPrhs railway -e "SHOW TABLES;"
)

echo.
pause
