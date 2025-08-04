<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    // عرض قائمة المعلمين
    public function index()
    {
        $teachers = Teacher::latest()->get();
        return view('teachers.index', compact('teachers'));
    }

    // عرض نموذج الإضافة
    public function create()
    {
        return view('teachers.create');
    }

    // حفظ معلم جديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'home_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        Teacher::create($validated);

        return redirect()->route('teachers.index')->with('success', 'تمت إضافة المعلم بنجاح.');
    }

    // عرض نموذج التعديل
    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    // تحديث معلومات معلم
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'home_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $teacher->update($validated);

        return redirect()->route('teachers.index')->with('success', 'تم تعديل بيانات المعلم بنجاح.');
    }

    // حذف معلم
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'تم حذف المعلم بنجاح.');
    }
}
