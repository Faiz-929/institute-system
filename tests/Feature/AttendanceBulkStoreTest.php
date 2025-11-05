<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;

class AttendanceBulkStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_bulk_store_validation_rejects_invalid_status()
    {
        $user = User::factory()->create();

        $teacher = Teacher::create([
            'name' => 'Teacher B',
            'qualification' => 'BSc',
            'subject' => 'Science',
            'phone' => '0987654321'
        ]);

        $s1 = Student::create(['name' => 'S1']);
        $s2 = Student::create(['name' => 'S2']);

        $payload = [
            'attendance_data' => [
                ['student_id' => $s1->id, 'status' => 'حاضر'],
                ['student_id' => $s2->id, 'status' => 'INVALID_STATUS']
            ],
            'teacher_id' => $teacher->id,
            'subject_name' => 'Science',
            'class_name' => 'C',
            'session_date' => '2025-11-05',
            'session_time' => '09:00'
        ];

        $response = $this->actingAs($user)->postJson(route('attendance.bulk-store'), $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['attendance_data.1.status']);
    }
}
