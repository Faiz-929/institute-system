<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    // عرض قائمة الطلاب
    public function index()
    {
        $students = Student::latest()->paginate(10);
        return view('students.index', compact('students'));
    }

    // عرض فورم إضافة طالب جديد
    public function create()
    {
        return view('students.create');
    }

    // تخزين بيانات الطالب الجديد
    public function store(Request $request)
    {
        // ✅ تحقق من صحة البيانات القادمة من الفورم
        $data = $request->validate([
            'name' => 'required',
            'status' => 'nullable',
            'gender' => 'nullable',
            'photo' => 'nullable|image|max:2048',
            'address' => 'nullable',
            'home_phone' => 'nullable',
            'mobile_phone' => 'nullable',
            'level' => 'nullable',
            'major' => 'nullable',
            'notes' => 'nullable',

            // ✅ الحقول الجديدة (ولي الأمر)
            'parent_name' => 'nullable|string|max:255',
            'parent_mobile' => 'nullable|string|max:20',
            'parent_whatsapp' => 'nullable|string|max:20',
            'parent_home_phone' => 'nullable|string|max:20',
            'parent_job' => 'nullable|string|max:255',
        ]);

        // ✅ رفع الصورة إذا تم رفعها
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }

        // ✅ إنشاء الطالب
        Student::create($data);

        return redirect()->route('students.index')->with('success', 'تمت إضافة الطالب بنجاح');
    }

    // عرض فورم تعديل بيانات طالب
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    // تحديث بيانات الطالب
    public function update(Request $request, Student $student)
    {
        // ✅ تحقق من صحة البيانات
        $data = $request->validate([
            'name' => 'required',
            'status' => 'nullable',
            'gender' => 'nullable',
            'photo' => 'nullable|image|max:2048',
            'address' => 'nullable',
            'home_phone' => 'nullable',
            'mobile_phone' => 'nullable',
            'level' => 'nullable',
            'major' => 'nullable',
            'notes' => 'nullable',

            // ✅ الحقول الجديدة (ولي الأمر)
            'parent_name' => 'nullable|string|max:255',
            'parent_mobile' => 'nullable|string|max:20',
            'parent_whatsapp' => 'nullable|string|max:20',
            'parent_home_phone' => 'nullable|string|max:20',
            'parent_job' => 'nullable|string|max:255',
        ]);

        // ✅ تحديث الصورة إن وُجدت
        if ($request->hasFile('photo')) {
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }

        // ✅ تحديث بيانات الطالب
        $student->update($data);

        return redirect()->route('students.index')->with('success', 'تم تحديث بيانات الطالب');
    }
    
    // عرض بيانات الطالب و ولي الامر
        public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }


    // حذف الطالب
    public function destroy(Student $student)
    {
        if ($student->photo) {
            Storage::disk('public')->delete($student->photo);
        }

        $student->delete();
        return redirect()->route('students.index')->with('success', 'تم حذف الطالب');
    }
}
