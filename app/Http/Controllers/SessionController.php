<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    // عرض قائمة الحصص (صفحة رئيسية)
    public function index()
    {
        // جلب أحدث الحصص مع تحميل بيانات المعلم
        $sessions = Session::with('teacher')->latest()->paginate(10);

        // عرض الصفحة مع تمرير الحصص
        return view('sessions.index', compact('sessions'));
    }

    // عرض نموذج إنشاء حصة جديدة
    public function create()
    {
        // جلب جميع المعلمين لإختيار واحد منهم في النموذج
        $teachers = \App\Models\Teacher::all();

        // عرض صفحة الإضافة مع المعلمين
        return view('sessions.create', compact('teachers'));
    }

    // حفظ الحصة الجديدة
    public function store(Request $request)
    {
        // تحقق من صحة البيانات
        $data = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'nullable',
            'subject' => 'required|string|max:255',
        ]);

        // إنشاء الحصة في قاعدة البيانات
        Session::create($data);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('sessions.index')->with('success', 'تم إنشاء الحصة بنجاح');
    }

    // عرض صفحة تسجيل حضور الحصة
    public function attendance($id)
    {
        // جلب الحصة مع المعلم
        $session = Session::with('teacher')->findOrFail($id);

        // جلب كل الطلاب (يمكن تضيف فلترة حسب تخصص أو مستوى حسب حاجتك)
        $students = Student::all();

        // جلب الحضور السابق إن وجد للحصة
        $attendances = Attendance::where('session_id', $id)->get()->keyBy('student_id');

        // عرض صفحة تسجيل الحضور مع البيانات المطلوبة
        return view('sessions.attendance', compact('session', 'students', 'attendances'));
    }

    // حفظ حالة الحضور للطلاب في الحصة
    public function markAttendance(Request $request, $id)
    {
        // تحقق من البيانات القادمة
        $data = $request->validate([
            'attendances' => 'required|array',
            'attendances.*.student_id' => 'required|exists:students,id',
            'attendances.*.status' => 'required|in:حاضر,غائب,متأخر',
            'attendances.*.notes' => 'nullable|string',
        ]);

        // لكل طالب من الطلاب نحدث أو ننشئ حالة الحضور
        foreach ($data['attendances'] as $att) {
            Attendance::updateOrCreate(
                [
                    'session_id' => $id,
                    'student_id' => $att['student_id'],
                ],
                [
                    'status' => $att['status'],
                    'notes' => $att['notes'] ?? null,
                ]
            );
        }

        // إعادة توجيه مع رسالة نجاح
        return redirect()->route('sessions.index')->with('success', 'تم تسجيل الحضور بنجاح');
    }
}
