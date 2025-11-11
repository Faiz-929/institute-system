#!/bin/bash

echo "🚀 بدء تشغيل نظام إدارة المعهد - قسم الدرجات المطور"
echo "=================================================="

# التحقق من وجود PHP
if ! command -v php &> /dev/null; then
    echo "❌ PHP غير مثبت. يرجى تثبيت PHP أولاً."
    exit 1
fi

# التحقق من وجود Composer
if ! command -v composer &> /dev/null; then
    echo "❌ Composer غير مثبت. يرجى تثبيت Composer أولاً."
    exit 1
fi

echo "✅ PHP و Composer متوفران"

# تثبيت الاعتمادات
echo "📦 تثبيت الاعتمادات..."
composer install --no-dev --optimize-autoloader

# نسخ ملف البيئة إذا لم يكن موجوداً
if [ ! -f .env ]; then
    echo "📄 إنشاء ملف البيئة..."
    cp .env.example .env
fi

# توليد مفتاح التطبيق
echo "🔑 توليد مفتاح التطبيق..."
php artisan key:generate --force

# تشغيل migrations
echo "🗄️  تشغيل قاعدة البيانات..."
php artisan migrate --force

# تشغيل seeders
echo "🌱 إضافة البيانات التجريبية..."
php artisan db:seed --force

# تحسين الأداء
echo "⚡ تحسين الأداء..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# تشغيل الخادم
echo "🌐 تشغيل الخادم..."
echo "✨ يمكنك الوصول للموقع على: http://localhost:8000"
echo "🔐 بيانات الدخول:"
echo "   المدير: admin@institute.com / admin123"
echo "   معلم: ahmed@institute.com / teacher123"
echo ""
echo "📊 قسم الدرجات: http://localhost:8000/grades"
echo "📈 التقارير: http://localhost:8000/grades/reports"
echo ""
echo "🛑 لإيقاف الخادم: اضغط Ctrl+C"
echo "=================================================="

php artisan serve --host=0.0.0.0 --port=8000