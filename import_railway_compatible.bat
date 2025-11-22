@echo off
echo ========================================
echo Railway MySQL Import - Compatible Mode
echo ========================================
echo.

echo Trying with SSL and compatibility options...
echo.

REM Try with SSL disabled and old authentication
C:\xampp\mysql\bin\mysql.exe --ssl-mode=DISABLED --default-auth=mysql_native_password -h trolley.proxy.rlwy.net -P 59804 -u root -pIwVhAKRuIkPfGZwbvQjowkGgPmjCPrhs railway < database_exports\fish_inventory_20251122_005542.sql

if %ERRORLEVEL% == 0 (
    echo ✓ Import successful with compatibility mode!
) else (
    echo ✗ Still having issues. Let's try manual connection...
    echo.
    echo Opening MySQL connection for manual import...
    echo Copy and paste your SQL content when connected.
    echo.
    C:\xampp\mysql\bin\mysql.exe --ssl-mode=DISABLED --default-auth=mysql_native_password -h trolley.proxy.rlwy.net -P 59804 -u root -pIwVhAKRuIkPfGZwbvQjowkGgPmjCPrhs railway
)

pause
