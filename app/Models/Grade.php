<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id','subject_id','teacher_id',
        'homework1','participation1','written_exam1',
        'homework2','participation2','written_exam2',
        'midterm1',
        'homework3','participation3','written_exam3',
        'homework4','participation4','written_exam4',
        'final_exam','total','semester','year'
    ];

    // العلاقات
    public function student()  { return $this->belongsTo(Student::class); }
    public function subject()  { return $this->belongsTo(Subject::class); }
    public function teacher()  { return $this->belongsTo(User::class, 'teacher_id'); }

    // دالة لحساب المجموع الكلي
    public function calculateTotal()
    {
        $this->total = $this->homework1 + $this->participation1 + $this->written_exam1
            + $this->homework2 + $this->participation2 + $this->written_exam2
            + $this->midterm1
            + $this->homework3 + $this->participation3 + $this->written_exam3
            + $this->homework4 + $this->participation4 + $this->written_exam4
            + $this->final_exam;

        return $this;
    }
}
