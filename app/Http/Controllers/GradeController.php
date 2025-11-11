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

        // فلترة حسب الفصل
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        // فلترة حسب السنة
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        // فلترة حسب الحالة (ناجح/راسب)
        if ($request->filled('status')) {
            if ($request->status === 'pass') {
                $query->where('total', '>=', 50);
            } elseif ($request->status === 'fail') {
                $query->where('total', '<', 50);
            }
        }

        // فلترة حسب الطالب
        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        // فلترة حسب المادة
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        // فلترة حسب المعلم
        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        $grades = $query->orderBy('created_at', 'desc')->paginate(15);

        // جلب البيانات للفلاتر
        $students = Student::all();
        $subjects = Subject::all();
        $teachers = User::where('role', 'teacher')->get();

        return view('grades.index', compact('grades', 'students', 'subjects', 'teachers'));
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
        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
            'semester' => 'required|string|max:50',
            'year' => 'required|numeric|min:2020|max:' . (date('Y') + 5),
            
            // حقول الدرجات (اختيارية لكن يجب أن تكون بين 0-100)
            'homework1' => 'nullable|numeric|min:0|max:100',
            'participation1' => 'nullable|numeric|min:0|max:100',
            'written_exam1' => 'nullable|numeric|min:0|max:100',
            'homework2' => 'nullable|numeric|min:0|max:100',
            'participation2' => 'nullable|numeric|min:0|max:100',
            'written_exam2' => 'nullable|numeric|min:0|max:100',
            'midterm1' => 'nullable|numeric|min:0|max:100',
            'homework3' => 'nullable|numeric|min:0|max:100',
            'participation3' => 'nullable|numeric|min:0|max:100',
            'written_exam3' => 'nullable|numeric|min:0|max:100',
            'homework4' => 'nullable|numeric|min:0|max:100',
            'participation4' => 'nullable|numeric|min:0|max:100',
            'written_exam4' => 'nullable|numeric|min:0|max:100',
            'final_exam' => 'nullable|numeric|min:0|max:100',
        ], [
            'student_id.required' => 'يجب اختيار الطالب',
            'subject_id.required' => 'يجب اختيار المادة',
            'teacher_id.required' => 'يجب اختيار المعلم',
            'semester.required' => 'يجب إدخال الفصل الدراسي',
            'year.required' => 'يجب إدخال السنة الدراسية',
            '*.numeric' => 'يجب أن تكون الدرجة رقم صحيح',
            '*.min' => 'يجب أن تكون الدرجة أكبر من أو تساوي صفر',
            '*.max' => 'يجب أن تكون الدرجة أصغر من أو تساوي 100'
        ]);

        // التحقق من عدم وجود درجة مكررة لنفس الطالب والمادة والفصل
        $existingGrade = Grade::where([
            'student_id' => $request->student_id,
            'subject_id' => $request->subject_id,
            'semester' => $request->semester,
            'year' => $request->year,
        ])->first();

        if ($existingGrade) {
            return back()
                ->withInput()
                ->withErrors(['duplicate' => 'يوجد بالفعل درجة لهذا الطالب في نفس المادة والفصل الدراسي']);
        }

        // إنشاء الدرجة
        $grade = Grade::create($validatedData);

        return redirect()->route('grades.index')->with('success', 'تم حفظ الدرجة بنجاح');
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

    /**
     * تصدير الدرجات إلى Excel
     */
    public function export(Request $request)
    {
        $query = Grade::with(['student','subject','teacher']);

        // تطبيق نفس الفلاتر من index
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }
        if ($request->filled('status')) {
            if ($request->status === 'pass') {
                $query->where('total', '>=', 50);
            } elseif ($request->status === 'fail') {
                $query->where('total', '<', 50);
            }
        }

        $grades = $query->get();

        // إنشاء ملف Excel
        $filename = 'grades_' . date('Y-m-d') . '.xlsx';
        
        $writer = \Spatie\SimpleExcel\SimpleExcelWriter::streamDownload($filename);
        
        $writer->addRow([
            'رقم الدرجة' => '',
            'اسم الطالب' => '',
            'اسم المادة' => '',
            'المعلم' => '',
            'الواجبات (شهر 1)' => '',
            'المشاركة (شهر 1)' => '',
            'تحريري (شهر 1)' => '',
            'الواجبات (شهر 2)' => '',
            'المشاركة (شهر 2)' => '',
            'تحريري (شهر 2)' => '',
            'النصي' => '',
            'الواجبات (شهر 3)' => '',
            'المشاركة (شهر 3)' => '',
            'تحريري (شهر 3)' => '',
            'الواجبات (شهر 4)' => '',
            'المشاركة (شهر 4)' => '',
            'تحريري (شهر 4)' => '',
            'النهائي' => '',
            'المجموع' => '',
            'الحالة' => '',
            'التقدير' => '',
            'الفصل' => '',
            'السنة' => ''
        ]);

        foreach ($grades as $grade) {
            $writer->addRow([
                'رقم الدرجة' => $grade->id,
                'اسم الطالب' => $grade->student->name,
                'اسم المادة' => $grade->subject->name,
                'المعلم' => $grade->teacher->name,
                'الواجبات (شهر 1)' => $grade->homework1,
                'المشاركة (شهر 1)' => $grade->participation1,
                'تحريري (شهر 1)' => $grade->written_exam1,
                'الواجبات (شهر 2)' => $grade->homework2,
                'المشاركة (شهر 2)' => $grade->participation2,
                'تحريري (شهر 2)' => $grade->written_exam2,
                'النصي' => $grade->midterm1,
                'الواجبات (شهر 3)' => $grade->homework3,
                'المشاركة (شهر 3)' => $grade->participation3,
                'تحريري (شهر 3)' => $grade->written_exam3,
                'الواجبات (شهر 4)' => $grade->homework4,
                'المشاركة (شهر 4)' => $grade->participation4,
                'تحريري (شهر 4)' => $grade->written_exam4,
                'النهائي' => $grade->final_exam,
                'المجموع' => $grade->total,
                'الحالة' => $grade->isPassed() ? 'ناجح' : 'راسب',
                'التقدير' => $grade->grade,
                'الفصل' => $grade->semester,
                'السنة' => $grade->year
            ]);
        }

        return $writer->toBrowser();
    }

    /**
     * تقارير الدرجات
     */
    public function reports(Request $request)
    {
        $stats = [
            'total_grades' => Grade::count(),
            'passed_grades' => Grade::where('total', '>=', 50)->count(),
            'failed_grades' => Grade::where('total', '<', 50)->count(),
            'success_rate' => 0,
            'average_grade' => Grade::avg('total'),
            'top_students' => Student::select('students.*')
                ->join('grades', 'students.id', '=', 'grades.student_id')
                ->groupBy('students.id')
                ->selectRaw('AVG(grades.total) as average_grade')
                ->orderByDesc('average_grade')
                ->take(10)
                ->get(),
        ];

        // حساب نسبة النجاح
        if ($stats['total_grades'] > 0) {
            $stats['success_rate'] = ($stats['passed_grades'] / $stats['total_grades']) * 100;
        }

        // إحصائيات حسب المادة
        $subjectStats = Subject::withCount(['grades' => function($query) {
                $query->where('total', '>=', 50);
            }])
            ->withCount('grades')
            ->get()
            ->map(function($subject) {
                $subject->success_rate = $subject->grades_count > 0 
                    ? ($subject->grades_count / $subject->grades_count) * 100 
                    : 0;
                return $subject;
            });

        return view('grades.reports', compact('stats', 'subjectStats'));
    }

    /**
     * عرض إحصائيات طالب محدد
     */
    public function studentStats(Student $student)
    {
        $grades = $student->grades()->with('subject')->get();
        
        $stats = [
            'total_subjects' => $grades->count(),
            'passed_subjects' => $grades->where('total', '>=', 50)->count(),
            'failed_subjects' => $grades->where('total', '<', 50)->count(),
            'average_grade' => $grades->avg('total'),
            'grades' => $grades->sortByDesc('total')
        ];

        if ($stats['total_subjects'] > 0) {
            $stats['success_rate'] = ($stats['passed_subjects'] / $stats['total_subjects']) * 100;
        }

        return view('grades.student-stats', compact('student', 'stats'));
    }
}
