<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $query = Grade::with(['student','subject','teacher']);

        // فلترة حسب الفصل أو السنة
        if ($request->filled('semester')) $query->where('semester', $request->semester);
        if ($request->filled('year')) $query->where('year', $request->year);

        $grades = $query->paginate(15);

        return view('grades.index', compact('grades'));
    }

    public function create()
    {
        $students = Student::all();
        $subjects = Subject::all();
        $teachers = User::where('role', 'teacher')->get();

        return view('grades.create', compact('students','subjects','teachers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id'=>'required',
            'subject_id'=>'required',
            'teacher_id'=>'required',
            'semester'=>'required',
            'year'=>'required',
        ]);

        $grade = new Grade($request->all());
        $grade->calculateTotal()->save();

        return redirect()->route('grades.index')->with('success','تم حفظ الدرجات بنجاح');
    }

    public function edit(Grade $grade)
    {
        $students = Student::all();
        $subjects = Subject::all();
        $teachers = User::where('role', 'teacher')->get();

        return view('grades.edit', compact('grade','students','subjects','teachers'));
    }

    public function update(Request $request, Grade $grade)
    {
        $grade->update($request->all());
        $grade->calculateTotal()->save();

        return redirect()->route('grades.index')->with('success','تم تعديل الدرجة بنجاح');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();
        return redirect()->route('grades.index')->with('success','تم حذف الدرجة');
    }
}
