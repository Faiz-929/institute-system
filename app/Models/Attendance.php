<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'student_id',
        'status',
        'notes',
    ];

    // علاقة الحضور بالحصة
    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    // علاقة الحضور بالطالب
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
