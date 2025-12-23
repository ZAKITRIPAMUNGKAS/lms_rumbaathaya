#!/bin/bash

# ============================================
# Quick Fix Script for 500 Error
# LMS Rumba Athaya - cPanel Deployment
# ============================================

echo "🔧 Starting Quick Fix for 500 Error..."
echo ""

# Change to application directory
# GANTI 'lms_rumba' dengan nama folder aplikasi Anda
cd /home/username/lms_rumba || exit

echo "📁 Current directory: $(pwd)"
echo ""

# 1. Generate Application Key
echo "1️⃣ Generating application key..."
php artisan key:generate --force
echo "✅ Key generated"
echo ""

# 2. Clear all cache
echo "2️⃣ Clearing all cache..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
echo "✅ Cache cleared"
echo ""

# 3. Set correct permissions
echo "3️⃣ Setting file permissions..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache
echo "✅ Permissions set"
echo ""

# 4. Create storage link
echo "4️⃣ Creating storage link..."
php artisan storage:link
echo "✅ Storage link created"
echo ""

# 5. Cache config for production
echo "5️⃣ Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "✅ Configuration cached"
echo ""

# 6. Test database connection
echo "6️⃣ Testing database connection..."
php artisan migrate:status
echo ""

# 7. Show Laravel version
echo "7️⃣ Laravel version:"
php artisan --version
echo ""

echo "✅ Quick fix completed!"
echo ""
echo "🔍 Next steps:"
echo "1. Refresh your website: https://rumbaathaya.id"
echo "2. If still error, check: storage/logs/laravel.log"
echo "3. Make sure APP_DEBUG=false in .env for production"
echo ""
