<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Models\Teacher;

Route::get('/', function () {
    return view('welcome'); // الصفحة الرئيسية
});

Route::middleware(['auth'])->group(function () {
    // لوحة التحكم
    Route::get('/dashboard', function () {
        // حساب عدد المعلمين
        $teachersCount = Teacher::count();
        // جلب آخر 5 معلمين
        $latestTeachers = Teacher::latest()->take(5)->get();

        return view('dashboard', compact('teachersCount', 'latestTeachers'));
    })->name('dashboard');

    // المسارات الخاصة بالمعلمين (CRUD)
    Route::resource('teachers', TeacherController::class);

    // المسارات الخاصة بالطلاب (CRUD)
    Route::resource('students', StudentController::class);

    // ✅ تم حذف أي روابط تخص الحصص أو الحضور/الغياب
});

// إدارة الملف الشخصي للمستخدم
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// مصادقة Laravel Breeze / Jetstream
require __DIR__.'/auth.php';
