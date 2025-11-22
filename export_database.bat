@echo off
echo ========================================
echo IsdaNary Database Export Script
echo ========================================
echo.

REM Check if XAMPP MySQL is running
echo Checking if XAMPP MySQL is running...
tasklist /FI "IMAGENAME eq mysqld.exe" 2>NUL | find /I /N "mysqld.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo ✓ MySQL is running
) else (
    echo ✗ MySQL is not running
    echo Please start XAMPP MySQL service first!
    pause
    exit /b 1
)

echo.
echo Exporting fish_inventory database...
echo.

REM Set the path to XAMPP MySQL bin directory
set MYSQL_PATH=C:\xampp\mysql\bin

REM Create exports directory if it doesn't exist
if not exist "database_exports" mkdir database_exports

REM Get current date for filename
for /f "tokens=2 delims==" %%a in ('wmic OS Get localdatetime /value') do set "dt=%%a"
set "YY=%dt:~2,2%" & set "YYYY=%dt:~0,4%" & set "MM=%dt:~4,2%" & set "DD=%dt:~6,2%"
set "HH=%dt:~8,2%" & set "Min=%dt:~10,2%" & set "Sec=%dt:~12,2%"
set "datestamp=%YYYY%%MM%%DD%_%HH%%Min%%Sec%"

REM Export database
echo Exporting to: database_exports\fish_inventory_%datestamp%.sql
"%MYSQL_PATH%\mysqldump.exe" -u root -p fish_inventory > "database_exports\fish_inventory_%datestamp%.sql"

if %ERRORLEVEL% == 0 (
    echo.
    echo ========================================
    echo ✓ Database exported successfully!
    echo ========================================
    echo File location: database_exports\fish_inventory_%datestamp%.sql
    echo.
    echo You can now use this file to:
    echo 1. Import to production database
    echo 2. Upload to hosting provider
    echo 3. Use with deployment services
    echo.
) else (
    echo.
    echo ========================================
    echo ✗ Export failed!
    echo ========================================
    echo Please check:
    echo 1. XAMPP MySQL is running
    echo 2. fish_inventory database exists
    echo 3. You have the correct password
    echo.
)

echo Press any key to open the exports folder...
pause >nul
explorer database_exports

echo.
echo Script completed!
pause
