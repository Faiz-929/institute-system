<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Models\Teacher;
use Spatie\Health\Http\Controllers\HealthCheckResultsController;
use Spatie\Health\Models\HealthCheckResultHistoryItem;
use App\Http\Controllers\StudentFeeController;
use App\Http\Controllers\FeePaymentController;
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\ConsumableController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\AttendanceController;

Route::get('/', function () {
    return view('welcome'); // الصفحة الرئيسية
});

// (preview route removed) 
// Route::get('/health', HealthCheckResultsController::class);
// Route::get('/my-health', function () {
//     $result = HealthCheckResultHistoryItem::latest()->first();

//     if (! $result) {
//         return '🚫 لا توجد نتائج حتى الآن، جرّب تشغيل: php artisan health:check';
//     }

//     return view('my-health', ['result' => $result]);
// });

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

// 
// تصدير Excel من صفحة الطباعة
Route::get('/students/print/export', [StudentController::class, 'printExport'])
    ->name('students.print.export');
    
// مسار دفعات رسوم الطلاب 
Route::resource('fees', StudentFeeController::class);

    // دفعات الرسوم (مسار متداخل مبسط)
    Route::post('fees/{fee}/payments', [FeePaymentController::class, 'store'])->name('fees.payments.store');
    Route::delete('payments/{payment}', [FeePaymentController::class, 'destroy'])->name('fees.payments.destroy');

    // مسارات الورش
    Route::resource('workshops', WorkshopController::class);

    // مسارات اضافة مواد الورش
    Route::resource('consumables', ConsumableController::class);

    // مسارات الاصول الثابتة
    Route::resource('assets', AssetController::class);

    // مسارات العهد
    Route::resource('assignments', AssignmentController::class);
    
    // مسار الدرجات 
    Route::resource('grades', GradeController::class);

    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/bulk-store', [AttendanceController::class, 'bulkStore'])->name('attendance.bulk-store');
    Route::get('/attendance/reports', [AttendanceController::class, 'reports'])->name('attendance.reports');



    // مسار تقارير الورش
    Route::prefix('reports')->group(function () {
    Route::get('/consumables', [ReportController::class, 'consumablesByWorkshop'])->name('reports.consumables');
    Route::get('/assets', [ReportController::class, 'assetsByWorkshop'])->name('reports.assets');
    Route::get('/assignments', [ReportController::class, 'assignmentsReport'])->name('reports.assignments');
});
});

// إدارة الملف الشخصي للمستخدم
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// مصادقة Laravel Breeze / Jetstream
require __DIR__.'/auth.php';    

