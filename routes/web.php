<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Models\Teacher;
use Spatie\Health\Http\Controllers\HealthCheckResultsController;
use Spatie\Health\Models\HealthCheckResultHistoryItem;

Route::get('/', function () {
    return view('welcome'); // الصفحة الرئيسية
});
Route::get('/health', HealthCheckResultsController::class);
Route::get('/my-health', function () {
    $result = HealthCheckResultHistoryItem::latest()->first();

    if (! $result) {
        return '🚫 لا توجد نتائج حتى الآن، جرّب تشغيل: php artisan health:check';
    }

    return view('my-health', ['result' => $result]);
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

    // المسار الخاص بطباعة الطلاب

    Route::get('students/print', [StudentController::class, 'print'])->name('students.print');

    // المسارات الخاصة بالطلاب (CRUD)
    Route::resource('students', StudentController::class);

    

});

// إدارة الملف الشخصي للمستخدم
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// مصادقة Laravel Breeze / Jetstream
require __DIR__.'/auth.php';
