<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'gender',
        'photo',
        'address',
        'home_phone',
        'mobile_phone',
        'level',
        'major',
        'notes',
         // ✅ الحقول الجديدة
        'parent_name',
        'parent_mobile',
        'parent_whatsapp',
        'parent_home_phone',
        'parent_job',
    ];
    
public function fees() {
    return $this->hasMany(\App\Models\StudentFee::class);
}

public function grades()
{
    return $this->hasMany(Grade::class);
}

// دوال مساعدة لحساب الإحصائيات
public function getAverageGradeAttribute()
{
    return $this->grades()->avg('total') ?? 0;
}

public function getPassedGradesCountAttribute()
{
    return $this->grades()->where('total', '>=', 50)->count();
}

public function getTotalGradesCountAttribute()
{
    return $this->grades()->count();
}

public function getSuccessRateAttribute()
{
    $total = $this->total_grades_count;
    return $total > 0 ? ($this->passed_grades_count / $total) * 100 : 0;
}
}
