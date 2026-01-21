@echo off
REM Admin Panel Installation Script for Windows
REM This script automates the installation of the Admin Panel

echo ╔════════════════════════════════════════╗
echo ║   Laravel Admin Panel Installation    ║
echo ╔════════════════════════════════════════╗
echo.

REM Check if .env exists
if not exist .env (
    echo ⚠️  .env file not found. Copying from .env.example...
    copy .env.example .env
    php artisan key:generate
)

REM Install Composer dependencies
echo 📦 Installing Composer dependencies...
call composer install --no-interaction

REM Install NPM dependencies
echo 📦 Installing NPM dependencies...
call npm install

REM Install Alpine.js collapse plugin
echo 📦 Installing Alpine.js plugins...
call npm install @alpinejs/collapse

REM Run migrations
echo 🗄️  Running database migrations...
php artisan migrate

REM Seed the database
echo 🌱 Seeding database...
php artisan db:seed

REM Clear caches
echo 🧹 Clearing caches...
php artisan cache:clear
php artisan config:clear
php artisan view:clear

REM Build assets
echo 🎨 Building assets...
call npm run build

echo.
echo ✅ Installation complete!
echo.
echo ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
echo 📋 Default Admin Credentials:
echo ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
echo    Email: admin@example.com
echo    Password: password
echo.
echo ⚠️  IMPORTANT: Change the password after first login!
echo ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
echo.
echo 🚀 To start the application:
echo    php artisan serve
echo    npm run dev (in another terminal)
echo.
echo 🌐 Admin Panel URL:
echo    http://localhost:8000/admin/login
echo.
echo 📚 Read ADMIN_PANEL_README.md for detailed documentation
echo.

pause
