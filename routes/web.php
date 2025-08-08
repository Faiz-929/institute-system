<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Models\Teacher;

Route::get('/', function () {
    return view ('welcome');
});

Route::middleware(['auth'])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
    // تجربة
    Route::get('/dashboard', function () {
    $teachersCount = Teacher::count();
    $latestTeachers = Teacher::latest()->take(5)->get();

    return view('dashboard', compact('teachersCount', 'latestTeachers'));
})->name('dashboard');

    Route::resource('teachers', TeacherController::class);
    Route::resource('students', StudentController::class);
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
