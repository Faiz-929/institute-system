<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // عرض صفحة تسجيل الحضور
    public function index()
    {
        $students = Student::with('fees')->orderBy('name')->get();
        $teachers = Teacher::orderBy('name')->get();
        $today = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i');
        
        return view('attendance.index', compact('students', 'teachers', 'today', 'currentTime'));
    }

    // تسجيل حضور أو غياب لطالب واحد
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'teacher_id' => 'required|exists:teachers,id',
            'subject_name' => 'required|string|max:255',
            'class_name' => 'required|string|max:255',
            'session_date' => 'required|date',
            'session_time' => 'required',
            'status' => 'required|in:حاضر,غائب,متأخر,مُعفى',
            'absence_reason' => 'nullable|string|max:255',
            'late_minutes' => 'nullable|integer|min:0',
            'notes' => 'nullable|string'
        ]);

        try {
            // التحقق من عدم وجود سجل مكرر
            $existing = Attendance::where([
                'student_id' => $request->student_id,
                'subject_name' => $request->subject_name,
                'session_date' => $request->session_date,
                'session_time' => $request->session_time
            ])->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'تم تسجيل حضور/غياب لهذا الطالب في هذه الحصة مسبقاً'
                ], 400);
            }

            Attendance::create([
                'student_id' => $request->student_id,
                'teacher_id' => $request->teacher_id,
                'subject_name' => $request->subject_name,
                'class_name' => $request->class_name,
                'session_date' => $request->session_date,
                'session_time' => $request->session_time,
                'status' => $request->status,
                'absence_reason' => $request->absence_reason,
                'late_minutes' => $request->late_minutes,
                'notes' => $request->notes,
                'recorded_by' => auth()->check() && auth()->user()->role === 'admin' ? 'admin' : 'teacher'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم تسجيل الحضور بنجاح'
            ]);

        } catch (\Exception $e) {
            Log::error('Attendance store error', ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تسجيل الحضور'
            ], 500);
        }
    }

    // تسجيل حضور جماعي لفصل كامل
    public function bulkStore(Request $request): JsonResponse
    {
        $request->validate([
            'attendance_data' => 'required|array',
            'attendance_data.*.student_id' => 'required|exists:students,id',
            'attendance_data.*.status' => 'nullable|in:حاضر,غائب,متأخر,مُعفى',
            'attendance_data.*.late_minutes' => 'nullable|integer|min:0',
            'attendance_data.*.absence_reason' => 'nullable|string|max:255',
            'teacher_id' => 'required|exists:teachers,id',
            'subject_name' => 'required|string|max:255',
            'class_name' => 'required|string|max:255',
            'session_date' => 'required|date',
            'session_time' => 'required'
        ]);

        try {
            DB::beginTransaction();
            
            $successCount = 0;
            $errors = [];

            foreach ($request->attendance_data as $data) {
                try {
                    // التحقق من عدم وجود سجل مكرر
                    $existing = Attendance::where([
                        'student_id' => $data['student_id'],
                        'subject_name' => $request->subject_name,
                        'session_date' => $request->session_date,
                        'session_time' => $request->session_time
                    ])->first();

                    if ($existing) {
                        $errors[] = "تم تسجيل حضور/غياب للطالب " . $data['student_id'] . " مسبقاً";
                        continue;
                    }

                    Attendance::create([
                        'student_id' => $data['student_id'],
                        'teacher_id' => $request->teacher_id,
                        'subject_name' => $request->subject_name,
                        'class_name' => $request->class_name,
                        'session_date' => $request->session_date,
                        'session_time' => $request->session_time,
                        'status' => $data['status'] ?? 'حاضر',
                        'absence_reason' => $data['absence_reason'] ?? null,
                        'late_minutes' => $data['late_minutes'] ?? null,
                        'notes' => $data['notes'] ?? null,
                        'recorded_by' => 'teacher'
                    ]);

                    $successCount++;
                } catch (\Exception $e) {
                    // Log full exception server-side, store a generic message for client
                    Log::error('Attendance bulkStore error for student '.$data['student_id'], ['exception' => $e]);
                    $errors[] = "خطأ في تسجيل الطالب " . $data['student_id'] . ": حدث خطأ داخلي";
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "تم تسجيل حضور {$successCount} طالب بنجاح",
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Attendance bulkStore transaction failed', ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تسجيل الحضور الجماعي'
            ], 500);
        }
    }

    // عرض تقارير الحضور
    public function reports(Request $request)
    {
        $reportType = $request->get('type', 'daily'); // daily, weekly, monthly, student
        $date = $request->get('date', Carbon::now()->format('Y-m-d'));
        $studentId = $request->get('student_id');
        $subject = $request->get('subject');
        $teacherId = $request->get('teacher_id');

        $data = [];
        
        switch ($reportType) {
            case 'daily':
                $data = $this->getDailyReport($date, $subject, $teacherId);
                break;
            case 'student':
                $data = $this->getStudentReport($studentId, $subject);
                break;
            case 'teacher':
                $data = $this->getTeacherReport($teacherId, $date);
                break;
            default:
                $data = $this->getDailyReport($date);
        }

        $students = Student::orderBy('name')->get();
        $teachers = Teacher::orderBy('name')->get();
        
        return view('attendance.reports', compact('data', 'reportType', 'date', 'studentId', 'subject', 'teacherId', 'students', 'teachers'));
    }

    // تقرير يومي
    private function getDailyReport($date, $subject = null, $teacherId = null)
    {
        $query = Attendance::with(['student', 'teacher'])
                          ->whereDate('session_date', $date);
        
        if ($subject) {
            $query->where('subject_name', $subject);
        }
        
        if ($teacherId) {
            $query->where('teacher_id', $teacherId);
        }
        
        return $query->orderBy('session_time')->get();
    }

    // تقرير طالب
    private function getStudentReport($studentId, $subject = null)
    {
        $query = Attendance::with('teacher')
                          ->where('student_id', $studentId);
        
        if ($subject) {
            $query->where('subject_name', $subject);
        }
        
        $attendances = $query->orderBy('session_date', 'desc')->get();
        $stats = Attendance::getAttendanceStats($studentId, null, $subject);
        
        return [
            'attendances' => $attendances,
            'stats' => $stats
        ];
    }

    // تقرير معلم
    private function getTeacherReport($teacherId, $date)
    {
        return Attendance::with('student')
                        ->where('teacher_id', $teacherId)
                        ->whereDate('session_date', $date)
                        ->get();
    }

    // الحصول على إحصائيات الحضور
    public function getStats(Request $request): JsonResponse
    {
        $studentId = $request->get('student_id');
        $teacherId = $request->get('teacher_id');
        $subject = $request->get('subject');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        try {
            // Let the model compute stats; pass date range to include date filtering
            $stats = Attendance::getAttendanceStats($studentId, $teacherId, $subject, $dateFrom, $dateTo);

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في جلب الإحصائيات'
            ], 500);
        }
    }

    // تصدير تقرير الحضور
    public function export(Request $request)
    {
        $reportType = $request->get('type', 'daily');
        // منطق التصدير سيوضع هنا
        // يمكن تصدير Excel, PDF, CSV
        
        return response()->json([
            'success' => true,
            'message' => 'سيتم تطبيق ميزة التصدير قريباً'
        ]);
    }
}
