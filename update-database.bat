@echo off
REM Employee Access Management System - Update Database Script
REM This script updates the database with the new approval workflow features

echo ========================================
echo EAMS - Database Update (v2.0)
echo ========================================
echo.
echo This will:
echo  - Drop the old database
echo  - Create a new database with approval workflow
echo  - Create admin account: admin@system.local / admin12345
echo.
echo WARNING: This will delete all existing data!
echo.

set /p confirm="Are you sure? (Y/N): "
if /i not "%confirm%"=="Y" (
    echo Cancelled.
    exit /b 0
)

echo.
echo Importing database...

"C:\Program Files\MariaDB 11.7\bin\mariadb.exe" -u root -p1234 < database\employee_access_system_v2.sql

if %errorlevel% equ 0 (
    echo.
    echo ========================================
    echo SUCCESS!
    echo ========================================
    echo.
    echo Admin Account Created:
    echo   Email: admin@system.local
    echo   Password: admin12345
    echo.
    echo Database is ready! Refresh your browser.
    echo.
) else (
    echo ERROR: Import failed
    exit /b 1
)

pause
