#!/bin/bash

# ============================================
# Quick Fix Script for 500 Error
# LMS Rumba Athaya - cPanel Deployment
# Run this from public_html directory
# ============================================

echo "🔧 Starting Quick Fix for 500 Error..."
echo ""

# Get current directory
CURRENT_DIR=$(pwd)
echo "📁 Current directory: $CURRENT_DIR"
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
php artisan optimize:clear 2>/dev/null || echo "Optimize clear skipped"
echo "✅ Cache cleared"
echo ""

# 3. Set correct permissions
echo "3️⃣ Setting file permissions..."
chmod -R 775 ../storage 2>/dev/null || chmod -R 775 storage
chmod -R 775 ../bootstrap/cache 2>/dev/null || chmod -R 775 bootstrap/cache
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
php artisan migrate:status 2>&1 | head -10
echo ""

# 7. Show Laravel version
echo "7️⃣ Laravel version:"
php artisan --version
echo ""

echo "✅ Quick fix completed!"
echo ""
echo "🔍 Next steps:"
echo "1. Refresh your website: https://rumbaathaya.id"
echo "2. If still error, check error logs"
echo "3. Make sure APP_DEBUG=false in .env for production"
echo ""
