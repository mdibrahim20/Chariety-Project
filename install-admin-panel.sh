#!/bin/bash

# Admin Panel Installation Script
# This script automates the installation of the Admin Panel

echo "╔════════════════════════════════════════╗"
echo "║   Laravel Admin Panel Installation    ║"
echo "╔════════════════════════════════════════╗"
echo ""

# Check if .env exists
if [ ! -f .env ]; then
    echo "⚠️  .env file not found. Copying from .env.example..."
    cp .env.example .env
    php artisan key:generate
fi

# Install Composer dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-interaction

# Install NPM dependencies
echo "📦 Installing NPM dependencies..."
npm install

# Install Alpine.js collapse plugin
echo "📦 Installing Alpine.js plugins..."
npm install @alpinejs/collapse

# Run migrations
echo "🗄️  Running database migrations..."
php artisan migrate

# Seed the database
echo "🌱 Seeding database..."
php artisan db:seed

# Clear caches
echo "🧹 Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Build assets
echo "🎨 Building assets..."
npm run build

echo ""
echo "✅ Installation complete!"
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "📋 Default Admin Credentials:"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "   Email: admin@example.com"
echo "   Password: password"
echo ""
echo "⚠️  IMPORTANT: Change the password after first login!"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""
echo "🚀 To start the application:"
echo "   php artisan serve"
echo "   npm run dev (in another terminal)"
echo ""
echo "🌐 Admin Panel URL:"
echo "   http://localhost:8000/admin/login"
echo ""
echo "📚 Read ADMIN_PANEL_README.md for detailed documentation"
echo ""
