<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Attendance;

class AttendanceStatsTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_attendance_stats_with_date_range()
    {
        $student = Student::create(['name' => 'Student A']);
        $teacher = Teacher::create([
            'name' => 'Teacher A',
            'qualification' => 'Diploma',
            'subject' => 'Math',
            'phone' => '123456789'
        ]);

        // older session (outside range)
        Attendance::create([
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'subject_name' => 'Math',
            'class_name' => 'A',
            'session_date' => '2025-10-01',
            'session_time' => '10:00',
            'status' => 'حاضر'
        ]);

        // within range: present
        Attendance::create([
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'subject_name' => 'Math',
            'class_name' => 'A',
            'session_date' => '2025-11-01',
            'session_time' => '10:00',
            'status' => 'حاضر'
        ]);

        // within range: absent
        Attendance::create([
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'subject_name' => 'Math',
            'class_name' => 'A',
            'session_date' => '2025-11-02',
            'session_time' => '10:00',
            'status' => 'غائب'
        ]);

        $stats = Attendance::getAttendanceStats($student->id, null, 'Math', '2025-11-01', '2025-11-30');

        $this->assertEquals(2, $stats['total']);
        $this->assertEquals(1, $stats['present']);
        $this->assertEquals(1, $stats['absent']);
        $this->assertEquals(0, $stats['late']);
        $this->assertEquals(0, $stats['excused']);
        $this->assertEquals(50.0, $stats['percentage']);
    }
}
