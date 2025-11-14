<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Grade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GradeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // إنشاء مستخدم للمصادقة
        $this->user = User::factory()->create([
            'role' => 'teacher'
        ]);
        
        $this->actingAs($this->user);
    }

    #[Test]
    public function can_create_grade(): void
    {
        // إنشاء بيانات اختبار
        $student = Student::factory()->create();
        $subject = Subject::factory()->create();
        $teacher = User::factory()->create(['role' => 'teacher']);

        $gradeData = [
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'teacher_id' => $teacher->id,
            'semester' => 'الأول',
            'year' => '2025',
            'homework1' => 85,
            'participation1' => 90,
            'written_exam1' => 88,
            'homework2' => 82,
            'participation2' => 85,
            'written_exam2' => 80,
            'midterm1' => 87,
            'homework3' => 90,
            'participation3' => 92,
            'written_exam3' => 89,
            'homework4' => 88,
            'participation4' => 86,
            'written_exam4' => 84,
            'final_exam' => 91
        ];

        // إرسال طلب إنشاء
        $response = $this->post('/grades', $gradeData);

        // التحقق من التوجيه
        $response->assertRedirect(route('grades.index'));
        
        // التحقق من وجود الدرجة في قاعدة البيانات
        $this->assertDatabaseHas('grades', [
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'teacher_id' => $teacher->id,
            'semester' => 'الأول',
            'year' => '2025'
        ]);

        // التحقق من أن المجموع تم حسابه بشكل صحيح
        $grade = Grade::where([
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'semester' => 'الأول',
            'year' => '2025'
        ])->first();
        
        $expectedTotal = 85 + 90 + 88 + 82 + 85 + 80 + 87 + 90 + 92 + 89 + 88 + 86 + 84 + 91;
        $this->assertEquals($expectedTotal, $grade->total);
    }

    #[Test]
    public function grade_total_cannot_exceed_100(): void
    {
        $student = Student::factory()->create();
        $subject = Subject::factory()->create();
        $teacher = User::factory()->create(['role' => 'teacher']);

        $gradeData = [
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'teacher_id' => $teacher->id,
            'semester' => 'الأول',
            'year' => '2025',
            'homework1' => 100,
            'participation1' => 100,
            'written_exam1' => 100,
            'homework2' => 100,
            'participation2' => 100,
            'written_exam2' => 100,
            'midterm1' => 100,
            'homework3' => 100,
            'participation3' => 100,
            'written_exam3' => 100,
            'homework4' => 100,
            'participation4' => 100,
            'written_exam4' => 100,
            'final_exam' => 100
        ];

        $response = $this->post('/grades', $gradeData);
        
        $grade = Grade::first();
        $this->assertEquals(100, $grade->total);
    }

    #[Test]
    public function cannot_create_duplicate_grade(): void
    {
        $student = Student::factory()->create();
        $subject = Subject::factory()->create();
        $teacher = User::factory()->create(['role' => 'teacher']);

        // إنشاء درجة أولى
        Grade::factory()->create([
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'semester' => 'الأول',
            'year' => '2025'
        ]);

        // محاولة إنشاء درجة مكررة
        $gradeData = [
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'teacher_id' => $teacher->id,
            'semester' => 'الأول',
            'year' => '2025'
        ];

        $response = $this->post('/grades', $gradeData);
        
        $response->assertSessionHasErrors(['duplicate']);
    }

    #[Test]
    public function grade_filtering_works(): void
    {
        $student = Student::factory()->create();
        $subject = Subject::factory()->create();
        $teacher = User::factory()->create(['role' => 'teacher']);

        // إنشاء درجات متنوعة
        Grade::factory()->create([
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'teacher_id' => $teacher->id,
            'semester' => 'الأول',
            'year' => '2025',
            'total' => 85 // ناجح
        ]);

        Grade::factory()->create([
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'teacher_id' => $teacher->id,
            'semester' => 'الثاني',
            'year' => '2025',
            'total' => 45 // راسب
        ]);

        // اختبار فلتر النجاح
        $response = $this->get('/grades?status=pass');
        $response->assertViewIs('grades.index');
        $response->assertSee('ناجح');

        // اختبار فلتر الرسوب
        $response = $this->get('/grades?status=fail');
        $response->assertSee('راسب');
    }
}