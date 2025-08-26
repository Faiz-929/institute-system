<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'date',
        'start_time',
        'end_time',
        'subject',
    ];

    // علاقة الحصة مع المعلم
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // علاقة الحصة مع الحضور
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
