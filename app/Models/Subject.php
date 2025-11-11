<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'grade_level',
        'credit_hours',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'credit_hours' => 'integer',
    ];

    // العلاقات
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'subject_teacher');
    }

    // دوال مساعدة
    public function getAverageGradeAttribute()
    {
        return $this->grades()->avg('total') ?? 0;
    }

    public function getPassedStudentsCountAttribute()
    {
        return $this->grades()->where('total', '>=', 50)->count();
    }

    public function getTotalStudentsCountAttribute()
    {
        return $this->grades()->count();
    }

    public function getSuccessRateAttribute()
    {
        $total = $this->total_students_count;
        return $total > 0 ? ($this->passed_students_count / $total) * 100 : 0;
    }

    // Accessor للاسم
    public function getDisplayNameAttribute()
    {
        return $this->code ? "{$this->name} ({$this->code})" : $this->name;
    }
}