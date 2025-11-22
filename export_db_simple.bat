@echo off
echo ========================================
echo Simple Database Export for Railway
echo ========================================
echo.

REM Create exports directory if it doesn't exist
if not exist "database_exports" mkdir database_exports

REM Get current timestamp
for /f "tokens=2 delims==" %%a in ('wmic OS Get localdatetime /value') do set "dt=%%a"
set "YY=%dt:~2,2%" & set "YYYY=%dt:~0,4%" & set "MM=%dt:~4,2%" & set "DD=%dt:~6,2%"
set "HH=%dt:~8,2%" & set "Min=%dt:~10,2%" & set "Sec=%dt:~12,2%"
set "datestamp=%YYYY%%MM%%DD%_%HH%%Min%%Sec%"

echo Exporting fish_inventory database...
echo File will be saved as: database_exports\fish_inventory_%datestamp%.sql
echo.

REM Export without password (assuming default XAMPP setup)
C:\xampp\mysql\bin\mysqldump.exe -u root fish_inventory > "database_exports\fish_inventory_%datestamp%.sql"

if %ERRORLEVEL% == 0 (
    echo.
    echo ✓ Export successful!
    echo File: database_exports\fish_inventory_%datestamp%.sql
    echo.
    echo File size:
    dir "database_exports\fish_inventory_%datestamp%.sql" | find "fish_inventory"
    echo.
    echo You can now import this file to Railway MySQL.
) else (
    echo.
    echo ✗ Export failed. Trying with password prompt...
    echo Please enter your MySQL root password when prompted:
    C:\xampp\mysql\bin\mysqldump.exe -u root -p fish_inventory > "database_exports\fish_inventory_%datestamp%.sql"
)

echo.
pause
