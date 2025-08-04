<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::latest()->paginate(10);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
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
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }

        Student::create($data);
        return redirect()->route('students.index')->with('success', 'تمت إضافة الطالب بنجاح');
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
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
        ]);

        if ($request->hasFile('photo')) {
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }

        $student->update($data);
        return redirect()->route('students.index')->with('success', 'تم تحديث بيانات الطالب');
    }

    public function destroy(Student $student)
    {
        if ($student->photo) {
            Storage::disk('public')->delete($student->photo);
        }

        $student->delete();
        return redirect()->route('students.index')->with('success', 'تم حذف الطالب');
    }
}
