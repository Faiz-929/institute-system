#!/bin/bash

# 📝 غيّر هذا الرابط إلى رابط مستودعك على GitHub
REPO_URL="https://github.com/Faiz-929/institute-system.git"

# ✅ تحقق أنك داخل مجلد مشروع Laravel
if [ ! -f artisan ]; then
  echo "🚫 هذا ليس مشروع Laravel (ملف artisan غير موجود)"
  exit 1
fi

# 🧱 التهيئة الأولية
git init
git add .
git commit -m "Initial Laravel commit"

# ⛓️ ربط GitHub
git branch -M main
git remote add origin "$REPO_URL"

# 🚀 رفع المشروع
git push -u origin main

echo "✅ تم رفع المشروع بنجاح إلى GitHub!"
